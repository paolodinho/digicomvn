# Kế hoạch nội dung cụm "Bài PR" - 2026-07-27

> Input: 305 dòng keyword Hiếu đưa (export tool nghi là broad-match theo chữ "pr" - dính rất
> nhiều nhiễu không liên quan). Nguồn: paste trực tiếp trong chat, không phải file.

## 0. Lọc nhiễu - BƯỚC BẮT BUỘC trước khi gom cụm

305 dòng gốc → sau khi loại nhiễu còn **~148 từ khoá thật liên quan "bài PR"** (~51% là rác).

**3 loại nhiễu đã loại** (do tool export khớp rộng theo chữ "pr"/"por"/"bài"):
1. **Lời bài hát tiếng Anh** chứa "pr..." (prayer, pretty, proud, promise...): "lời bài hát bon
   jovi livin on a prayer", "lời bài hát prince i wanna be your lover"... (~45 dòng).
2. **Bài tập tiếng Anh phổ thông** chứa gốc "pr" (project, prepare, protein, pronunciation,
   preposition, present simple/continuous, possessive pronouns, proposal...): "bài project
   unit 5 lớp 8", "khtn 9 bài protein", "bài tập pronunciation lớp 6"... (~85 dòng).
3. **Review địa điểm/dịch vụ** không liên quan ("bài đánh giá về..."), ký tự đơn lẻ rác
   ("o pb", "q pr", "u press", "0 pro"...) (~27 dòng).

**2 nhóm NGOÀI PHẠM VI dịch vụ Digicom** (không phải nhiễu, nhưng khác lĩnh vực - xác nhận
qua research SERP ở mục 2, không chỉ suy đoán theo chữ):
- "bài mẫu pr bản thân bằng tiếng nhật", "bài mẫu pr bản thân khi phỏng vấn" (1 phần) - cụm
  "Jiko PR" (自己PR - tự giới thiệu khi phỏng vấn xin việc/du học Nhật Bản), thuộc mảng du
  học/lao động Nhật, KHÔNG liên quan PR báo chí/doanh nghiệp.
- **MỞ RỘNG 2026-07-27 sau khi research SERP**: "bài pr bản thân", "bài pr cá nhân", "mẫu
  bài pr bản thân", "bài mẫu pr bản thân bằng tiếng việt", "viết bài pr cho bản thân" -
  SERP thật của cụm này (search "bài PR bản thân là gì") ra TOÀN BỘ site tuyển dụng/nghề
  nghiệp (muaban.net, careerviet.vn, growupwork.com, govigroup.com, working24.net,
  lecongnang.com, tramdoc.vn) - **không có site nào là agency PR/marketing**. Đây là chủ đề
  "PR bản thân" theo nghĩa xây dựng thương hiệu cá nhân khi phỏng vấn xin việc/CV - khác hẳn
  bản chất "bài PR" (Public Relations, bài viết đăng báo cho doanh nghiệp/sản phẩm) mà Digicom
  làm dịch vụ. Loại khỏi plan cùng nhóm Jiko PR - không viết, không gộp vào N2.

## 1. Đối chiếu bài đã có trên site (chống trùng cụm)

Quét `wp post list -s pr` + đọc H2 thật của bài liên quan nhất:

