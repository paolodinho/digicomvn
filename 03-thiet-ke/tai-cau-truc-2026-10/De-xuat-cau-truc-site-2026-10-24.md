# Cấu trúc digicomvn.com tập trung 1 chủ đề (sửa 2026-10-24, thay bản "5 nhóm dịch vụ")

Trạng thái: ĐỀ XUẤT, chưa sửa gì trên live. Hiếu yêu cầu site phải cô đặc theo chủ đề, không dàn trải.
Bản trước (mở 5 nhóm: PR, truyền hình, SEO, tên miền/hosting, quảng cáo) đã BỎ vì trái nguyên tắc này.
Dữ liệu: `gsc-trang-90-ngay-2026-10-24.tsv` (GSC 90 ngày, 240 URL) cùng thư mục.

## 1. Vì sao phải cô đặc (căn cứ)

| Căn cứ | Nội dung | Mức chắc chắn |
|---|---|---|
| Google, trang Creating helpful content (cập nhật 05/10/2026) | Hỏi "Does your site have a primary purpose or focus?" và coi việc viết "lots of content on many different topics in hopes that some of it might perform well" là dấu hiệu nội dung làm cho máy | Chính thức |
| Rò rỉ tài liệu API Google 2024 | Có thuộc tính `siteFocusScore` (site tập trung vào 1 chủ đề tới mức nào) và `siteRadius` (từng trang cách "trọng tâm chủ đề" của site bao xa), nằm trong cụm chấm điểm cấp site | Có thật trong tài liệu; mức ảnh hưởng xếp hạng là suy luận |
| Google, Understanding news topic authority (05/2023) | Google có hệ thống nhận diện nguồn chuyên về 1 chủ đề (độ nổi tiếng theo chủ đề, bị nơi khác trích dẫn, lịch sử đưa tin) | Chính thức, áp cho tin tức; nguyên lý tương tự được giới SEO áp cho site thường |
| John Mueller (Google) | Nội dung liên quan nên để chung 1 site; chỉ tách site/subdomain khi nội dung thực sự khác hẳn | Phát biểu của Google |

Hệ quả thực tế: mỗi trang lệch chủ đề (tên miền, hosting...) kéo trọng tâm site ra xa cụm PR đang
có thứ hạng, và tự nó cũng khó lên top vì site không được nhận diện là chuyên về hạ tầng web.

## 2. Dữ liệu thật: site đang mạnh ở đâu (GSC 90 ngày)

| Cụm | Số bài | Click | Lượt hiện |
|---|---|---|---|
| Booking báo PR (64 bài + trang `/booking-bao-pr/`) | 65 | 375 (79%) | 10.397 (62%) |
| Off-page: textlink, guest post, backlink... (36 bài + 7 trang) | 43 | 36 (8%) | 1.989 |
| Kiến thức SEO chung (9 chuyên mục) | 74 | 25 (5%) | 3.653 |
| Trang chủ + khác | - | 41 | 1.025 |

=> Google đã nhận Digicom là nguồn về **booking báo / PR báo chí**. 74 bài SEO chung chỉ mang 5% click,
tức chúng đang làm loãng chủ đề nhiều hơn là đem khách.

## 3. Chủ đề lõi và các vòng

**Chủ đề lõi (1 câu):** Digicom là đơn vị booking truyền thông - đặt bài trên báo điện tử và
truyền hình cho doanh nghiệp, có thêm giá trị SEO từ link báo.

| Vòng | Dịch vụ | Làm gì |
|---|---|---|
| Lõi - đầu tư mạnh nhất | Booking báo PR (báo lớn, báo tỉnh, báo ngành, báo quốc tế), viết bài PR / thông cáo báo chí, PR có phỏng vấn | Viết sâu thêm theo ngành, theo đầu báo, theo vùng |
| Vòng 2 - mở thêm, cùng chủ đề "đặt chỗ trên kênh truyền thông" | Booking truyền hình (phóng sự, talkshow, bản tin, TVC), quảng cáo phát thanh | Publish lại 2 trang nháp đã có |
| Vòng 3 - giữ nguyên, không mở thêm | Textlink, guest post, dịch vụ backlink, social entity, backlink quốc tế, toplist | Giữ 6 trang; định vị lại là "link từ báo và site uy tín", nối về cụm PR |
| Ngoài chủ đề - KHÔNG đưa lên site này | Dịch vụ SEO tổng thể/GEO/audit, tên miền, hosting, VPS, email, SSL, thiết kế website, Google/Facebook Ads, loa phường, màn LED | Nếu muốn bán: làm site/thương hiệu riêng (Mueller: nội dung khác hẳn thì tách), hoặc chỉ nhận qua form "Dịch vụ khác", không làm trang đích |

Ghi chú về SEO: đây là quyết định đánh đổi. Muốn bán dịch vụ SEO tổng thể trên chính domain này
thì site thành 2 trọng tâm (PR + agency SEO), đi ngược mục tiêu cô đặc. Khuyến nghị: chưa mở; xem lại
khi cụm PR đã giữ top 3 ổn định cho các từ chính.

Loa phường, màn LED tạm để nháp: đó là quảng cáo ngoài trời, gần mô hình Brandcom hơn là "báo chí - truyền hình".

