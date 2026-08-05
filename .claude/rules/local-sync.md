# Local WP install có thể lệch bản so với code trong Drive - luôn đồng bộ trước khi test

> Phát hiện 2026-08-05: theme trên Local WP (`~/Local Sites/digicom/app/public/wp-content/themes/digicom-host`)
> lệch bản gần 2 tuần (dừng ở snapshot 25/7) so với code trong thư mục dự án Google Drive
> (`wp-theme/digicom-host`, cập nhật liên tục). Sửa code xong mở Local lên KHÔNG thấy thay đổi
> gì - vì Local đang chạy bản cũ, thiếu cả tính năng lẫn bản sửa mới.

## Nguyên tắc

Trước khi mở trình duyệt test bất kỳ thay đổi UI/PHP nào trên Local, **luôn đồng bộ code từ
thư mục dự án sang Local trước** - đừng giả định 2 nơi tự khớp nhau (chúng không tự sync).

```bash
rsync -a --exclude="._*" --exclude=".DS_Store" --exclude="assets/images/" \
  "/Users/dohieu/My Drive/Projects/digicom/wp-theme/digicom-host/" \
  "/Users/dohieu/Local Sites/digicom/app/public/wp-content/themes/digicom-host/"
```

Loại trừ `assets/images/` vì ảnh trên Local là ảnh thật đã upload qua Media Library - rsync đè
sẽ mất ảnh riêng của Local (nếu có), trong khi ảnh trong Drive project chỉ là bản gốc/asset gốc.

Trước khi ghi đè lần đầu ở 1 máy mới/lâu không sync -> backup theo `backup-before-edit.md`
(global): copy toàn bộ thư mục theme Local hiện tại vào
`~/Claude-Workspace/_backups/routines/<ngày>/local-theme-sync/` trước khi rsync.

## Vì sao lệch

Deploy lên LIVE (Hostinger) đi qua SSH riêng (`deploy.md`), không đụng tới Local. Việc "copy
sang Local" là bước THỦ CÔNG, không có trong quy trình tự động nào - dễ bị quên nếu nhiều
session làm việc trực tiếp trên code Drive mà không mở trình duyệt kiểm tra ngay.

## Hệ quả cần lưu ý

Vì gap này kéo dài ~2-3 tuần (từ 25/7), khả năng cao nhiều tính năng làm trong khoảng đó (giá,
schema, trang mới...) cũng CHƯA từng được xem qua trên Local trước khi báo "xong" - rule
`quality-bar.md` mục "test UI trong browser trước khi báo xong" có thể đã không được tuân thủ
đúng nghĩa trong giai đoạn này vì Local hiển thị sai bản.

## Liên quan
- `deploy.md` - deploy code lên live (SSH, khác hoàn toàn với đồng bộ Local).
- `backup-before-edit.md` (global) - backup trước khi ghi đè.