| Bài đã có | URL | Đã phủ được gì |
|---|---|---|
| Cách Viết Bài PR Chuẩn Báo Chí (1277) | `/cach-viet-bai-pr-chuan-bao-chi/` | Khác gì quảng cáo, tiêu đề, sapo 5W1H, tháp ngược, trích dẫn, **công thức PAS**, kết bài, lỗi thường gặp, 1 bài mẫu minh hoạ, FAQ |
| Booking Báo Là Gì (1260) | `/booking-bao-la-gi/` | Định nghĩa DỊCH VỤ đặt đăng báo (khác góc "bài PR là gì" - góc viết nội dung) |
| So Sánh Booking Báo PR Và Quảng Cáo (1282) | `/so-sanh-booking-bao-pr-va-quang-cao-bao/` | Phân biệt PR vs quảng cáo (đã phủ "bài pr quảng cáo") |
| Chiến Dịch PR Ấn Tượng (1280) | `/chien-dich-pr-an-tuong-viet-nam/` | Case study CHIẾN DỊCH (khác case study TỪNG BÀI viết) |
| 15 bài Book Báo theo đầu báo (R1-R15) + Giá Booking Báo (1261) | `/book-bao-vnexpress/`, `/book-bao-cafef/`... | Phủ toàn bộ "báo giá bài PR VnExpress/CafeF/Znews/Kenh14/Tuổi Trẻ/Dân Trí/Thanh Niên/24h/aFamily/Eva/CafeBiz/Báo Đầu Tư/Soha/Webtretho/VietNamNet" |
| 4 bài Thông cáo báo chí (3848/3849/3850/3869) | `/thong-cao-bao-chi-la-gi/`... | Cụm liên quan (press release) - dùng link chéo, không viết lại |

**Gap phát hiện qua đối chiếu:** "báo giá bài pr báo lao động" - Báo Lao Động KHÔNG nằm trong
15 báo đã có trang riêng. Digicom đã xác nhận hợp tác toàn bộ báo điện tử VN (pivot-2026-07.md,
2026-07-24) nên tạo trang được, nhưng đây là 1 keyword đơn lẻ, KHÔNG thuộc cụm "bài PR" (viết
kỹ năng) đang xét - ghi chú riêng, để Hiếu quyết có mở rộng cụm booking-báo hay không.

## 2. Research SERP sâu - 8 cụm x 10 đối thủ (cập nhật 2026-07-27, thay bản 5-truy-vấn cũ)

> Công cụ: WebSearch (Google qua API tìm kiếm, không phải trình duyệt cá nhân hoá - xem giới
> hạn cuối mục). Mỗi cụm đọc toàn bộ domain xuất hiện trong top kết quả trả về (6-10 domain/cụm).

| # | Truy vấn đại diện | Domain đối thủ xuất hiện (top) | Loại bài đang top | Gap/kết luận cho Digicom |
|---|---|---|---|---|
| A | "bài PR là gì" | subiz.com.vn, imta.edu.vn, aimacademy.vn, oriagency.vn, nhatchi.com, supro.vn | Định nghĩa + mục đích + phân biệt quảng cáo | Không đối thủ nào phân biệt với **thông cáo báo chí** (chỉ phân biệt quảng cáo) → info gain cho N1 xác nhận đúng |
| B | "các dạng bài PR advertorial editorial testimonial" | vn4u.vn, nhatchi.com, vinalink.edu.vn, igb.vn, brandcom.vn, duonggiaphat.vn, marketingevent.vn, supro.vn, 5smedia.vn, upcontent.vn (10 domain) | Liệt kê 3 dạng | **Xác nhận mạnh**: 10/10 đối thủ thống nhất Advertorial/Editorial/Testimonial - gap cho bài 1277 là có thật, độ đồng thuận cao |
| C | "công thức viết bài PR PAS 3S STRINGS" | rdsic.edu.vn, ybox.vn, imta.edu.vn, marketingai.vn, nqmedia.vn, butvangcorp.com, upcontent.vn, lptech.asia | Giải thích từng công thức | Xác nhận gap 3S + STRINGS cho 1277 (hiện chỉ có PAS) |
| D | "cách viết bài PR chuẩn" | bizfly.vn, marketingai.vn, vinalink.edu.vn, pharmaco.com.vn, hapodigital.com, miccreative.vn | Quy trình 7-8 bước | **Phát hiện thêm**: bizfly.vn có nhắc công thức **AIDA** (Attention-Interest-Desire-Action) như 1 lựa chọn viết PR - đây là công thức marketing chung (không riêng PR) nên KHÔNG đưa vào 1277 (tránh loãng, giữ đúng 3 công thức đặc thù PAS/3S/STRINGS đã xác nhận ở cụm C) |
| E | "bài PR mẫu hay" | advertisingvietnam.com, imta.edu.vn, vn4u.vn, oriagency.vn, chuyengiamarketing.com, miccreative.vn | Lưu ý viết + ví dụ chiến dịch (Apple "Think Different") | Xác nhận N2 nên có ví dụ global kinh điển + ví dụ VN, không chỉ liệt kê brand suông |
| F | "viết bài PR sự kiện mẫu" | vn4u.vn, thegioimarketing.vn, vietquangcao.org, leominh.com, dichvudigitalmarketing.vn, nguoivietcontent.com, medialabs.asia (7 domain, **KHÁC HẲN** bộ domain các cụm khác) | Cấu trúc Sapo 3-ý + 5W1H + quote diễn giả | **Gap cụ thể, đo được**: SERP riêng biệt cho "PR sự kiện" (không trùng domain với cụm A-E) → đây không phải "gộp cho có", mà là 1 sub-intent có tập đối thủ RIÊNG. N2 phải có mục "PR sự kiện" đủ sâu: Sapo trả lời (sự kiện gì/vì sao đáng chú ý/ai nên tham gia), khung 5W1H, có quote diễn giả mẫu - không chỉ 2-3 dòng minh hoạ |
| G | "cách viết bài PR sản phẩm" | marketingai.vn, vn4u.vn, chuyengiamarketing.com, baogiaquangcaogoogle.com, miccreative.vn | Công thức PAS/3S áp cho sản phẩm | Domain trùng phần lớn cụm C/D → đúng là biến thể, gộp vào 1277/N2 là hợp lý, không cần bài riêng |
| H | "bài PR bản thân là gì" | muaban.net, careerviet.vn, growupwork.com, govigroup.com, working24.net, lecongnang.com, tramdoc.vn (7 domain, **toàn site tuyển dụng/nghề nghiệp**) | Kỹ năng phỏng vấn xin việc | **Ngoài phạm vi** (xem mục 0) - domain hoàn toàn khác PR báo chí, xác nhận loại khỏi cụm |

