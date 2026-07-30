# Hướng dẫn tạo Service Account cho đồng bộ Google Sheet bảng giá

> Làm 1 lần duy nhất (~5 phút). Sau đó tôi tự động đồng bộ giá mỗi khi routine tuần chạy,
> không cần Hiếu làm lại bước này.

## Bước 1 - Tạo project (nếu chưa có project nào dùng cho việc này)

1. Vào https://console.cloud.google.com/
2. Góc trên bên trái, bấm chọn project -> "New Project"
3. Đặt tên bất kỳ, vd `digicom-price-sync` -> Create

## Bước 2 - Bật 2 API cần dùng

1. Vào https://console.cloud.google.com/apis/library
2. Tìm và bấm **Enable** cho: **Google Sheets API**
3. Tìm và bấm **Enable** cho: **Google Drive API**

## Bước 3 - Tạo Service Account

1. Vào https://console.cloud.google.com/iam-admin/serviceaccounts
2. Bấm **Create Service Account**
3. Tên: `digicom-sheet-sync` -> Create and Continue -> bỏ qua phần role (Continue) -> Done

## Bước 4 - Tạo key JSON

1. Bấm vào service account vừa tạo (trong danh sách)
2. Tab **Keys** -> **Add Key** -> **Create new key** -> chọn **JSON** -> Create
3. File JSON tự động tải về máy - gửi file này cho tôi (qua Zalo/Drive/kéo thả vào chat),
   HOẶC copy vào `10-bang-gia-booking/service-account.json` (file này đã có sẵn trong `.gitignore`
   nên không lộ lên GitHub).

## Bước 5 - Ghi lại email service account

Trong tab **Details** của service account, copy dòng **Email** (dạng
`digicom-sheet-sync@<project-id>.iam.gserviceaccount.com`) - gửi cho tôi, tôi cần email này
để share Google Sheet cho nó.

## Xong

Sau khi có file JSON + email, tôi sẽ:
1. Tạo Google Sheet mới (do tôi dựng qua service account, hoặc Hiếu tạo tay rồi share Editor
   cho email trên - tôi sẽ báo phương án cụ thể khi bắt tay làm).
2. Set quyền "Xem được, không tải/copy/in được" cho người xem link.
3. Nối vào routine tuần `digicom-gia-doi-tac-tuan` để tự đẩy giá mới lên Sheet mỗi lần cập nhật.

**Lưu ý bảo mật:** File JSON là "chìa khoá" của service account - không share công khai,
không đưa lên GitHub. Đã thêm `service-account.json` vào `.gitignore` sẵn.
