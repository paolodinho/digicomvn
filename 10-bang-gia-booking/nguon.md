# Nguồn báo giá booking báo & PR - trạng thái thu thập

> Cập nhật 2026-07-14. Task hàng ngày `booking-price-daily` quét lại các nguồn trạng thái ĐÃ CÓ + thử lại nhóm CHƯA LẤY ĐƯỢC.

## ĐÃ CÓ BẢNG GIÁ CHI TIẾT

| Bên | Nguồn | Số dòng | Cách lấy |
|---|---|---|---|
| **DanaSEO** | [Google Sheet](https://docs.google.com/spreadsheets/d/1-g7qY-e2d6c555zVSOqKuVCm0e-Restes2ikSX7az9E/edit) - 10 tab | 157 | Chrome đã đăng nhập Google -> fetch `gviz/tq?tqx=out:csv&sheet=<tên tab>`. Drive API/curl KHÔNG lấy được (file bị chặn generative-AI + không public). |
| **Fame Media** | https://famemedia.vn/bao-online/ | 23 | WebFetch. Bảng vị trí premium trang chủ (giá 15-230tr), khác phân khúc DanaSEO. Ngân sách tối thiểu 50tr/tháng. |
| **SEOViP** | https://seovip.vn/dich-vu-book-bao-pr/ | 3 | WebFetch. Chỉ có giá khởi điểm theo nhóm (báo lớn từ 2tr, báo Đảng từ 1tr, báo rẻ từ 700k). Chưa có bảng từng đầu báo. |

### Bổ sung 2026-07-14 (7 mũi quét)

| Bên | Dòng | Ghi chú |
|---|---|---|
| **Admicro (VCCorp)** | 40 | RATE CARD CHÍNH THỨC (PDF). `https://in.admicro.vn/uploads/bien-tap-thong-tin-847/<bao>_admicro_prs_<thang>.pdf`. Còn 14 file chưa bóc: genk, gamek, autopro, vtv, skds, giadinhnet, phunuvietnam, 2sao, infonet, vietnambiz, vietnammoi... |
| **SEOViP** | 77 | Sheet `1nnNiOqhXnBm7rEX1uEh89wFqZkbYmhYVtCfFJdphDy4` - 24 tab, có giá niêm yết + giá CK + số link + quy cách. Chi tiết nhất. |
| **DPS.MEDIA** | 194 | Sheet `1BS00ZmGiGUZdNil4obhn7rqdHDRsqi32PksWpChmle8` - báo lớn/tỉnh/dofollow + 90 site guest post VN + 81 site global. |
| **Guestpost.vn** | 50 | Sheet `1MzjTwv811rzgZYnLdzXF7j7_QcQCr3qfrYDy-p-8ks4` - textlink báo theo từng site, 3/6/12 tháng. |
| Fame Media | 63 | + trang ZNews riêng (famemedia.vn/new-zings). |
| Brando, SEODO, Xuyên Việt, BookBaoPR, QuangbaThuonghieu, Hapo, MicCreative, Web Media | 51 | Theo từng đầu báo. |
| Entity: Solann, SEOTOP, SEOTORO, BuffSEO, HapoDigital, Khoahocseotop, dichvuentity.vn, Tùng Phát, Vutruso | 34 | Solann rẻ nhất mọi mức - đúng mốc rule 120% Solann. |
| Textlink lẻ: SGC.vn, Nguyễn Lê Điệp, DesignerVN, Web Thực Chiến, Seotoro | 15 | Seotoro: dofollow trong bài Dân trí = 5tr/link/tháng (mốc trần). |
| guestpost.com.vn, bookbaopr.vn, DPS global | 114 | Guest post theo site. |

## CHƯA LẤY ĐƯỢC - giá để dạng ảnh / bảng ẩn / yêu cầu liên hệ

| Bên | URL | Vướng gì |
|---|---|---|
| Brandcom | https://brandcom.vn/ (có trang riêng từng báo: vnexpress, dantri, kenh14, zing) | Bảng giá nhúng dưới dạng ẢNH -> WebFetch không đọc được text. Cần OCR hoặc xin file. |
| Vietquangcao | https://vietquangcao.org/quang-cao-tren-bao-dien-tu-bao-gia-booking-pr-banner/ | Bảng để shortcode `[table id=5]` không render. Chỉ nói dải 1-8tr, CK 10-35%. |
| MicCreative | https://miccreative.vn/bao-gia-bai-pr-vnexpress/ | Chỉ có dải giá (VnExpress 15-50tr), không chi tiết từng mục. |
| Đất Việt Media | datvietbrand.com | Domain không phân giải (chết/đổi tên). |
| Dr POS / opp.vn | https://opp.vn/bang-gia-booking-cac-bao/ | 404. |
| ECP Media | https://ecpmedia.vn/bang-gia-dang-bai-viet-pr-tren-bao-vnexpress.html | Chưa quét. |
| PR Báo Chí | https://prbaochi.com/category/bao-gia-pr/ | Chưa quét. |
| Brands Vietnam | https://help.brandsvietnam.com/vi/article/bao-gia-dang-bai-pr-7i6lbx/ | Chưa quét. |

## Cần Hiếu hỗ trợ để mở rộng kho

Bảng giá chi tiết từng đầu báo hầu như KHÔNG công khai - các bên chỉ gửi file qua sale (giống cách DanaSEO gửi Google Sheet). Cách nhanh nhất để có thêm dữ liệu:
1. Xin file/sheet báo giá từ 2-3 bên nữa (Fame Media, Brandcom, ECP...) -> paste link vào đây, tôi bóc tự động như đã làm với DanaSEO.
2. Ảnh chụp bảng giá cũng được - tôi đọc ảnh trực tiếp.