**Kết luận cạnh tranh chung**: đối thủ là các agency marketing/content lâu năm (imta.edu.vn,
vinalink.edu.vn, upcontent.vn, miccreative.vn... lặp lại ở nhiều cụm) - chủ đề phổ thông đã
viết nhiều, Digicom không có lợi thế "chưa ai viết". Lợi thế duy nhất: **gắn được với dịch vụ
thật** (booking đăng báo) mà agency thuần content không bán - toàn bộ N1/N2 phải link chéo
sang `/booking-bao-pr/` và cụm 15 bài book-báo đã có.

**Intent xác nhận cả 8 cụm**: informational thuần (không có trang dịch vụ/bảng giá nào lọt
top) → đúng dạng SUPPORTING/CLUSTER, không phải money page.

**Giới hạn nghiên cứu (ghi rõ, không giấu)**: WebSearch là API tìm kiếm của Anthropic, KHÔNG
phải Google Search trực tiếp/incognito thật - có thể lệch thứ hạng/kết quả cá nhân hoá so với
Google thật. Không lấy được số allintitle thật (operator `allintitle:` qua WebSearch bị bỏ
qua, trả kết quả search thường) - dùng độ dài + độ cụ thể của cụm từ làm proxy ưu tiên thay
vì số liệu allintitle thật (giới hạn đã ghi nhận trước đây, không có Ahrefs Keywords Explorer
volume cho từ khoá ngoài site đo được).

## 3. Cụm hoá + kế hoạch bài viết

### KHÔNG viết bài mới - SỬA bài đã có

| Bài | Việc cần làm | Từ khoá được phủ thêm |
|---|---|---|
| 1277 `/cach-viet-bai-pr-chuan-bao-chi/` | Thêm H2 mới **"Các dạng bài PR: Advertorial, Editorial, Testimonial"** (gap xác nhận qua SERP, đối thủ 100% có mục này) | các dạng bài pr, dạng bài pr, có bao nhiêu dạng bài pr, các loại bài pr, 3/5 dạng bài pr phổ biến, các dạng bài viết pr, bài pr chuyên đề (feature), bài pr editorial (+ 4 biến thể), bài pr advertorial (+ biến thể), bài pr testimonial, bài pr truyền thống |
| 1277 (tiếp) | Thêm 2 mục công thức còn thiếu: **3S (Star-Story-Solution)** và **STRINGS** (hiện chỉ có PAS) | bài pr theo công thức 3s (+6 biến thể), bài pr theo công thức strings (+2 biến thể) |

