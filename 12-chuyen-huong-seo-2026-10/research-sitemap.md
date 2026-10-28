# Research mở rộng digicomvn.com sang mọi dịch vụ SEO + tên miền, hosting, phần mềm SEO, khoá học

Ngày đo: 27/10/2026. Chỉ research, KHÔNG sửa gì trên site.

## 0. Cách đo SERP

- Công cụ: `ICD/08-tools/keyword-tools/allintitle_scrape.py` chế độ `SERP_ONLY=1 ALLINTITLE_DIRECT=1 --serp` (Chrome thật qua patchright, profile riêng không đăng nhập Google, không cookie, IP máy tại Việt Nam, google.com.vn tiếng Việt). Đo ở chế độ ẩn danh theo rule `serp-an-danh.md`.
- 15/15 từ đo thành công, 0 captcha. Dữ liệu thô: `/Volumes/Extreme SSD/Projects/digicom/12-chuyen-huong-seo-2026-10/serp.csv` (cột serp_urls, serp_titles, paa).
- Hạn chế: Google chỉ trả 7-9 kết quả tự nhiên/trang 1; một số URL Google hiển thị dạng breadcrumb (vd `seovip.vn › Danh mục SEO`) nên không có đường dẫn đầy đủ. Allintitle KHÔNG lấy được số (tool trả null cho cả 15 từ), cần đo lại riêng nếu dùng để chấm độ khó. Dạng trang suy từ tiêu đề + URL + mở tay 6 site agency, chưa mở đủ từng kết quả bằng `SERP_PAGES=1`.
- Từ chưa đo (cần đo trước khi chốt trang): "dịch vụ audit seo", "dịch vụ tối ưu onpage", "dịch vụ seo google map", "bảng giá dịch vụ seo", "mua chung ahrefs", "đăng ký tên miền", "dịch vụ geo".

## 1. Top 10 Google VN theo từ đầu cụm

