<?php
// Hỏi đáp AI trên cẩm nang: quét data.json (tất cả tình huống), chọn các mục liên quan nhất, gọi OpenRouter
// trả lời CHỈ dựa trên các mục đó. Khoá API nằm ngoài public_html: ~/.cam-nang/openrouter_key.
header('Content-Type: application/json; charset=utf-8');
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');
$home = getenv('HOME') ?: dirname(__DIR__, 4); // /home/<user>
$KEY_FILE = $home . '/.cam-nang/openrouter_key';
$STATE = sys_get_temp_dir() . '/cam-nang-ask';
$MODELS = ['nvidia/nemotron-3-ultra-550b-a55b:free', 'dots-studio/dots-3-note-preview:free']; // Hiếu chốt 07/11: chỉ dùng model free, không nạp credit OpenRouter
$LIMIT_IP = 60; $LIMIT_ALL = 600; // lượt/ngày
function out($a){ echo json_encode($a, JSON_UNESCAPED_UNICODE); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') out(['error' => 'Chỉ nhận POST']);
$in = json_decode(file_get_contents('php://input'), true) ?: [];
$q = trim((string)($in['q'] ?? '')); $scope = (string)($in['scope'] ?? 'all');
if (mb_strlen($q) < 4) out(['error' => 'Câu hỏi quá ngắn']);
if (mb_strlen($q) > 600) $q = mb_substr($q, 0, 600);
// rate limit theo ngày
@mkdir($STATE, 0700, true);
$day = date('Y-m-d'); $ip = preg_replace('/[^0-9a-f.:]/i', '', $_SERVER['REMOTE_ADDR'] ?? 'x');
foreach ([[$STATE . "/$day-$ip", $LIMIT_IP], [$STATE . "/$day-all", $LIMIT_ALL]] as [$f, $lim]) {
    $n = (int)@file_get_contents($f);
    if ($n >= $lim) out(['error' => 'Đã hết lượt hỏi hôm nay. Dùng ô tìm kiếm hoặc thử lại ngày mai.']);
    file_put_contents($f, $n + 1, LOCK_EX);
}
$key = trim((string)@file_get_contents($KEY_FILE));
if ($key === '') out(['error' => 'Máy chủ chưa có khoá API']);
$data = json_decode((string)@file_get_contents(__DIR__ . '/data.json'), true);
if (!$data || empty($data['nodes'])) out(['error' => 'Chưa có dữ liệu cẩm nang']);

function norm($s){ $s = mb_strtolower((string)$s, 'UTF-8');
    if (class_exists('Normalizer')) { $s = Normalizer::normalize($s, Normalizer::FORM_D); $s = preg_replace('/\p{Mn}+/u', '', $s); }
    else { $s = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s); }
    $s = str_replace(['đ','Đ'], 'd', $s); return preg_replace('/[^a-z0-9\s]+/', ' ', $s); }