### MỚI - 2 bài (đủ intent riêng, không cannibalize với 1277 hay nhau)

| Mã | Tiêu đề đề xuất (≤58 ký tự) | Slug | Loại | Intent | Category | Widget | Info gain vs đối thủ |
|---|---|---|---|---|---|---|---|
| N1 | Bài PR Là Gì? Phân Biệt Với Quảng Cáo Và Thông Cáo Báo Chí | `/bai-pr-la-gi/` | MỚI, supporting | Informational (định nghĩa) | Booking báo & PR | `[dgc_offpage_quiz]` | Đối thủ chỉ phân biệt PR vs quảng cáo; Digicom phân biệt THÊM với thông cáo báo chí (link 2 chiều tới cụm TCBC đã có 4 bài - đối thủ agency không có sẵn cụm nội dung liên quan để link chéo) |
| N2 | Bài PR Mẫu: Ví Dụ Theo Sản Phẩm, Sự Kiện, Thương Hiệu Lớn | `/bai-pr-mau/` | MỚI, supporting | Informational (tham khảo/mẫu) | Booking báo & PR | — (không ép widget nếu không hợp) | Gộp 3 case study brand lẻ tẻ (Vinamilk/Cocoon/Coca-Cola - mỗi keyword volume quá nhỏ để tách bài riêng, gộp tránh thin content) + mẫu theo mục đích (sản phẩm/sự kiện/doanh nghiệp) thành 1 bài toàn diện. Mục **"PR sự kiện" phải làm ĐỦ SÂU** (không phải 2-3 dòng minh hoạ): theo cấu trúc SERP riêng đã xác nhận ở cụm F - Sapo trả lời 3 ý (sự kiện gì / vì sao đáng chú ý / ai nên tham gia), khung 5W1H, có mẫu quote diễn giả. Ví dụ brand: có ít nhất 1 case toàn cầu kinh điển (Apple "Think Different", theo cụm E) + case VN, không bịa nội dung gốc, chỉ mô tả CÁCH họ dùng định dạng nào dựa nguồn công khai xác minh được khi viết. Đối thủ (upcontent, vn4u, miccreative) làm dạng này nhưng không gắn được CTA dịch vụ viết+đăng thật |

**Quyết định KHÔNG tách thêm bài** cho các nhóm sau (gộp làm mục con trong N2, volume mỗi
nhóm quá nhỏ để đứng bài riêng - đúng rule chống ăn thịt từ khoá):
- "bài pr sự kiện" (+4 biến thể) → mục con trong N2
- "bài pr sản phẩm" (+5 biến thể) → mục con trong N2 (phần "cách viết" đã có ở 1277)
- "bài pr bất động sản / mỹ phẩm / doanh nghiệp / thương hiệu" → nhắc semantic trong N2, không
  tách bài theo ngành (mỗi ngành 1-2 keyword, dưới ngưỡng)
- "bài pr của vinamilk / cocoon / coca cola" → 3 mục case study trong N2, KHÔNG bịa nội dung
  bài gốc của các brand này (chỉ mô tả CÁCH họ dùng định dạng nào, dựa nguồn công khai xác minh
  được khi viết, không suy diễn)

### Ngoài phạm vi - không viết
- "bài mẫu pr bản thân bằng tiếng nhật" (cụm Jiko PR - xin việc Nhật Bản).
- "bài pr bản thân", "bài pr cá nhân", "mẫu bài pr bản thân", "bài mẫu pr bản thân bằng tiếng
  việt", "bài mẫu pr bản thân khi phỏng vấn", "viết bài pr cho bản thân" - SERP thật là site
  tuyển dụng/nghề nghiệp (cụm H, mục 2), không phải PR báo chí/doanh nghiệp.

