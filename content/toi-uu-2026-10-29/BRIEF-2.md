# Brief tối ưu đợt 2 (29/10 tối) - cụm mới đo SERP 29/10, CHỈ CỘNG THÊM

Áp Y NGUYÊN `BRIEF.md` cùng thư mục (giữ nguyên byte bản gốc, chỉ chèn khối mới, visual cho mỗi H2 mới, FAQ H3, cấm dash/tên NCC/đối thủ, không số giá mới, tự QA difflib).
Dữ liệu SERP cụm mới: `/Volumes/Extreme SSD/Projects/digicom/06-keyword/serp-con-lai-2026-10-29/clusters.json` (mỗi cụm: loi, tu [từ, volume], tieu_de top 10, paa, ai, dang_trang). Dùng tiêu đề top 10 + PAA để chọn H2/FAQ.

## Trang MỚI soạn (bản gốc ở goc/<slug>.html)
1. `pr-la-gi` (blog) - cụm "pr" (12.100), "pr public relations" (6.600), "quan hệ công chúng" (3.600 + "quan hệ công chúng là" 260 + "quan hệ công chúng pr" 70), "khái niệm quan hệ công chúng", "pr & communication". Thêm: câu trả lời thẳng "PR (Public Relations) là quan hệ công chúng..." gần đầu nếu bài chưa có câu đó; H2 "Quan hệ công chúng là gì" (nếu chưa có) nhấn khái niệm + vai trò; FAQ từ PAA. Không viết lại phần PR và quảng cáo (bài riêng /pr-va-quang-cao-khac-nhau/ chưa đăng, không link).
2. `backlink-social-entity` (money page dịch vụ) - cụm "dịch vụ entity" (2.900), "dịch vụ backlink entity" (110), "dịch vụ social entity" (50), "backlink entity" (50). Thêm 1 H2 ngắn "Dịch vụ entity gồm những gì" (hoặc tương đương theo tiêu đề top 10) + FAQ theo PAA. Không đụng khối giá/form. Nhắc rõ hồ sơ phải của doanh nghiệp thật (không tạo hồ sơ ảo hàng loạt).
3. `quang-cao-tvc-la-gi` (blog) - cụm "tvc quảng cáo" (390), "quảng cáo tvc" (90), "quay quảng cáo tvc", "tvc quảng cáo doanh nghiệp", "báo giá tvc quảng cáo", "kịch bản tvc quảng cáo mỹ phẩm". Thêm H2 về quy trình làm TVC quảng cáo cho doanh nghiệp (các bước sản xuất: brief, kịch bản, quay, hậu kỳ, kiểm duyệt nội dung theo Luật Quảng cáo, phát sóng) nếu bài chưa có; chi phí chỉ nêu yếu tố, không số mới.
4. `guest-post` (money page dịch vụ) - cụm "mua guest post" (260). Thêm 1 H2 ngắn hoặc FAQ chứa "mua guest post" (cách mua an toàn: chọn site đúng ngành, kiểm traffic thật, nội dung thật, nhãn/thuộc tính link). Không đụng khối giá/form.

## Trang ĐÃ có bản soạn - BỔ SUNG THÊM vào chính file soạn (không vào goc/)
5. `dich-vu-backlink.html` - cụm "mua backlink" (720) + "backlink báo", "mua backlink chất lượng", "mua backlink giá rẻ", "bán backlink" (tổng 1.010). Thêm 1 câu FAQ H3 chứa "mua backlink" vào mục FAQ mới đã soạn (H2 "Câu hỏi thường gặp về dịch vụ backlink"), câu trả lời nói cách mua an toàn; không gov/edu.
6. `booking-kol-koc.html` - cụm "booking koc tiktok" (70) + "book kol tiktok" (50), "kol tiktok" (110), "koc tiktok" (70), "kol livestream"/"kols livestream" (280). Thêm 1 đoạn hoặc thẻ trong khối KOC đã soạn nói booking KOL/KOC TikTok và livestream (đặc thù nền tảng, nhãn hợp tác, không cam kết doanh số).
Với 5 và 6: chỉ chèn thêm vào file soạn; kiểm difflib so với goc/ vẫn chỉ có dòng '+'.

Báo lại mỗi trang 1 dòng: slug, số từ thêm, heading/FAQ mới, PAA dùng.