| Từ khoá | Dạng trang đang top (đếm) | Domain/URL tiêu biểu | Kết luận intent |
|---|---|---|---|
| dịch vụ seo | 8/8 trang dịch vụ, trong đó 2 là trang bảng giá | seovip.vn, ladigi.vn/seo/dich-vu-seo, buffseo.com/dich-vu-seo, foogleseo.com/dich-vu-seo-ha-noi, monamedia.co/bao-gia-dich-vu-seo, seongon.com/bao-gia-dich-vu-seo-tong-the. PAA: "Chi phí dịch vụ SEO là bao nhiêu?" | Thương mại, mua dịch vụ; giá là câu hỏi số 1 |
| dịch vụ seo tổng thể | 7/8 trang dịch vụ + 1 toplist (sctt.net.vn) | dichvuwebsite.com.vn, seocenter.vn, seongon.com (bảng giá), vienit.org, buffseo.com, hapodigital.com/dich-vu-seo, peakagency.vn | Thương mại |
| dịch vụ seo từ khóa | 9/9 trang dịch vụ (1 bảng giá) | seoviet.vn, alenco.vn, buffseo.com, scapbot.com/dich-vu-seo-tu-khoa, vienit.org, bmin.com.vn, peakagency.vn, unext.com.vn | Thương mại. Trùng 3 URL với "tổng thể" (buffseo, vienit, peakagency) => cùng 1 trang đích |
| audit seo | 6 bài hướng dẫn + 2 công cụ (seoptimer.com, vi.semrush.com/siteaudit) + 1 bài cộng đồng; 0 trang dịch vụ | gtvseo.com (SEO Audit là gì), viblo.asia, brandsvietnam.com, wecan-group.com, fagoagency.vn | Thông tin + công cụ. Không làm trang dịch vụ cho từ này |
| dịch vụ seo local | 5 trang dịch vụ (nhiều trang nhấn Google Maps) + 1 SEO Hà Nội + 3 blog | peakagency.vn, prodima.vn, seovip.vn (SEO Google Maps), gyb.vn/dich-vu-seo-local-map, itify.vn/dich-vu-seo-google-maps; blog mona.media, monamedia.co | Thương mại, gắn Google Maps |
| tối ưu onpage | 6/7 bài hướng dẫn/checklist + 1 trang dịch vụ web | gtvseo.com (20+ checklist), sapo.vn, skillking.fpt.edu.vn, brandsvietnam.com, seongon.com (40+ checklist) | Thông tin, dạng checklist. Làm blog |
| dịch vụ viết bài chuẩn seo | 6 trang dịch vụ + 2 toplist + 1 trang SEO | vn4u.vn, leadup.vn, cloudgo.vn, sotagroup.vn, bictweb.vn ("chỉ từ 50k"), halink.vn | Thương mại, tiêu đề nhấn giá/bài |
| dịch vụ entity | 8 trang dịch vụ entity social + 1 bài PR | dichvuentity.vn, seotop.vn, seothanhcong.vn/dich-vu-entity, seovip.vn, tamnguyen.com.vn, hapodigital.com, seotoro.vn | Thương mại, đúng sản phẩm Digicom đang bán ở /backlink-social-entity/ |
| dịch vụ seo quốc tế | 4 trang dịch vụ + 1 danh bạ agency (semrush) + 3 blog/toplist + 1 SEO HN | bngagency.vn/dich-vu-seo-quoc-te, peakagency.vn, revenue.com.vn/dich-vu-seo-quoc-te, mkpseo.com, gtvseo.com (SEO Global là gì) | Thương mại pha thông tin; trang dịch vụ có phần giải thích |
| dịch vụ seo ai | 7 trang dịch vụ + 1 blog + 1 trang tag | ladigi.vn, seocenter.vn, peakagency.vn (SEO Google AI Overview), seodo.vn, seongon.com/dich-vu-seo, winmedia.vn/dich-vu-seo-ai | Thương mại. Trùng 2 URL với "dịch vụ seo" => trang riêng được |
| mua tên miền | 9/9 trang tra cứu + đăng ký của nhà đăng ký | pavietnam.vn/dang-ky-ten-mien, inet.vn, matbao.net, nhanhoa.com, tenten.vn, viettelidc.com.vn, godaddy.com, vinahost.vn | Giao dịch: ô tra cứu + bảng giá đuôi. Đối thủ là nhà đăng ký gốc, rất khó lên top |
| hosting giá rẻ | 7 trang sản phẩm bảng giá + 2 toplist | mdigi.vn, bkhost.vn ("từ 5K"), tino.vn, hostvn.net, vinahost.vn, hvn.vn, pavietnam.vn | Giao dịch: bảng gói + giá/tháng trong tiêu đề |
| mua tài khoản ahrefs | 5 shop bán/chia sẻ tài khoản + 1 bài kiến thức + blog Ahrefs + Reddit + Facebook + đại lý chính hãng | muachungtaikhoan.com ("330k"), toolsclick.net/mua-chung-ahrefs ("79k"), sadesign.vn/tai-khoan-ahrefs, ahrefs.com.vn (Repu Digital, đại lý) | Giao dịch, nhạy giá |
| group buy seo tool | 9/9 site tiếng Anh nước ngoài | groupbuyseotools.org, seogroupsbuy.com, groupseotools.net | Không có thị trường tiếng Việt; người Việt tìm "mua chung ahrefs" |
| khóa học seo | 6 trang khoá học + YouTube + 1 bài tổng hợp | seongon.com/dao-tao/khoa-hoc-seo-aimax, vinalink.edu.vn, seovip.vn, skillking.fpt.edu.vn/dao-tao-seo, mindx.edu.vn, advertisingvietnam.com | Giao dịch (đăng ký học); có tầng "khoá học miễn phí" |

Domain lặp lại nhiều nhất trên 15 SERP: seovip.vn (6), peakagency.vn (6), buffseo.com (4), seongon.com (4), monamedia.co (3), scapbot.com (3), gtvseo.com (3), pavietnam.vn (3).

## 2. Agency SEO VN đang top: cấu trúc site