## 4. Sơ đồ internal link

```
N1 (Bài PR là gì)  --"cách viết bài PR"-->        1277 (pillar viết bài PR)
N1                 --"thông cáo báo chí"-->        /thong-cao-bao-chi-la-gi/ (cụm TCBC)
N1                 --"dịch vụ viết và đăng bài PR"--> /booking-bao-pr/ (money page)
N2 (Bài PR mẫu)    --"công thức viết bài PR"-->    1277
N2                 --"các dạng bài PR"-->           1277 (mục mới)
1277 (cập nhật)    --"bài PR là gì"-->              N1 (thêm link mở đầu bài)
1277 (cập nhật)    --"xem thêm bài PR mẫu"-->       N2 (link mục "bài PR mẫu" hiện có sang N2)
1277               --"booking báo"-->               /booking-bao-la-gi/ (P1 cụm booking-báo - viết
                                                     xong thì đăng ở đâu, nối 2 cụm)
```

Nguyên tắc: N1/N2 là informational → không nhét anchor bán hàng cứng, chỉ 1 CTA nhẹ cuối bài
sang `/booking-bao-pr/`. Tối đa 5 internal link/bài theo rule pipeline.

## 5. Cảnh báo volume (rule publish-volume-warning)

Cụm chỉ ra **2 bài MỚI + 1 bài SỬA** sau khi lọc nhiễu và gộp - dưới ngưỡng cảnh báo batch (>5
bài/cụm nhỏ). Không cần dừng xin xác nhận số lượng, nhưng vẫn trình plan này để duyệt theo
checkpoint bắt buộc của chế độ A (mục A2).

## 6. CHECKPOINT - Hiếu đã duyệt 2026-07-27 ("viết hết đi, theo tiêu chuẩn content của digicom")

Đã chạy xong A3 (viết) + A4 (internal link) + A5 (báo cáo) trong cùng ngày duyệt:

1. **SỬA 1277** `/cach-viet-bai-pr-chuan-bao-chi/` - thêm mục "Các dạng bài PR" (Advertorial/
   Editorial/Testimonial) + mục "Công thức 3S và STRINGS" + 2 FAQ mới + 1 bullet tóm tắt.
2. **MỚI N1** [Bài PR Là Gì?](https://digicomvn.com/bai-pr-la-gi/) - post ID 4670, category
   Booking báo & PR, widget `[dgc_offpage_quiz]`, 3 sơ đồ HTML + 1 bảng + 1 ảnh Storyset.
3. **MỚI N2** [Bài PR Mẫu](https://digicomvn.com/bai-pr-mau/) - post ID 4671, category
   Booking báo & PR, 3 sơ đồ HTML (PAS flow, Sapo+5W1H, 3S stack) + 1 ảnh Storyset.
4. Internal link 2 chiều: 1277↔N1, 1277↔N2, N1→1277/TCBC/booking-bao-pr, N2→1277/chiến dịch
   PR/booking-bao-pr.
5. Đã submit Google Search Console (Yêu cầu lập chỉ mục) cho cả N1 và N2.

**Việc còn treo (không chặn, để Hiếu quyết riêng):**
- Gap "báo giá bài PR báo Lao Động" - có mở thêm 1 trang `/book-bao-lao-dong/` trong cụm
  booking-báo hay không, chưa làm trong đợt này.

**Cập nhật 2026-07-27 (tiếp)**: đã bổ sung đủ ảnh Storyset còn thiếu - nút Download PNG hoá ra
không bị hỏng, chỉ có độ trễ render ~5-10s (queue phía server) khiến lần trước tưởng lỗi. N1
giờ có 2 ảnh (news-bro + brand-loyalty), N2 có 3 ảnh (news-rafiki + market-launch + events,
gắn đúng vào từng mục sản phẩm/sự kiện). Không còn mục nào treo về chuẩn content, trừ quyết
định báo Lao Động ở trên.
