# Chat AI tư vấn (DeepSeek) - digicomvn.com (2026-07-15)

Widget chat AI ở TRANG CHỦ - **SECTION 2, ngay dưới hero** (không phải trên hero) tư vấn khách chọn dịch vụ. Dùng DeepSeek
(giống chatbot Zalo ICD), API tương thích OpenAI: `https://api.deepseek.com/chat/completions`,
model mặc định `deepseek-chat`.

## Kiến trúc
- `inc/ai-chat.php`: toàn bộ server-side.
  - `dgc_ai_key()`: ưu tiên constant `DGC_DEEPSEEK_KEY` (wp-config) -> fallback option `ai_key`.
  - `dgc_ai_enabled()`: option `ai_chat_on` bật VÀ có key.
  - `dgc_ai_system_prompt()`: nạp 7 dịch vụ + khoảng giá thật (`dgc_ai_price_brief()` query CPT
    `dgc_gia` theo `dgc_nhom`, cache transient 1h) + ràng buộc KHÔNG bịa giá/đầu báo, chốt giá
    đẩy về hotline/Zalo/bảng giá. Field `ai_kb` (WP Admin) cho phép bổ sung kiến thức.
  - AJAX `wp_ajax(_nopriv)_dgc_ai_chat`: check nonce `dgc_ai`, rate-limit 30 lượt/giờ/IP
    (transient), cắt 12 lượt gần nhất + 1500 ký tự/tin, max_tokens 700, temp 0.4.
  - `dgc_ai_chat_box()`: render hộp chat, include ở front-page.php NGAY SAU section hero (section 2), trước khối dịch vụ.
- `functions.php`: require ai-chat.php + `wp_localize_script('dgc-main-js','DGC_AI',{url,nonce})`
  chỉ khi enabled.
- `main.js` IIFE `[data-ai-chat]`: gọi ajax, đổ bubble user/bot, nút gợi ý.
- CSS `.ai-chat-*` cuối main.css (có dark mode).

## Bật chat (Hiếu làm)
1. Đặt key trong `wp-config.php` (an toàn nhất): `define('DGC_DEEPSEEK_KEY','sk-...');`
   HOẶC dán vào WP Admin > DigicomVN > mục 8 > "DeepSeek API key" (lưu trong CSDL).
2. WP Admin > DigicomVN > mục 8 > "Bat chat AI" = `1` -> Lưu. Chat hiện ở trang chủ.
3. Tắt: đặt "Bat chat AI" = `0` (hoặc xoá key).

## Chi phí + chống spam
- Trả phí theo lượt gọi DeepSeek (rất rẻ với deepseek-chat). Rate-limit 30 lượt/giờ/IP đã cài.
- Key KHÔNG bao giờ ra JS/repo (chỉ ở server). KHÔNG hardcode key trong file theme.

## Sửa nội dung tư vấn
- Câu chào: option `ai_intro`. Nút gợi ý: `ai_suggestions` (cách nhau `|`). Kiến thức thêm: `ai_kb`.
- Đổi model: `ai_model` (vd `deepseek-reasoner` nếu cần suy luận sâu, đắt hơn).
- Giá trong prompt tự đọc từ CPT `dgc_gia` -> đổi bảng giá là AI cập nhật (cache 1h).
