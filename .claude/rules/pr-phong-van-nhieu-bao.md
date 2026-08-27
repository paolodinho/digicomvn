# PR có phỏng vấn + đăng nhiều đầu báo - quy tắc (chốt Hiếu 2026-08-27)

> Sự cố gốc: dự án A&P Việt Nam (kỷ niệm 10 năm, đăng Diễn đàn Doanh nghiệp + CafeBiz).
> Bản đầu tôi làm 2 góc tiếp cận khác nhau cho 2 báo, 54 câu hỏi, 1 file dùng chung cho cả
> khách lẫn phóng viên -> Hiếu sửa cả 3 điểm.

## 1. MỘT góc tiếp cận, KHÔNG chia góc theo từng báo

- Đăng cùng 1 chiến dịch lên nhiều đầu báo -> chốt **1 góc tiếp cận duy nhất**, phỏng vấn
  **1 lần**, dùng chung 1 bộ thông tin. KHÔNG dựng 2 góc tiếp cận khác nhau cho 2 báo (khách
  phải trả lời 2 lần, tốn thời gian của cả 2 bên, và không cần thiết).
- Cách ra 2 bài: viết **1 bản gốc**, rồi **biên tập lại** thành bản thứ 2. Giữ nguyên thông
  điệp, số liệu, nhân vật; chỉ đổi: tiêu đề + sapo (viết mới hoàn toàn), thứ tự triển khai
  (bản 2 mở bằng hiện tại rồi kể ngược), diễn đạt lại câu chữ (khác tối thiểu ~50%), nhóm
  quote được chọn (mỗi bản 1 nhóm quote riêng), bộ ảnh minh hoạ (không trùng ảnh chính).
- Lý do phải khác câu chữ: 2 bài giống hệt -> Google chỉ ghi nhận 1, bỏ qua bài còn lại;
  một số toà soạn cũng từ chối bài đã đăng nguyên văn nơi khác.
- **Hệ quả khi phỏng vấn**: phải lấy được NHIỀU ý và nhiều cách diễn đạt cho cùng 1 nội dung,
  vì mỗi bản đăng cần bộ quote riêng. Ghi chú điều này vào brief phóng viên.

## 2. Số câu hỏi phải khớp thời lượng thật - mặc định ~20 câu

- Buổi phỏng vấn thực tế thường chỉ **25-30 phút** (tổng buổi 30-45 phút gồm cả chụp ảnh).
  Trung bình ~1,5 phút/câu -> **~20 câu là trần**, không làm 50+ câu rồi bảo "chọn lọc sau".
- Cách rút: **gộp các câu cùng ý** thành 1 câu 2 vế (vd "bà đã làm gì trước đây? + điều gì
  thôi thúc lập công ty?"), KHÔNG cắt bỏ khía cạnh quan trọng.
- Chốt thời lượng với khách TRƯỚC khi soạn câu hỏi, đừng soạn xong mới hỏi.

## 3. LUÔN tách 2 bản: bản gửi KHÁCH và bản gửi PHÓNG VIÊN

Cùng 1 chiến dịch phải ra **2 file riêng**, cùng thư mục, phân biệt bằng TÊN (theo rule global
`to-chuc-file-goi-y.md`):

| Bản | Tên file | Chứa gì |
|---|---|---|
| Gửi khách | `GUI-<KHACH>-...docx` | Bảng thông tin buổi làm việc, góc tiếp cận, bộ câu hỏi TRẦN (không ghi chú), checklist tài liệu/số liệu cần chuẩn bị, yêu cầu chụp hình, lưu ý phối hợp, đầu mối |
| Gửi phóng viên | `NOIBO-Brief-Phong-Vien-...docx` | Toàn bộ bản khách CỘNG: hồ sơ research về khách hàng, bảng số liệu nghiên cứu dùng làm chất liệu hỏi, **mục "khoảng trống thông tin cần khai thác"**, dòng "Mục đích khai thác" dưới từng câu, cảnh báo nghiệp vụ, tiến độ toàn chiến dịch |

**TUYỆT ĐỐI không gửi bản phóng viên cho khách** - nó chứa phần research về chính khách hàng
(gồm mục "khoảng trống thông tin", đọc lên dễ thành chê hồ sơ khách sơ sài) và các ghi chú
nghiệp vụ kiểu "cố lấy bằng được ví dụ", "đẩy để lấy tình huống thật", "tránh câu trả lời
kiểu khó khăn nào cũng vượt qua". Bản phóng viên phải có dòng chữ đỏ **"TÀI LIỆU NỘI BỘ -
KHÔNG GỬI CHO KHÁCH HÀNG"** ngay trang bìa.

Kỹ thuật: dựng 1 script sinh docx duy nhất, truyền tham số `ap|pv` để bật/tắt phần nội bộ
(mẫu: `scratchpad/build-ap-2ban.js` phiên 2026-08-27) - sửa 1 chỗ ra đúng 2 bản, không copy
2 file rồi sửa tay (dễ lệch nội dung giữa 2 bản).

## 4. Research khách hàng TRƯỚC khi soạn câu hỏi

Không soạn câu hỏi chung chung. Bắt buộc research trước để biết cái gì đã công khai (không
hỏi lại) và cái gì chưa có (đây mới là phần cần hỏi):
- Cổng thông tin doanh nghiệp (masothue.com...): tên pháp lý, MST, **ngày thành lập** (để
  xác minh mốc kỷ niệm có đúng không), người đại diện.
- Website khách: dịch vụ, sứ mệnh, tin tức dự án, khách hàng của họ.
- Đối tác/chứng nhận quốc tế của khách (nếu có) - thường là điểm mạnh nhất trong hồ sơ, phải
  đào sâu thành 1 nhóm câu hỏi riêng.
- Nghiên cứu ngành có số liệu (báo cáo của chính đối tác quốc tế của khách) - dùng làm chất
  liệu hỏi, nâng tầm chuyên môn bài viết. Ghi rõ số liệu nào dùng cho câu nào trong brief
  phóng viên.
- Ghi lại **danh sách khoảng trống thông tin** (thứ không nguồn nào có) -> đây chính là phần
  tạo giá trị riêng cho bài, và là mục cần khai thác kỹ nhất khi phỏng vấn.

## 5. Xưng hô - lấy từ nguồn khách cung cấp, không tự suy đoán

Cách gọi (anh/chị/ông/bà) lấy theo **chính email/tài liệu khách gửi**, verify chéo bằng cổng
thông tin doanh nghiệp (người đại diện pháp luật). Trong file gửi khách dùng văn phong báo chí
("Ông/Bà <Họ tên> - <chức danh>") kèm 1 dòng ghi chú mời khách xác nhận lại cách xưng hô mong
muốn trên mặt báo trước khi gửi toà soạn.

## Liên quan
- `to-chuc-file-goi-y.md` (global) - tách file nội bộ/gửi khách, báo path file chính lên đầu.
- `bao-gia-khach-hang.md` - cùng nguyên tắc 2 file cho báo giá.
- `content-professional.md` (global) - không bịa số liệu; số liệu lên báo phải do khách xác nhận.
- `khong-link-doi-thu.md` (global) - không nêu tên khách hàng của khách nếu chưa được phép.
