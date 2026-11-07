<?php
// Hỏi đáp AI trên cẩm nang: quét data.json (tất cả tình huống), chọn các mục liên quan nhất, gọi OpenRouter
// trả lời CHỈ dựa trên các mục đó. Khoá API nằm ngoài public_html: ~/.cam-nang/openrouter_key.
header('Content-Type: application/json; charset=utf-8');
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');
$home = getenv('HOME') ?: dirname(__DIR__, 4); // /home/<user>
$KEY_FILE = $home . '/.cam-nang/openrouter_key';
$STATE = sys_get_temp_dir() . '/cam-nang-ask';
$MODELS = ['nvidia/nemotron-3-ultra-550b-a55b:free', 'google/gemma-4-31b-it:free', 'google/gemini-2.5-flash-lite']; // tối đa 3 model; free trước (hết credit vẫn chạy), trả phí sau
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
$sys = "Bạn là người đồng nghiệp giàu kinh nghiệm giải thích cho người làm nghề quảng cáo Google Ads, Meta Ads và SEO tại Việt Nam. CHỈ dùng thông tin trong các mục cẩm nang được cung cấp; không thêm kiến thức ngoài, không bịa số liệu. Mục nào cẩm nang chưa có thì nói rõ 'cẩm nang chưa có mục này'.
CÁCH VIẾT (bắt buộc): viết CHI TIẾT và DỄ HIỂU như đang giải thích cho người mới, không viết tắt kiểu ghi chú. Mỗi ý là câu đầy đủ, nói rõ VÌ SAO (cơ chế, nền tảng xét gì) chứ không chỉ liệt kê việc phải làm. Thuật ngữ (ví dụ learning phase, SpamBrain, manual action, CAPI, Quality Score) thì giải thích ngắn trong ngoặc ở lần đầu nhắc. Khi mục cẩm nang có số liệu hoặc ngưỡng thì nêu đúng con số và nói ngưỡng đó từ nguồn chính thức hay kinh nghiệm.
BỐ CỤC: dùng tiêu đề in đậm theo đúng thứ tự: **Tóm tắt** (2-3 câu trả lời thẳng câu hỏi) / **Vì sao xảy ra** (nguyên nhân thường gặp, giải thích cơ chế) / **Kiểm tra trước** (từng bước, ghi rõ vào đâu, nhìn cái gì, kết quả thế nào thì kết luận gì) / **Cách xử lý** (từng bước theo thứ tự ưu tiên, mỗi bước nói làm gì và mong đợi gì) / **Tránh** (sai lầm hay gặp và hậu quả) / **Lưu ý về nguồn** (ý nào có nguồn chính thức, ý nào chỉ là kinh nghiệm). Dùng gạch đầu dòng '- ' cho các bước. Sau mỗi ý lấy từ mục nào thì ghi [số].
Mục loại 'black' hoặc 'gray' là vi phạm hoặc vùng xám: nói rõ người ta làm gì, chính sách nói gì, hậu quả thật, rồi cách làm đúng; không hướng dẫn cách lách. Tiếng Việt tự nhiên, không dùng dấu gạch dài, chỉ dùng '-'. Độ dài 500-800 từ, đủ ý quan trọng hơn ngắn.";
$payload = ['models' => $MODELS, 'messages' => [['role' => 'system', 'content' => $sys], ['role' => 'user', 'content' => "CÁC MỤC CẨM NANG:\n\n$ctx\nCÂU HỎI: $q"]], 'temperature' => 0.2, 'max_tokens' => 3000, 'reasoning' => ['effort' => 'low']];
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
out(['answer' => $ans, 'hits' => $hits, 'meta' => 'Model: ' . ($j['model'] ?? '') . '. Trả lời chỉ từ ' . count($hits) . ' mục cẩm nang được chọn; kiểm lại nguồn gốc trước khi làm việc lớn.']);
