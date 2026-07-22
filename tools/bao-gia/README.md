# Tạo báo giá Google Sheet từ điện thoại

Lọc bảng giá (`10-bang-gia-booking/gia-web.csv`) theo ngành / dịch vụ / ngân sách rồi tạo
1 file Google Sheet có header thương hiệu, gửi link cho khách.

## Cài đặt (làm 1 lần, khoảng 5 phút)

1. Mở https://script.google.com > **New project**.
2. Xoá code mẫu, dán toàn bộ nội dung `apps-script.gs` vào.
3. Sửa 2 dòng đầu:
   - `TOKEN`: đặt 1 chuỗi mật khẩu riêng (bắt buộc, vì URL web app là công khai).
   - `FOLDER_ID`: ID thư mục Drive muốn lưu báo giá (lấy từ URL thư mục). Để trống = lưu ở My Drive.
4. **Deploy > New deployment > Web app**: Execute as **Me**, Who has access **Anyone**. Copy URL kết thúc bằng `/exec`.
   - Lần đầu Google sẽ hỏi cấp quyền, bấm Advanced > Go to project (unsafe) > Allow. Đây là script của chính mình nên an toàn.
5. `cp config.mau.json config.json`, điền `webapp_url` (URL /exec) và `token` (đúng chuỗi ở bước 3).

`config.json` đã được gitignore - token không lên GitHub.

Sau bước này không cần đụng lại script nữa, chỉ chạy lệnh.

## Dùng

```bash
# Xem trước trong terminal, không tạo sheet
python3 tao-bao-gia.py --nganh suc-khoe --dich-vu booking-pr --so-luong 15 --xem-truoc

# Tạo sheet thật, trả về link (chị Huyền tạo, lưu vào thư mục của chị Huyền)
python3 tao-bao-gia.py --nganh suc-khoe --dich-vu booking-pr --so-luong 15 --khach "Chị Lan" --pic huyen

# Theo ngân sách: nhồi tối đa số đầu báo trong 50 triệu
python3 tao-bao-gia.py --nganh bat-dong-san --ngan-sach 50000000

# Xem các ngành dùng được
python3 tao-bao-gia.py --liet-ke-nganh
```

| Tham số | Ý nghĩa |
|---|---|
| `--nganh` | Lọc theo lĩnh vực. Bỏ trống = lấy báo lớn đa ngành |
| `--dich-vu` | `booking-pr`, `guest-post`, `textlink`, `toplist`, `booking-tv`, `backlink-quocte` |
| `--so-luong` | Số dòng đưa vào báo giá (mặc định 15) |
| `--gia-min` / `--gia-max` | Chặn khoảng giá mỗi đầu báo |
| `--ngan-sach` | Trần tổng đơn. Có tham số này thì bỏ qua `--so-luong` |
| `--khach` | Tên khách, in vào tiêu đề + tên file |
| `--pic` | Người tạo: `thang` (mặc định) / `huyen` / `trang`. Tên + SĐT PIC in vào dòng liên hệ báo giá |
| `--loai` | Loại sản phẩm = tên thư mục Drive tầng 2. Bỏ trống = lấy tên dịch vụ (vd "Booking báo & PR") |
| `--hieu-luc` | Số ngày báo giá còn hiệu lực (mặc định 7) |

## File lưu ở đâu trên Drive

Sheet tạo xong tự nằm trong cây thư mục: **`<thư mục gốc>/<Tên PIC>/<Loại sản phẩm>/`**.
Ví dụ `--pic huyen --dich-vu guest-post` → `.../Đỗ Thị Thanh Huyền/Guest Post/Bao gia ...`.
Thư mục con chưa có thì tự tạo.

Muốn đổi/chọn thư mục gốc: dán ID thư mục Drive vào `FOLDER_ID` trong `apps-script.gs`
(lấy từ URL thư mục: `drive.google.com/drive/folders/ID_Ở_ĐÂY`). Để trống = lưu ở My Drive.

## Cách lọc ngành

Khớp theo **tên miền**, không khớp mô tả bài (từ "được" trong mô tả từng dính nhầm vào
keyword ngành y tế). Nếu số đầu báo đúng ngành chưa đủ `--so-luong`, tự bổ sung báo lớn
đa ngành (VnExpress, Dân trí, 24h, Kênh 14...) vì các báo này phù hợp mọi lĩnh vực.

## Lưu ý

- Giá lấy từ `gia-web.csv` (đã ẩn nhà cung cấp, đã markup) - an toàn để gửi khách.
  KHÔNG dùng `bang-gia-master.csv` (có giá vốn + tên NCC).
- Chưa gồm VAT 8%, đúng theo `.claude/rules/bang-gia-booking.md`.
- Muốn cập nhật giá mới nhất: chạy lại pipeline trong `10-bang-gia-booking/` trước.
