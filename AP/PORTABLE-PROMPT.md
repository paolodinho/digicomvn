# AP — Context chuyển tiếp

## 1. Dự án là gì
Hồ sơ PR kỷ niệm 10 năm A&P Việt Nam của DigicomVN, gồm bài báo CafeBiz/Diễn Đàn Doanh Nghiệp và ảnh doanh nhân.

## 2. Tôi là ai
Hiếu điều phối dự án. Trả lời tiếng Việt, ngắn gọn, không emoji, không hỏi lại điều đã chốt.

## 3. Mục tiêu
Task ngày 2026-10-05: thay nền cả 8 ảnh HEIC IMG_8243, IMG_8245, IMG_8255, IMG_8268, IMG_8273, IMG_8275, IMG_8285, IMG_8292 thành văn phòng điều hành thanh lịch.

## 4. Brand info
A&P Việt Nam. Giữ chính xác logo A&P trên sổ/brochure, logo HP trên laptop và chữ in hiện có. Không thêm logo mới. Bài PR đã chốt hướng giải thích vì sao A&P chọn DDI; CafeBiz đã chốt không sửa thêm.

## 5. DO / DON'T
Chỉ thay nền, giữ tuyệt đối mặt, da, tóc, biểu cảm, trang phục, tư thế, tay, ghế da đen, bàn, laptop, sổ, bút, chuột và brochure. Giữ góc chụp, framing và độ phân giải. Phản hồi khách 15:49 ngày 2026-10-05: giảm chi tiết bên phải và sửa hướng sáng. Bản v2: tường kem/greige + lam óc chó, một tranh lớn trầm, kệ bên phải chỉ một bình cây nhỏ; bỏ sách, khung tranh phụ, đèn hắt và bóng nắng lá. Ánh sáng tản từ camera-right tương thích ảnh gốc. Không sửa ảnh nguồn. Không claim giữ nguyên pixel khi AI tái tạo; không upscale rồi gọi là độ phân giải gốc.

## 6. Cấu trúc file
Nguồn: `/Volumes/Extreme SSD/Projects/digicom/AP/8 ảnh mới/` (tên Unicode phân rã có thể khác chuỗi hiển thị). Bản chuyển đổi PNG nguyên bản và prompt: `/Users/dohieu/Codex-Workspace/digicom/context/photo-office-2026-10-05/`. Output: `/Users/dohieu/Codex-Workspace/digicom/ap-anh-moi-office-2026-10-05/`, tên `IMG_XXXX-office-v1.png` và `IMG_XXXX-office-v2.png`. Metadata: `AP/PLAN.md`, `LOG.md` ở root Digicom.

## 7. Trạng thái
Cả 8 v1 và cả 8 v2 đã tạo xong. Bộ bàn giao là v2, đóng ZIP `AP-8-anh-van-phong-v2.zip` trong thư mục output local nêu trên (15 MB, unzip -t 8/8 OK). Tool imagegen built-in xuất tất cả 1448x1086 so với nguồn 5712x4284 hoặc 4032x3024; có tái tạo tiền cảnh, chữ nhỏ và chi tiết da ghế. QA trực quan cả 8: nền gọn và hướng sáng mềm thiên phải đúng phản hồi. Giới hạn bảo toàn tuyệt đối chưa đạt và đã thông báo. Prompt từng ảnh: `v2-prompts.json` trong thư mục context local nêu trên.

## 8. Yêu cầu tiếp theo
Ngày 2026-10-06 khách đã duyệt content/background, chọn IMG_8245/IMG_8285/IMG_8292-v2 và yêu cầu giảm nhẹ nếp nhăn, bọng mắt/quầng thâm, làm mặt thon hơn một chút. Đây là ngoại lệ mới cho yêu cầu không sửa mặt trước đó, chỉ áp dụng 3 ảnh chọn. Đã tạo đủ 3 v3-retouch, 1448x1086, ZIP `AP-3-anh-retouch-v3.zip` trong output local (5,3 MB, unzip -t 3/3 OK). Prompt `v3-retouch-prompts.json` trong context local. Chờ Hiếu/khách duyệt mức chỉnh mặt. Giữ v2 và HEIC nguồn. Không gửi tin nhắn cho khách khi chưa được Hiếu cho phép. Không claim pixel ngoài vùng mặt được bảo toàn tuyệt đối bởi AI.

Cập nhật sau ảnh chat bổ sung ngày 2026-10-06: tổng 4 ảnh chọn, thêm IMG_8273. Đã tạo v3-retouch cho ảnh này và đóng bộ bàn giao mới `AP-4-anh-retouch-v3.zip` tại thư mục output local, kiểm tra ZIP 4/4 OK. Prompt bổ sung `v3-retouch-8273-prompt.txt` trong thư mục context. Bộ 4 ảnh này thay ZIP 3 ảnh trước khi bàn giao.