## 4. Cấu trúc site

```
/                                Trang chủ: định vị booking báo + truyền hình, đầu báo hợp tác, case study, form báo giá
|
|-- BOOKING BÁO PR (pillar lõi)
|   /booking-bao-pr/              giữ
|     /book-bao-<tên báo>/        giữ ~30 bài; thêm đầu báo còn thiếu khi có volume
|     /booking-bao-tinh/  /booking-bao-quoc-te/  /agency-booking-bao-chi/   giữ
|     [mới, sau khi đo SERP]      booking báo theo ngành: bất động sản, y tế, giáo dục, tài chính...
|   bài vệ tinh PR đang có         thông cáo báo chí, bài PR mẫu, RACE, sapo, editorial...  giữ
|
|-- BOOKING TRUYỀN HÌNH (pillar vòng 2)
|   /booking-truyen-hinh/          publish lại trang 2107
|   /quang-cao-phat-thanh/         publish lại trang 2440
|   [mới, sau khi đo SERP]         bài theo kênh/hình thức: phóng sự VTV, talkshow, TVC HTV, bảng giá truyền hình
|
|-- LINK TỪ BÁO & OFF-PAGE (giữ, không mở thêm)
|   /mua-textlink/ /dich-vu-backlink/ /dich-vu-backlink/bat-dong-san/ /guest-post/
|   /backlink-social-entity/ /backlink-quoc-te/ /dich-vu-toplist/
|
|-- Kiến thức (blog): giữ /blog/, NGỪNG viết thêm bài SEO chung
|-- Giữ nguyên: /case-study/*, /ve-digicom/, /lien-he/, /dat-bai/, /cau-hoi-thuong-gap/, chính sách
```

Menu chỉ còn: Booking báo PR | Booking truyền hình | Link từ báo | Case study | Blog | nút "Nhận báo giá".
Link nội bộ: bài off-page và bài SEO chung trỏ về `/booking-bao-pr/` khi nói tới backlink báo, để dồn
tín hiệu về lõi.

## 5. URL và 301

- **Không URL đang chạy nào phải đổi.** Trang truyền hình publish lại đúng slug cũ, không cần 301.
- 301 đang chạy giữ nguyên (`/bang-gia/`, `/dich-vu/...`, `/booking-bao-pr/<báo>/`, `/dich-vu-entity/`,
  `/backlink-social/`, `/danh-muc/...`).
- Trang nháp ngoài chủ đề (tên miền, hosting, thiết kế website, Google Ads, bản quyền...) giữ nháp,
  chưa từng live nên không cần 301.

Việc dọn cụm SEO chung (làm SAU, mỗi bước đo trước):
1. Gộp 9 chuyên mục SEO (`/category/seo-tong-quan/`, `seo-tu-khoa`, `seo-onpage-content`, `seo-technical`,
   `seo-thuat-toan-google`, `seo-local`, `seo-ecommerce`, `seo-ai-geo`, `seo-cong-cu-do-luong`) thành 1
   `/category/kien-thuc-seo/`, 301 cả 9 URL cũ về đó. Mỗi chuyên mục hiện chỉ 5-15 bài, tổng 206 lượt hiện / 3 click.
2. Gộp bài trùng ý định khi top 10 trùng >= 3 URL: `/google-sge/` -> `/ai-overview/`; `/seo-dia-phuong/` vs
   `/local-seo/`; `/seo-trong-thoi-dai-ai/` vs `/geo-generative-engine-optimization/`; trang
   `/dich-vu-backlink/bat-dong-san/` vs bài `/backlink-bat-dong-san/`.
3. Sau 3 tháng: bài SEO chung không có click và dưới 20 lượt hiện thì gộp vào bài gần nhất hoặc bỏ
   index. Không xoá hàng loạt trước khi đo.

Cách làm 301: thêm dòng vào mảng `$dgc_gop` trong `functions.php` (chỉ chạy khi URL cũ 404, không tạo
vòng lặp), sửa link nội bộ trỏ thẳng URL mới, `curl -sI` từng URL cũ ra đúng 1 bước 301 -> 200, theo dõi
GSC 4 tuần.

## 6. Thứ tự làm
1. Trang chủ + menu theo định vị mới (không đổi URL).
2. Soát giá truyền hình/phát thanh (115 dòng nháp), publish 2 trang.
3. Đo SERP + viết bài lõi mới: booking báo theo ngành, các bài truyền hình.
4. Gộp chuyên mục SEO + bài trùng (mục 5).

## Nguồn
- Google Creating helpful content: https://developers.google.com/search/docs/fundamentals/creating-helpful-content (đọc 24/10/2026)
- Google Understanding news topic authority: https://developers.google.com/search/blog/2023/05/understanding-news-topic-authority
- Rò rỉ API 2024: https://en.wikipedia.org/wiki/2024_Google_Search_documentation_leak ; https://searchengineland.com/unpacking-googles-massive-search-documentation-leak-442716
- John Mueller về tách site/subdomain: https://searchenginejournal.com/google-treats-subdomains-subdirectories-john-mueller-says
- Mô hình đối thủ quảng cáo ngoài trời: https://brandcom.vn/