| Agency | Menu chính | Trang dịch vụ SEO con | Bảng giá SEO | Khoá học |
|---|---|---|---|---|
| seovip.vn ([nguồn](https://seovip.vn/)) | Home, Dịch vụ SEO, Đào tạo SEO, Thiết kế web, Quảng cáo, Blog, Audit SEO miễn phí | SEO tổng thể, SEO TMĐT, Bảng giá, Case study, SEO Hà Nội/HCM/Đà Nẵng, SEO Google Maps, SEO Mentor, Book báo PR, Guest post/Toplist, Backlink, Entity, Textlink báo, Audit 72h. Hosting nằm trong nhóm Thiết kế web | Trang riêng [/bang-gia-seo-tong-the](https://seovip.vn/bang-gia-seo-tong-the): 3 gói theo dự án (Basic 150-249tr, Pro 250-499tr, VIP >700tr) + 3 gói quản trị theo tháng (dưới 20/50/100 từ) + bảng phí kèm (entity, PR, backlink) | 8 khoá (SEO A-Z, Google Ads, Content, inhouse, lịch học) |
| peakagency.vn ([nguồn](https://peakagency.vn/)) | Giới thiệu, Dịch vụ, Đào tạo, Dự án, Kiến thức, Liên hệ | SEO tổng thể, SEO từ khoá, SEO website, SEO audit, SEO Hà Nội, SEO AI, SEO giá rẻ (mỗi biến thể 1 URL) | Không xem chi tiết | 6 khoá (SEO, Google Ads, Facebook, TikTok, AI, doanh nghiệp) |
| seongon.com ([nguồn](https://seongon.com/)) | Về chúng tôi, Dịch vụ, Giải pháp theo ngành, Tài nguyên, Khách hàng, Dự án | GEO Enterprise, SEO tổng thể AI MAX, Total Business Map, SEO HN/HCM, ASO | Trang riêng [/bao-gia-dich-vu-seo-tong-the](https://seongon.com/bao-gia-dich-vu-seo-tong-the): 5 gói trọn dự án (từ 300tr) + bảng giá 20 ngành | /dao-tao: SEO AI Max, Google Ads, Content SEO |
| gtvseo.com ([nguồn](https://gtvseo.com/)) | Về GTV, Dịch vụ, Đào tạo, Kiến thức, Case study, Liên hệ | SEO & GEO tổng thể, SEO HCM, SEO HN, Tư vấn SEO, Enterprise | Trang riêng [/bang-gia-dich-vu-seo/](https://gtvseo.com/bang-gia-dich-vu-seo/): 3 gói trọn chu kỳ (Starter 350tr, Growth 500tr, Dominate 800tr) kèm case theo gói | [/dao-tao-seo/](https://gtvseo.com/dao-tao-seo/) 11,8tr, 9 buổi offline + SEO KickStart |
| ladigi.vn ([nguồn](https://ladigi.vn/)) | Giới thiệu, SEO, Google Ads, Thiết kế web | SEO, Backlink, Viết bài SEO, Chăm sóc web | Bảng 3 gói/tháng so sánh hạng mục (10/15/30 bài, 30/50/100 backlink) | Khoá Digital, SEO & Google Ads |
| monamedia.co ([nguồn](https://monamedia.co/bao-gia-dich-vu-seo)) | Thiết kế web, Web-app, SEO, Phần mềm, App | SEO tổng thể, SEO từ khoá, SEO HCM | Theo gói (15tr, 42tr/3 tháng, liên hệ) + theo ngành + theo tháng (SEO AI 15-45tr/tháng) | Không |

Bố cục trang chủ chung (gtvseo, seongon, seovip, peakagency): Hero định vị -> lưới dịch vụ -> số liệu/thành tựu -> case study/dự án -> logo khách -> đánh giá khách -> báo chí nói về -> đội ngũ -> kiến thức/blog -> form tư vấn -> footer. seovip.vn thêm FAQ + lịch khai giảng ngay trang chủ.

Trang khoá học mẫu (gtvseo.com/dao-tao-seo/): hero + học phí -> nỗi đau -> khoá giải quyết gì -> đầu ra -> đối tượng -> lộ trình từng buổi -> giảng viên -> phản hồi học viên -> học phí + form -> FAQ 19 câu.

Nhận xét: không agency SEO nào trong top bán tên miền/hosting làm trọng tâm (seovip, mona chỉ để trong nhóm thiết kế web/footer). Tên miền + hosting do nhà đăng ký chiếm trọn top.

## 3. Rủi ro cần lưu ý trước khi làm

- **Bán/chia sẻ tài khoản Ahrefs**: điều khoản Ahrefs ([ahrefs.com/legal/terms](https://ahrefs.com/legal/terms)) mục 12.4 ghi giấy phép "non-transferable, non-sublicensable", mục 12.7(a) cấm "selling, trading, transferring" dịch vụ khi chưa có đồng ý bằng văn bản, mục 8.4(i) cho phép đình chỉ khi có sử dụng trái phép. Mô hình "mua chung" vi phạm điều khoản nhà cung cấp; khách có thể mất quyền truy cập giữa kỳ. Phương án an toàn hơn: làm đại lý gói chính hãng (như ahrefs.com.vn - Repu Digital) hoặc bán dịch vụ báo cáo/tra cứu thay khách (Digicom giữ tài khoản, giao báo cáo).
- **Tên miền, hosting**: top 9/9 là nhà đăng ký gốc (pavietnam, inet, matbao, nhanhoa...). Digicom là đại lý P.A (theo `NOIBO-nguon-gia-pa.md` cùng thư mục) nên khó vượt giá; nên coi đây là trang bán chéo cho khách SEO, không kỳ vọng lên top từ khoá đầu.
- **Từ "audit seo", "tối ưu onpage"**: Google trả bài hướng dẫn/công cụ, làm trang dịch vụ cho đúng từ này sẽ sai intent (rule `audit-intent-truoc.md`).
- **Trùng intent với trang đang có**: "dịch vụ entity" = đúng sản phẩm /backlink-social-entity/ -> tối ưu trang cũ, không làm trang mới (tránh ăn thịt từ khoá).

## 4. Đề xuất cây URL

Giữ cấu trúc phẳng ở gốc như hiện tại (đã bỏ hub /dich-vu/ từ 16/07/2026). 3 slug cũ `/dich-vu-seo/`, `/ten-mien/`, `/hosting/` đang 301 về trang chủ (đo curl 27/10/2026) và có trang draft từ giai đoạn trước pivot: dùng lại đúng slug, gỡ 301 khi publish, đỡ tạo URL mới.

### Menu "Dịch vụ SEO" (mới)

| Trang | Slug đề xuất | Từ khoá chính | Dạng trang | Intent (SERP 27/10) |
|---|---|---|---|---|
| Dịch vụ SEO tổng thể (gồm SEO từ khoá, bảng giá trong trang) | /dich-vu-seo/ (dùng lại) | dịch vụ seo, dịch vụ seo tổng thể, dịch vụ seo từ khóa | Trang dịch vụ, có bảng gói giá ngay trong trang (theo quyết định 09/08/2026 không làm trang bảng giá tổng hợp riêng) | Thương mại; 3 từ chung 1 trang (tổng thể và từ khoá trùng 3 URL) |
| Dịch vụ SEO AI / GEO | /dich-vu-seo-ai/ | dịch vụ seo ai, (dịch vụ geo chưa đo) | Trang dịch vụ | Thương mại, 7/9 trang dịch vụ |
| Dịch vụ SEO local, Google Maps | /dich-vu-seo-local/ | dịch vụ seo local, (seo google maps chưa đo) | Trang dịch vụ | Thương mại, 5/9 dịch vụ, nhấn Google Maps |
| Dịch vụ SEO quốc tế | /dich-vu-seo-quoc-te/ | dịch vụ seo quốc tế | Trang dịch vụ có phần giải thích | Thương mại pha thông tin |
| Dịch vụ viết bài chuẩn SEO | /dich-vu-viet-bai-chuan-seo/ | dịch vụ viết bài chuẩn seo | Trang dịch vụ, giá theo bài | Thương mại, 6/9 dịch vụ |
| Dịch vụ audit SEO | /dich-vu-audit-seo/ | dịch vụ audit seo (CHƯA ĐO) | Trang dịch vụ | Chưa đo; chỉ làm khi SERP từ này ra trang dịch vụ |
| Bài: SEO audit là gì | /seo-audit-la-gi/ (blog) | audit seo | Bài hướng dẫn + checklist | Thông tin, 6/9 blog |
| Bài: SEO onpage, checklist | /seo-onpage-la-gi/ (blog) | tối ưu onpage, seo onpage | Bài checklist | Thông tin, 6/7 blog |

### Menu "Backlink & PR" (giữ nguyên URL đang có)

/mua-textlink/, /dich-vu-backlink/, /guest-post/, /booking-bao-pr/, /backlink-social-entity/, /backlink-quoc-te/, /dich-vu-toplist/, /booking-truyen-hinh/, /booking-fanpage/, /booking-kol-koc/.
- /backlink-social-entity/: thêm "dịch vụ entity" vào title/H1 hoặc H2 (SERP 8/9 trang dịch vụ entity social, cùng sản phẩm). Không tạo /dich-vu-entity/.

### Menu "Tên miền & Hosting"

| Trang | Slug đề xuất | Từ khoá chính | Dạng trang | Intent |
|---|---|---|---|---|
| Tên miền | /ten-mien/ (dùng lại) | mua tên miền, (đăng ký tên miền chưa đo) | Ô tra cứu + bảng giá đuôi .vn/.com.vn/quốc tế | Giao dịch, 9/9 nhà đăng ký |
| Hosting | /hosting/ (dùng lại) | hosting giá rẻ | Bảng gói + giá/tháng | Giao dịch, 7/9 trang sản phẩm |

### Menu "Phần mềm SEO"

| Trang | Slug đề xuất | Từ khoá chính | Dạng trang | Intent |
|---|---|---|---|---|
| Phần mềm SEO (hub các công cụ) | /phan-mem-seo/ | (chưa đo) | Danh mục công cụ + bảng giá | Chưa đo |
| Tài khoản Ahrefs | /tai-khoan-ahrefs/ | mua tài khoản ahrefs, (mua chung ahrefs chưa đo) | Trang sản phẩm có bảng giá | Giao dịch, nhạy giá. Cần chốt mô hình (xem mục 3) trước khi làm |
| Semrush và công cụ khác | /tai-khoan-semrush/ ... | (chưa đo) | Trang sản phẩm | Chưa đo |
- Bỏ từ "group buy seo tool": SERP 100% tiếng Anh nước ngoài.

### Menu "Khoá học"

| Trang | Slug đề xuất | Từ khoá chính | Dạng trang | Intent |
|---|---|---|---|---|
| Khoá học SEO | /khoa-hoc-seo/ | khóa học seo | Landing khoá học: học phí, lộ trình buổi, giảng viên, form đăng ký, FAQ | Giao dịch, 6 trang khoá học |

### Blog
Giữ /blog/; thêm chuyên mục "Kiến thức SEO" chứa bài thông tin (audit, onpage, GEO là gì...) dẫn link về trang dịch vụ tương ứng.

## 5. Việc cần trước khi viết
1. Đo bổ sung (SERP_ONLY + SERP_PAGES=1): dịch vụ audit seo, dịch vụ tối ưu onpage, dịch vụ seo google map, bảng giá dịch vụ seo, dịch vụ geo, mua chung ahrefs, đăng ký tên miền, phần mềm seo.
2. Đo allintitle riêng (lượt này tool trả null).
3. Chốt mô hình bán tài khoản phần mềm SEO (đại lý chính hãng hay chia sẻ tài khoản) do rủi ro điều khoản Ahrefs.
4. Khoá học: cần giảng viên thật, lộ trình, học phí thật (không bịa, rule E-E-A-T).
