# Nguồn ảnh minh họa - quy trình chọn (chốt 2026-07-11)

> Rule Hiếu: xoay giữa các nguồn free, chọn ảnh tốt nhất cho từng trường hợp -
> không mặc định 1 nguồn, không dùng đại cho đủ số lượng.

## Thứ tự ưu tiên nguồn

1. **Ảnh thật của Digicom/khách hàng** (nếu có) - chính xác tuyệt đối, ưu tiên tuyệt đối khi có sẵn.
2. **Wikimedia Commons** - ảnh có định vị/license rõ ràng, mạnh về địa danh, tòa nhà, khu công nghiệp
   Việt Nam thật. Dùng API `action=query&list=search&srnamespace=6` + kiểm `LicenseShortName`
   (CC0/CC BY-SA đều dùng được, ghi nguồn nếu BY-SA).
3. **Openverse** (openverse.org, gom cả Flickr CC + Wikimedia + bảo tàng) - dùng khi Wikimedia
   không có ảnh phù hợp, đặc biệt ảnh đời thường do người Việt tự đăng.
4. **Pexels / Pixabay / Unsplash** - CHỈ dùng khi 2 nguồn trên không ra kết quả, và phải duyệt
   kỹ từng ảnh (xem mục Checklist) vì đa số model/bối cảnh là phương Tây.

## Checklist bắt buộc trước khi dùng bất kỳ ảnh nào

- [ ] Không có chữ nước ngoài dễ nhận ra (tiếng Anh/khác) làm lộ bối cảnh không phải Việt Nam,
      trừ khi đó là ảnh landmark rõ ràng đã xác nhận đúng địa danh VN.
  - [ ] Không dùng bàn phím/thiết bị có ký hiệu tiền tệ khác VND (£, € standalone) làm ảnh minh họa chung.
- [ ] Không phải ảnh lỗi thời (CRT, nội thất thập niên 1990-2000) trừ khi bài có yếu tố lịch sử.
- [ ] Không phải kiểu ảnh "AI-slop": wordcloud clip-art, ảnh ghép biểu đồ giả lên tay gõ phím,
      icon 3D generic. Ưu tiên ảnh chụp thật hơn ảnh minh họa khái niệm.
- [ ] Nếu ảnh có logo/tên thương hiệu cụ thể không liên quan bài viết (VD Samsung, Trina Solar) -
      chỉ dùng trong khung cảnh trung lập (skyline chung), KHÔNG gắn caption ngụ ý là khách hàng/đối tác.
- [ ] Ảnh phải sát chủ đề đoạn văn nó minh họa, không chỉ "có vẻ liên quan chung chung".
- [ ] Giấy phép CC0/CC BY/CC BY-SA/Public Domain - ghi nguồn nếu BY/BY-SA yêu cầu.

## Cách làm

Với mỗi vị trí cần ảnh: thử nguồn 1 → không có thì nguồn 2 → nguồn 3 → nguồn 4, xem trước
bằng Read tool (không chỉ tin caption/tên file), rồi mới quyết định dùng. Không dừng ở kết quả
đầu tiên nếu chưa soát chất lượng.

## Liên quan
- `ui-anti-slop.md` (global) - ảnh sản phẩm/người thật, chống AI-slop.
- Bài học từ đợt 2026-07-11 (5 bài PR digicomvn): ảnh cũ (bàn phím £/€, callcenter CRT,
  wordcloud) đều là stock lỗi thời/nước ngoài - đã thay bằng ảnh Wikimedia xác thực địa danh.
