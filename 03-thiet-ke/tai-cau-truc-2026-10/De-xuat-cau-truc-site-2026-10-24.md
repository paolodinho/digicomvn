# Đề xuất mở rộng dịch vụ + cấu trúc lại digicomvn.com (2026-10-24)

Trạng thái: ĐỀ XUẤT, chưa sửa gì trên live. Chờ Hiếu chốt nhóm dịch vụ mở trước.
Dữ liệu GSC 90 ngày (240 URL): `gsc-trang-90-ngay-2026-10-24.tsv` cùng thư mục.

## 1. Hiện trạng (đo 24/10/2026)

- Live: 22 trang + 5 case study + ~185 bài blog (slug nằm ở gốc, vd `/book-bao-znews/`) + 11 chuyên mục.
- Đã có sẵn ở dạng NHÁP trong WP (chưa xoá, giữ nguyên ID): `booking-truyen-hinh` (2107),
  `quang-cao-phat-thanh` (2440), `quang-cao-loa-phuong` (2439), `quang-cao-man-led` (2441),
  `dich-vu-seo` (427), `ten-mien` (472), `hosting` (473), `thiet-ke-website` (218),
  `lap-trinh-website` (474), `google-ads` (476), `google-workspace` (478), `office-365` (479),
  `automation` (477), `ban-quyen-phan-mem` (481), `ban-quyen-windows-11` (480), hub `dich-vu` (440).
  Bảng giá 226 dòng truyền hình/phát thanh/loa/LED cũng đang nháp.
- Traffic tập trung ở cụm Booking báo PR: 16.664 lượt hiện / 477 click trong 90 ngày, top là
  `/booking-bao-pr/` (1.012 hiện, vị trí 8,4), `/mo-hinh-race-pr/`, `/editorial-la-gi/`,
  `/book-bao-dan-tri/`, `/book-bao-znews/`. Cụm SEO kiến thức có hiện nhưng gần 0 click.
  => Thiết kế lại KHÔNG được làm yếu cụm PR; dịch vụ mới đi kèm, không thay thế.

## 2. Các mảng dịch vụ có thể làm

Cột "Nguồn cung" = Digicom tự làm hay phải qua nhà cung cấp. Cột "Sẵn" = dữ liệu/trang đã có.

### A. Báo chí & PR (lõi, đang có traffic)
| Dịch vụ | Nguồn cung | Sẵn |
|---|---|---|
| Booking báo PR báo lớn (VnExpress, Dân Trí, Znews...) | NCC (DanaSEO) | Trang + 40 bài + bảng giá |
| Booking báo tỉnh / báo ngành | NCC | Có bài `/booking-bao-tinh/` |
| Booking báo quốc tế (Yahoo Finance, PR Newswire...) | NCC | Có `/backlink-quoc-te/`, `/booking-bao-quoc-te/` |
| Viết bài PR, thông cáo báo chí | Tự làm | Có bài kiến thức |
| PR có phỏng vấn, phóng viên đến tận nơi | NCC + tự làm | Có quy trình (rule pr-phong-van) |
| Emagazine, advertorial | NCC | Có trong báo giá đã gửi khách |
| Xử lý truyền thông khủng hoảng | Tự làm + NCC | Có bài, chưa có trang dịch vụ |