function toks($s){ $t = preg_split('/\s+/', trim(norm($s))); return array_values(array_filter($t, fn($w) => strlen($w) > 1)); }
$STOP = ['la','va','co','cua','khong','thi','nao','gi','lam','sao','bi','duoc','toi','minh','em','anh','chi','cho','voi','de','da','dang','se','nen','hay','hoac','khi','neu','roi','gio','con','nhu','ve','tu','o','tren','trong','bao','nhieu','the','nay','do','ma','vay','a','ah','ạ','nua','moi','van','cung','rat','qua','lam'];
$qt = array_values(array_diff(toks($q), $STOP)); $qn = norm($q);
// bigram của câu hỏi để thưởng cụm từ
$bi = []; for ($i = 0; $i < count($qt) - 1; $i++) $bi[] = $qt[$i] . ' ' . $qt[$i + 1];
$N = count($data['nodes']); $df = $data['df'] ?? [];
$scored = [];
foreach ($data['nodes'] as $n) {
    if ($scope !== 'all') { $p = $n['pane']; $ok = $scope === 'faq' ? str_starts_with($p, 'faq-') : ($p === $scope || $p === 'faq-' . $scope); if (!$ok) continue; }
    $text = $n['t']; $tf = $n['tf'] ?? []; $s = 0.0;
    foreach ($qt as $w) { $f = $tf[$w] ?? 0; if (!$f) continue; $idf = log(1 + ($N - ($df[$w] ?? 0) + .5) / (($df[$w] ?? 0) + .5)); $s += $idf * ($f * 2.2) / ($f + 1.2 * (0.25 + 0.75 * $n['len'] / max(1, $data['avglen']))); }
    foreach ($bi as $b) if (strpos($text, $b) !== false) $s += 1.5;
    if ($s > 0 && stripos(norm($n['if']), $qn) !== false) $s += 3;
    if ($s > 0) { $hitTitle = 0; foreach ($qt as $w) if (strpos(norm($n['if']), $w) !== false) $hitTitle++; $s += $hitTitle * .8; $scored[] = [$s, $n]; }
}
usort($scored, fn($a, $b) => $b[0] <=> $a[0]);
$top = array_slice($scored, 0, 8);
if (!$top) out(['answer' => 'Chưa thấy mục nào trong cẩm nang khớp câu hỏi này. Thử diễn đạt khác hoặc dùng ô tìm kiếm.', 'hits' => [], 'meta' => '']);
$ctx = ''; $hits = []; $i = 0; $budget = 18000;
foreach ($top as [$s, $n]) { $i++; $hits[] = ['id' => $n['id'], 'score' => round($s, 2)];
    $block = "[$i] ({$n['path']}) " . $n['if'] . "\n"; if (!empty($n['tomtat'])) $block .= 'Trả lời ngắn: ' . $n['tomtat'] . "\n"; if (!empty($n['visao'])) $block .= 'Vì sao: ' . $n['visao'] . "\n";
    foreach (['check' => 'Kiểm tra', 'do' => 'Xử lý', 'avoid' => 'Tránh'] as $k => $lab) if (!empty($n[$k])) $block .= "$lab: " . implode(' | ', $n[$k]) . "\n";
    $block .= 'Loại: ' . ($n['hat'] ?? 'white') . '; Độ tin cậy: ' . ($n['evidence'] ?? '') . '; Nguồn: ' . implode('; ', array_map(fn($x) => ($x['title'] ?? '') . ' ' . ($x['url'] ?? ''), $n['sources'] ?? [])) . "\n\n";
    if (mb_strlen($ctx) + mb_strlen($block) > $budget) break; $ctx .= $block; }
