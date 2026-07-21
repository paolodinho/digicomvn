# Nguồn ảnh minh họa - quy trình chọn (chốt 2026-07-11, cập nhật 2026-07-13)

> Rule Hiếu: xoay giữa các nguồn free, chọn ảnh tốt nhất cho từng trường hợp -
> không mặc định 1 nguồn, không dùng đại cho đủ số lượng.

## 2 LOẠI ẢNH KHÁC NHAU - đừng nhầm (bổ sung 2026-07-21)

- **Ảnh minh hoạ khái niệm/chủ đề** (trang trí, tăng thẩm mỹ): dùng Storyset/Wikimedia... theo
  toàn bộ rule bên dưới.
- **Ảnh dạng CHỤP MÀN HÌNH** (dashboard, bảng phân tích, kết quả kiểm tra công cụ, so sánh số
  liệu, trước/sau): KHÔNG lấy từ stock. Dựng bằng skill `.claude/skills/visual-screenshot/`
  (HTML Digicom -> Chrome headless -> webp). Site cần NHIỀU loại này (Hiếu 2026-07-21).
  Bắt buộc trung thực: không giả UI tool bên thứ ba làm "dữ liệu thật"; số ví dụ phải gắn nhãn
  "MẪU MINH HOẠ" (xem SKILL.md). Sự cố gốc: bài anchor text từng để ảnh chụp Ahrefs form trống
  caption "dữ liệu thật DigicomVN" -> đã thay bằng bảng phân tích tự dựng.

## Phong cách ảnh minh hoạ (rule 2026-07-13 - GHI ĐÈ mục "icon 3D generic" ở checklist)

Áp dụng cho **trang dịch vụ (4 pillar + hub) và toàn bộ bài blog**: ảnh minh hoạ chủ đề
(không phải ảnh sản phẩm/đội ngũ thật) dùng **phong cách illustration nhân vật** (character
illustration) thay cho ảnh chụp thật ở vị trí này.

- Đây là ngoại lệ CHỦ ĐỘNG so với dòng "Không phải kiểu AI-slop... icon 3D generic. Ưu tiên
  ảnh chụp thật" trong checklist bên dưới - dòng đó áp cho ảnh SẢN PHẨM/ĐỘI NGŨ (vẫn giữ
  nguyên theo `ui-anti-slop.md` global), KHÔNG áp cho ảnh minh hoạ khái niệm/chủ đề bài viết.
- Mỗi ảnh phải khớp đúng chủ đề bài (vd bài về Domain Rating -> minh hoạ đo lường/chỉ số,
  không dùng đại 1 ảnh "SEO" chung chung cho mọi bài).
- **Nguồn đã chốt 2026-07-13: Storyset (storyset.com, cùng hệ Freepik).** Freepik gốc (kho
  3D-render đúng style ảnh mẫu ban đầu Hiếu gửi) bị chặn bot khi truy cập qua trình duyệt tự
  động (đã thử: Freepik/Magnific đổi thương hiệu không load được, Vecteezy toàn quảng cáo
  Shutterstock trả phí, Pixabay chặn hẳn PerimeterX) -> Hiếu xác nhận dùng Storyset thay thế,
  chấp nhận đổi từ "3D bóng render" sang "vector phẳng nhân vật" (5 style: Rafiki, Bro, Amico,
  Pana, Cuate - chọn style nhất quán xuyên suốt site, ưu tiên Rafiki hoặc Amico).
- Storyset cho tuỳ biến màu chủ đạo theo brand trước khi tải (SVG/PNG) - tận dụng để đồng bộ
  màu Digicom thay vì giữ màu mặc định.
- Giấy phép Storyset (Freepik company): bắt buộc ghi credit trừ khi có Freepik Premium. Hiếu
  KHÔNG có Premium -> dùng bản free, BẮT BUỘC ghi credit (link storyset.com) - đặt credit dạng
  nhỏ cuối bài (hoặc gộp 1 khối "Nguồn ảnh minh hoạ" cuối bài nếu nhiều ảnh).
- **Có hồi tố**: 9 trang đã chèn ảnh chụp thật trước đó (4 pillar + hub dịch vụ + 5 bài
  domain-rating/domain-authority/page-authority/trust-flow/citation-flow) cũng làm lại theo
  style Storyset, không giữ ảnh chụp cũ. Backup ảnh/nội dung cũ đã có sẵn trong
  `~/Claude-Workspace/_backups/routines/2026-07-13/` trước khi thay.

## Thứ tự ưu tiên nguồn (ảnh chụp thật - áp dụng cho ảnh sản phẩm/đội ngũ/địa danh)

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