### B. Truyền hình, phát thanh, quảng cáo ngoài trời
| Dịch vụ | Nguồn cung | Sẵn |
|---|---|---|
| Booking truyền hình: phóng sự, talkshow, bản tin, TVC, tài trợ chương trình (VTV, HTV, VTC, đài tỉnh) | NCC | Trang + 33 dòng giá (nháp) |
| Quảng cáo phát thanh VOV / VOH / đài tỉnh | NCC | Trang + 82 dòng giá (nháp) |
| Quảng cáo loa phường | NCC | Trang + 18 dòng (nháp) |
| Quảng cáo màn LED toà nhà, LCD thang máy | NCC | Trang + 93 dòng (nháp) |
| Sản xuất TVC / phóng sự (nếu khách chưa có phim) | NCC | Chưa có |
Đối thủ cùng mô hình: Brandcom tách riêng truyền hình, VOV, thang máy, bus, taxi, outdoor, KOL
([brandcom.vn](https://brandcom.vn/)). Nên bắt đầu với 4 trang đã có sẵn, chưa mở bus/taxi/KOL.

### C. SEO
| Dịch vụ | Nguồn cung | Sẵn |
|---|---|---|
| Dịch vụ SEO tổng thể (theo tháng) | Tự làm | Trang nháp 427 |
| SEO từ khoá (cam kết bộ từ) | Tự làm | Chưa |
| SEO Google Maps / SEO local | Tự làm | Bài kiến thức, chưa có trang dịch vụ |
| GEO - hiển thị trên AI Overview, ChatGPT | Tự làm | Bài kiến thức |
| Audit SEO | Tự làm | Có quy trình nội bộ (skill seo-audit-2026) |
| Viết content SEO theo tháng | Tự làm | Chưa |
| Off-page: textlink, backlink, guest post, social entity, backlink quốc tế, toplist | NCC | 6 trang đang chạy |
Đối thủ: SEODO chỉ còn 3 dịch vụ SEO Google / GEO / SEO Maps + trang SEO theo thành phố
([seodo.vn](https://seodo.vn/)); Hashmeta tách SEO tổng thể, kỹ thuật, local, GEO, AEO, e-commerce, audit
([hashmeta.com/vn](https://hashmeta.com/vn/seo-services-vietnam)).

### D. Tên miền, hosting, email, website
| Dịch vụ | Nguồn cung | Ghi chú |
|---|---|---|
| Tên miền .vn và quốc tế | Đại lý của 1 nhà đăng ký | Tên miền .vn chỉ đăng ký được qua nhà đăng ký có hợp đồng với VNNIC (Thông tư 24/2015/TT-BTTTT) -> Digicom làm đại lý (P.A, Mắt Bão, iNET...) |
| Hosting, WordPress hosting | Đại lý | |
| VPS / Cloud server | Đại lý | |
| Email doanh nghiệp, Google Workspace, Microsoft 365 | Đại lý | Trang 478, 479 đã có nháp |
| Chứng chỉ SSL | Đại lý | |
| Thiết kế website, chăm sóc website | Tự làm | Trang 218, 474 đã có nháp |
Mẫu menu tham khảo: Mắt Bão (tên miền / hosting / cloud / email / SSL), P.A Việt Nam (thêm
chăm sóc website, đăng ký website với Bộ Công Thương). Chưa có bảng giá đại lý -> chưa đăng giá.

### E. Quảng cáo trả phí (tuỳ chọn)
Google Ads (trang 476 nháp), Facebook/Meta Ads. Đang chạy thực tế cho khách (Alpha, MHN2) nên có
case thật; mở khi Hiếu muốn bán công khai.

Không đề xuất mở: bản quyền phần mềm/Windows (biên thấp, lệch định vị), backlink .gov/.edu (cấm).

## 3. Cấu trúc website đề xuất

Nguyên tắc: GIỮ NGUYÊN 100% URL đang live. Trang dịch vụ tiếp tục nằm ở gốc (quyết định
2026-07-16), bài blog giữ slug gốc. Chỉ thêm trang mới và publish lại trang nháp đúng slug cũ.
Không đổi permalink blog sang `/blog/...` (sẽ phải 301 ~185 bài, mất tín hiệu tạm thời, không lợi gì).

```
/                                   Trang chủ: 5 nhóm dịch vụ + bằng chứng + form báo giá
|
|-- 1. BÁO CHÍ & PR
|   /booking-bao-pr/                (giữ - pillar, mạnh nhất)
|     /book-bao-<tên báo>/          (giữ ~30 bài từng đầu báo)
|     /booking-bao-tinh/  /booking-bao-quoc-te/  (giữ)
|   /dich-vu-viet-bai-pr/           MỚI (viết bài PR + thông cáo báo chí)
|   /xu-ly-khung-hoang-truyen-thong/ MỚI (sau, khi có case)
|
|-- 2. TRUYỀN HÌNH & QUẢNG CÁO NGOÀI TRỜI
|   /booking-truyen-hinh/           publish lại trang 2107 (pillar nhóm)
|   /quang-cao-phat-thanh/          publish lại 2440
|   /quang-cao-loa-phuong/          publish lại 2439
|   /quang-cao-man-led/             publish lại 2441
|
|-- 3. SEO
|   /dich-vu-seo/                   publish lại 427 (pillar = SEO tổng thể)
|   /dich-vu-seo-tu-khoa/           MỚI
|   /dich-vu-seo-google-maps/       MỚI (SEO local)
|   /dich-vu-geo/                   MỚI (AI Overview, ChatGPT)
|   /dich-vu-audit-seo/             MỚI
|   /dich-vu-viet-content-seo/      MỚI
|   -- Off-page (giữ nguyên):
|   /mua-textlink/  /dich-vu-backlink/  /dich-vu-backlink/bat-dong-san/
|   /guest-post/  /backlink-social-entity/  /backlink-quoc-te/  /dich-vu-toplist/
|
|-- 4. TÊN MIỀN, HOSTING & WEBSITE
|   /ten-mien/                      publish lại 472 (+ ô tra tên miền)
|   /hosting/                       publish lại 473
|   /vps/                           MỚI
|   /email-doanh-nghiep/            MỚI (link sang /google-workspace/ 478, /office-365/ 479)
|   /chung-chi-ssl/                 MỚI
|   /thiet-ke-website/              publish lại 218
|   /cham-soc-website/              MỚI
|
|-- 5. QUẢNG CÁO (tuỳ chọn)
|   /google-ads/                    publish lại 476
|   /quang-cao-facebook/            MỚI
|
|-- Giữ nguyên: /blog/, /category/*, /case-study/*, /ve-digicom/, /lien-he/, /dat-bai/,
    /cau-hoi-thuong-gap/, /quy-trinh-hop-tac/, /cam-on/, các trang chính sách
```
Chuyên mục blog thêm (URL mới, không đổi URL cũ): `/category/truyen-hinh-quang-cao/`,
`/category/ten-mien-hosting/`.

Slug dịch vụ mới dùng tiền tố `dich-vu-` để không trùng ý định với bài kiến thức đang có
(vd `/local-seo/`, `/geo-generative-engine-optimization/` là bài "là gì", trang bán là
`/dich-vu-seo-google-maps/`, `/dich-vu-geo/`). Mọi slug trên chỉ là đề xuất: phải đo top 10
thật của từ khoá chính trước khi tạo (rule chi-viet-bai-khi-ro-intent-va-doi-thu).

Menu: 5 mục dạng mega menu theo 5 nhóm trên + "Blog" + nút "Nhận báo giá" (1 dòng, ẩn vào
hamburger dưới 1280px). Trang chủ chuyển từ "chỉ booking báo" sang "đơn vị truyền thông và SEO":
khối 5 nhóm dịch vụ, khối đầu báo đã hợp tác, case study thật, 1 form báo giá chọn nhóm dịch vụ.

## 4. Bảng 301

### 4.1 Không có URL live nào phải đổi
Mọi trang/bài đang có traffic giữ nguyên URL. Trang nháp publish lại đúng slug cũ -> không cần 301.

### 4.2 301 đang chạy - giữ nguyên (`functions.php`)
| URL cũ | Đích |
|---|---|
| `/bang-gia/` | `/` |
| `/dich-vu/` | `/` |
| `/dich-vu/<pillar>/...` | `/<pillar>/...` |
| `/booking-bao-pr/<báo>/` | `/book-bao-<báo>/` |
| `/dich-vu-entity/`, `/backlink-social/` | `/backlink-social-entity/` |
| `/dich-vu/dich-vu-backlink/bat-dong-san/` | `/backlink-bat-dong-san/` |
| `/danh-muc/...` | `/category/...` |
Lưu ý khi làm: handler `/dich-vu/<x>` chỉ bắt URL bắt đầu bằng `/dich-vu/` (có gạch chéo) nên
không ảnh hưởng slug mới `/dich-vu-seo/...`.

### 4.3 Ứng viên gộp (ăn thịt từ khoá) - CHỈ làm sau khi đo SERP trùng >= 3 URL
| Trang | GSC 90 ngày (hiện / vị trí) | Đề xuất nếu SERP trùng |
|---|---|---|
| `/google-sge/` | 27 / 25,7 | 301 -> `/ai-overview/` (Google đã đổi tên SGE thành AI Overviews) |
| `/seo-dia-phuong/` vs `/local-seo/` | 11 / 6,1 vs 18 / 51,8 | gộp về `/seo-dia-phuong/` (đang đứng tốt hơn) |
| `/dich-vu-backlink/bat-dong-san/` (trang) vs `/backlink-bat-dong-san/` (bài) | 16 / 44,8 vs 19 / 6,5 | giữ bài, trang dịch vụ đổi hướng nội dung hoặc gộp |
| `/seo-trong-thoi-dai-ai/` vs `/geo-generative-engine-optimization/` | 20 / 17,4 vs 5 / 21,8 | đo SERP rồi quyết |

### 4.4 Cách làm 301 an toàn khi triển khai
1. Thêm dòng vào mảng `$dgc_gop` trong `functions.php` (chỉ chạy khi URL cũ 404 -> không vòng lặp).
2. Draft trang bị gộp SAU khi đã gộp nội dung, sửa link nội bộ trỏ thẳng URL mới.
3. Kiểm `curl -sI` từng URL cũ ra đúng 1 bước 301 -> 200; ép index URL đích; theo dõi GSC 4 tuần.

## 5. Thứ tự triển khai đề xuất
1. Nhóm 2 Truyền hình (đã có trang + 226 dòng giá nháp, chỉ cần soát giá + publish) - nhanh nhất.
2. Thiết kế lại header/mega menu + trang chủ 5 nhóm (không đổi URL).
3. Nhóm 3 SEO: publish `/dich-vu-seo/` + 5 trang mới (mỗi trang qua đo SERP, viết >= 1.500 từ).
4. Nhóm 4 Tên miền/hosting: CHỜ Hiếu chọn nhà cung cấp đại lý + bảng giá vốn.
5. Gộp ứng viên mục 4.3 sau khi đo SERP.

## Nguồn
- Danh mục Brandcom: https://brandcom.vn/ (đọc 24/10/2026)
- Danh mục SEODO: https://seodo.vn/ (đọc 24/10/2026)
- Danh mục Hashmeta: https://hashmeta.com/vn/seo-services-vietnam
- Danh mục Mắt Bão: https://www.matbao.net/ ; P.A Việt Nam: https://www.pavietnam.vn/
- Nhà đăng ký .vn và Thông tư 24/2015/TT-BTTTT: https://faq.webnic.cc/kb/vn/ , https://fptshop.com.vn/tin-tuc/danh-gia/vnnic-182451