$sys = "Bạn là trưởng nhóm performance marketing 8 năm chạy Google Ads, Meta Ads và làm SEO cho doanh nghiệp vừa và nhỏ ở Việt Nam (phòng khám, bất động sản, giáo dục, bán lẻ, B2B). Người hỏi là nhân viên trong team cần câu trả lời để LÀM NGAY, không cần bài giảng.
CÁCH TRẢ LỜI:
1. Câu đầu tiên là kết luận thẳng: Nên / Không nên / Tuỳ trường hợp, kèm lý do chính trong 1 câu. Câu hỏi mơ hồ thì hiểu theo nghĩa người làm nghề hay hỏi nhất (vd 'chạy tăng like' thường là chạy quảng cáo mục tiêu tương tác/lượt thích Trang, không phải mua like ảo); nếu có 2 nghĩa thì trả lời nghĩa phổ biến trước, nghĩa kia 1-2 câu.
2. Sau đó viết theo đúng việc người hỏi cần, chỉ dùng các phần có ích (bỏ phần không liên quan, không độn): **Khi nào nên / khi nào không** (tình huống cụ thể: ngân sách, giai đoạn tài khoản, ngành, mục tiêu), **Làm thế nào** (từng bước thao tác thật: vào đâu trong giao diện, chọn mục tiêu/cài đặt gì, ngân sách khởi điểm, chạy bao lâu thì đánh giá), **Đo thế nào là ổn** (chỉ số nhìn vào, ngưỡng tham khảo, sau bao lâu thì tắt/tăng), **Sai lầm hay gặp** (kèm hậu quả thật).
3. Đưa 1 ví dụ cụ thể, đặt tiêu đề **Ví dụ minh hoạ (giả định)**, tối đa 3 câu, không trình bày như ca thật của khách; so sánh với phương án thay thế tốt hơn nếu có.
NGUỒN VÀ ĐỘ TIN CẬY: ưu tiên thông tin trong các mục cẩm nang, ghi [số] sau ý lấy từ mục đó. Được bổ sung kinh nghiệm thực tế của người làm nghề nếu cẩm nang thiếu, nhưng ý đó phải ghi [Kinh nghiệm] và không được bịa chính sách, tên tính năng hay số liệu chính thức. Con số không có trong cẩm nang thì ghi rõ là ước lượng thực tế, dao động theo ngành.
Mục loại 'black' hoặc 'gray' (vi phạm, vùng xám): nói rõ rủi ro và hậu quả thật, đưa cách làm đúng thay thế; không hướng dẫn cách lách.
Định dạng: tiêu đề phần in đậm trên dòng riêng, gạch đầu dòng '- ', câu ngắn, tiếng Việt tự nhiên như nói với đồng nghiệp, không mở bài, không kết luận lặp lại, không dùng dấu gạch dài. Độ dài 250-450 từ, viết hết ý trong giới hạn này, không bỏ dở câu cuối.";
$payload = ['models' => $MODELS, 'messages' => [['role' => 'system', 'content' => $sys], ['role' => 'user', 'content' => "CÁC MỤC CẨM NANG:\n\n$ctx\nCÂU HỎI: $q"]], 'temperature' => 0.2, 'max_tokens' => 1900];
$meta = 'Trả lời chỉ từ ' . count($hits) . ' mục cẩm nang được chọn; kiểm lại nguồn gốc trước khi làm việc lớn.';
if (!empty($in['stream'])) {
    // Trả dần từng đoạn (SSE): người dùng thấy chữ sau 1-2 giây thay vì chờ cả bài
    @ini_set('zlib.output_compression', '0'); while (ob_get_level()) ob_end_clean();
    header('Content-Type: text/event-stream; charset=utf-8'); header('X-Accel-Buffering: no'); header('X-LiteSpeed-Cache-Control: no-cache');
    $send = function($ev, $d){ echo "event: $ev\ndata: " . json_encode($d, JSON_UNESCAPED_UNICODE) . "\n\n"; @ob_flush(); flush(); };
    echo ':' . str_repeat(' ', 2048) . "\n\n"; $send('hits', ['hits' => $hits]);
    $payload['stream'] = true; $buf = ''; $model = ''; $got = 0; $err = '';
    $ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
    curl_setopt_array($ch, [CURLOPT_POST => true, CURLOPT_TIMEOUT => 90,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Authorization: Bearer ' . $key, 'HTTP-Referer: https://digicomvn.com', 'X-Title: Cam nang Ads SEO'],
        CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
        CURLOPT_WRITEFUNCTION => function($c, $chunk) use (&$buf, &$model, &$got, &$err, $send) {
            $buf .= $chunk;
            while (($p = strpos($buf, "\n")) !== false) { $line = trim(substr($buf, 0, $p)); $buf = substr($buf, $p + 1);
                if (strpos($line, 'data:') !== 0) continue; $d = trim(substr($line, 5)); if ($d === '[DONE]') continue;
                $j = json_decode($d, true); if (!$j) continue;
                if (!empty($j['error'])) { $err = $j['error']['message'] ?? 'lỗi'; continue; }
                if (!empty($j['model'])) $model = $j['model'];
                $t = $j['choices'][0]['delta']['content'] ?? ''; if ($t !== '') { $got++; $send('t', ['t' => str_replace(['—', '–'], '-', $t)]); } }
            return strlen($chunk); }]);
    curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
    if (!$got) { $j = json_decode($buf, true); $msg = $err ?: ($j['error']['message'] ?? ('HTTP ' . $code));
        $send('t', ['t' => "AI tạm không trả lời được ($msg). Các mục liên quan nhất ở dưới, mở để đọc trực tiếp."]); }
    $send('done', ['meta' => ($model ? "Model: $model. " : '') . $meta]); exit;
}
$ch = curl_init('https://openrouter.ai/api/v1/chat/completions');
curl_setopt_array($ch, [CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 60,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Authorization: Bearer ' . $key, 'HTTP-Referer: https://digicomvn.com', 'X-Title: Cam nang Ads SEO'],
    CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE)]);
$res = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
$j = json_decode((string)$res, true);
$ans = $j['choices'][0]['message']['content'] ?? '';
if ($code !== 200 || $ans === '') {
    $msg = $j['error']['message'] ?? ('HTTP ' . $code);
    out(['answer' => "AI tạm không trả lời được ($msg). Các mục liên quan nhất ở dưới, mở để đọc trực tiếp.", 'hits' => $hits, 'meta' => '']);
}
$ans = str_replace(['—', '–'], '-', $ans);
out(['answer' => $ans, 'hits' => $hits, 'meta' => 'Model: ' . ($j['model'] ?? '') . '. ' . $meta]);
