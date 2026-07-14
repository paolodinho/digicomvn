# Kho dữ liệu báo giá Booking báo & PR (Việt Nam)

> Lập 2026-07-14. Nguồn tra cứu khi làm việc với khách hàng: "bài VnExpress bên nào có giá, bao nhiêu".

## File trong thư mục

| File | Nội dung |
|---|---|
| `bang-gia-master.csv` | **File chính.** Mọi dòng giá đã chuẩn hoá, gộp mọi nhà cung cấp. |
| `tra-cuu.py` | Công cụ tra nhanh theo đầu báo / nhà cung cấp / mức giá. |
| `nguon.md` | Danh sách nguồn + trạng thái thu thập (bên nào đã có bảng chi tiết, bên nào còn giấu giá). |
| `build_master.py` | Script dựng lại `bang-gia-master.csv` từ `raw/`. |
| `raw/` | Bản thô tải về từ từng nguồn (sheet DanaSEO 10 tab...). |

## Quy tắc giá (chốt 2026-07-14)

**Giá Digicom báo khách = GIÁ GỐC niêm yết của nhà cung cấp**, áp cho **mọi bên** (DanaSEO lẫn các bên khác). Không nhân markup.
- Giá chưa bao gồm VAT 8%.
- Cột `gia_ncc_km` = giá khuyến mãi / giá mua vào thực tế (nếu NCC có) -> đây là phần lợi nhuận của Digicom, **không đưa cho khách**.
- VD VnExpress mục Giáo dục (DanaSEO): báo khách 12.000.000, mua vào 9.200.000.

## Cột trong `bang-gia-master.csv`

`nha_cung_cap, dau_bao, nhom, vi_tri, gia_ncc_goc, gia_ncc_km, gia_ban_digicom, so_link, quy_cach, ghi_chu, nguon, ngay_cap_nhat`

`nhom`: `PR bao lon` | `Bao tinh / bao dang` | `Bao link dofollow` | `PR bao lon (vi tri premium)`

## Cách tra khi khách hỏi

```bash
cd "10-bang-gia-booking"
python3 tra-cuu.py vnexpress            # mọi bên có giá cho VnExpress
python3 tra-cuu.py dantri
python3 tra-cuu.py --ncc danaseo         # toàn bộ bảng giá 1 bên
python3 tra-cuu.py --duoi 3000000        # các đầu báo dưới 3 triệu
```

Hoặc hỏi thẳng Claude trong session dự án digicom: "bài VnExpress hiện các bên nào" - Claude đọc file này trả lời.

## Cập nhật hàng ngày

Scheduled task `booking-price-daily` (chạy 8h sáng): quét lại các nguồn trong `nguon.md`, thêm dòng giá mới, ghi biến động vào `CHANGELOG.md`. Sheet DanaSEO chỉ đọc được qua Chrome đã đăng nhập Google (Drive API chặn file này).
