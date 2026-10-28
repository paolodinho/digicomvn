from h import *
GSC="https://developers.google.com/search/docs/fundamentals/do-i-need-seo"
SEG="https://developers.google.com/search/docs/fundamentals/seo-starter-guide"
HC="https://developers.google.com/search/docs/fundamentals/creating-helpful-content"
SPAM="https://developers.google.com/search/docs/essentials/spam-policies"
def build():
    s=""
    s+=p("<strong>Dịch vụ SEO</strong> là thuê đơn vị chuyên môn tối ưu website để xuất hiện cao hơn trên Google cho đúng từ khoá khách hàng đang tìm. DigicomVN nhận SEO tổng thể và SEO từ khoá: audit kỹ thuật, nghiên cứu từ khoá, tối ưu onpage, nội dung, off-page và báo cáo minh bạch hằng tháng.")
    s+=summary([
        ("Phù hợp với","doanh nghiệp muốn có khách hàng đều đặn từ Google thay vì phụ thuộc hoàn toàn vào quảng cáo trả tiền"),
        ("Hai hình thức","SEO tổng thể cho toàn website, hoặc SEO theo bộ từ khoá đã chọn trước"),
        ("Chi phí","báo giá sau khi audit miễn phí website và bộ từ khoá, không áp một bảng giá chung cho mọi ngành"),
        ("Cam kết","minh bạch công việc, báo cáo số liệu thật từ Google Search Console; không cam kết vị trí số 1"),
    ])
    s+=h2("dich-vu-seo-gom-nhung-gi","Dịch vụ SEO của DigicomVN gồm những hạng mục nào?")
    s+=lead("Một dự án SEO đầy đủ có sáu nhóm việc, mỗi nhóm có đầu ra cụ thể mà doanh nghiệp kiểm tra được.")
    s+=p("Nhiều doanh nghiệp từng thuê SEO nhưng không biết đơn vị đã làm gì trong tháng, chỉ nhận một bảng thứ hạng. Để tránh tình trạng đó, DigicomVN chia công việc thành các hạng mục có bàn giao rõ ràng. Bảng dưới đây mô tả phạm vi chuẩn; với từng website, phạm vi thực tế được chốt sau buổi audit đầu tiên, vì một website mới và một website đã có hàng trăm bài viết cần mức đầu tư rất khác nhau.")
    s+=table("Các hạng mục trong dịch vụ SEO của DigicomVN và đầu ra bàn giao",
        ["Hạng mục","Công việc chính","Đầu ra bàn giao"],[
        ["Audit kỹ thuật","Kiểm tra khả năng thu thập dữ liệu, lập chỉ mục, tốc độ, cấu trúc URL, dữ liệu có cấu trúc, lỗi trùng lặp","Báo cáo lỗi theo mức ưu tiên, kèm cách sửa"],
        ["Nghiên cứu từ khoá","Gom từ khoá theo ý định tìm kiếm thật, đo top 10 Google, xác định dạng trang Google đang ưu tiên","Bản đồ từ khoá: mỗi nhóm từ gắn với một URL đích"],
        ["Tối ưu onpage","Tiêu đề, mô tả, heading, ảnh, liên kết nội bộ, schema cho từng trang đích","Danh sách trang đã tối ưu, trước và sau"],
        ["Nội dung",a("/dich-vu-viet-bai-chuan-seo/","Viết mới")+" hoặc bổ sung bài cũ theo kế hoạch cụm chủ đề","Bài viết đăng trên website, có ngày đăng và URL"],
        ["Off-page","Liên kết từ "+a("/booking-bao-pr/","báo điện tử")+", "+a("/guest-post/","guest post")+", "+a("/backlink-social-entity/","social entity")+" theo nhu cầu","Danh sách link kèm vị trí, ngày đăng, trạng thái index"],
        ["Đo lường","Theo dõi lượt hiển thị, lượt nhấp, thứ hạng và chuyển đổi","Báo cáo tháng từ Google Search Console và GA4"],
    ])
    s+=p("Hạng mục off-page là chỗ DigicomVN có lợi thế riêng: mạng lưới "+a("/booking-bao-pr/","booking báo PR")+" của chúng tôi niêm yết giá công khai theo từng vị trí đăng, nên khi dự án SEO cần thêm liên kết từ báo, doanh nghiệp xem được trước mỗi vị trí giá bao nhiêu thay vì nhận một con số gộp khó kiểm chứng.")
    s+=h2("seo-tong-the-va-seo-tu-khoa","SEO tổng thể và SEO từ khoá khác nhau thế nào?")
    s+=lead("SEO tổng thể nâng chất lượng toàn website; SEO từ khoá tập trung đẩy một nhóm từ đã chọn. Lựa chọn phụ thuộc vào giai đoạn của doanh nghiệp.")
    s+=p("Trên thị trường, hai cách gọi này thường bị dùng lẫn. Về bản chất, SEO tổng thể xem website như một hệ thống: sửa nền kỹ thuật, xây cụm nội dung cho từng nhóm sản phẩm hay dịch vụ, rồi để lưu lượng tự nhiên tăng trên hàng trăm từ khoá dài. SEO từ khoá bắt đầu từ một danh sách cụ thể, thường là các từ mang ý định mua rõ ràng, và đo kết quả theo thứ hạng của chính danh sách đó.")
    s+=compare("SEO theo bộ từ khoá",[
        "Phạm vi: danh sách từ khoá chốt từ đầu, thường 10 đến vài chục từ",
        "Đo bằng thứ hạng của từng từ trong danh sách",
        "Phù hợp khi đã biết rõ sản phẩm chủ lực cần bán",
        "Rủi ro: bỏ lỡ lượng tìm kiếm từ các biến thể dài không có trong danh sách",
    ],"SEO tổng thể",[
        "Phạm vi: toàn website, gồm kỹ thuật, nội dung và liên kết",
        "Đo bằng lượt hiển thị, lượt nhấp và chuyển đổi trên toàn site",
        "Phù hợp khi muốn Google coi website là nguồn chuyên môn của cả lĩnh vực",
        "Cần thời gian dài hơn nhưng kết quả bền và ít phụ thuộc vào vài từ khoá",
    ],"So sánh hai hình thức. Nhiều dự án kết hợp cả hai: làm tổng thể, nhưng ưu tiên trước nhóm từ khoá mang doanh thu.")
    s+=p("Với website mới, DigicomVN thường khuyên bắt đầu bằng nền tảng tổng thể (kỹ thuật và cấu trúc nội dung) trước khi chạy theo thứ hạng của từng từ, vì trang chưa được lập chỉ mục đúng thì tối ưu từ khoá nào cũng khó lên. Với website đã có lưu lượng, có thể ưu tiên ngay nhóm từ đang ở trang 2 Google, nơi một vài thay đổi nhỏ đôi khi tạo ra khác biệt rõ.")
    s+=h2("quy-trinh-trien-khai","Quy trình triển khai dịch vụ SEO")
    s+=lead("Sáu bước, mỗi bước kết thúc bằng một tài liệu doanh nghiệp duyệt trước khi chuyển sang bước sau.")
    s+=steps([
        ("Audit miễn phí","Kiểm tra website, Search Console (nếu được cấp quyền) và đối thủ đang đứng top để biết điểm xuất phát."),
        ("Nghiên cứu từ khoá","Gom từ theo ý định tìm kiếm, đo top 10 Google thật, chốt mỗi nhóm từ một trang đích."),
        ("Đề xuất và báo giá","Gửi phạm vi công việc, ưu tiên theo tháng và chi phí; doanh nghiệp duyệt trước khi bắt đầu."),
        ("Sửa nền kỹ thuật","Xử lý lỗi lập chỉ mục, tốc độ, trùng lặp, dữ liệu có cấu trúc theo mức ưu tiên."),
        ("Nội dung và liên kết","Tối ưu trang đích, viết bài theo cụm, xây liên kết nội bộ và off-page khi cần."),
        ("Đo lường, điều chỉnh","Báo cáo tháng từ dữ liệu Google, giữ hướng đang hiệu quả, đổi hướng chỗ chưa có tín hiệu."),
    ])
    s+=p("Điểm khác biệt nằm ở bước 2: DigicomVN không gom từ khoá theo cảm tính hay theo chữ giống nhau. Hai từ khoá chỉ được xếp vào cùng một trang khi kết quả top 10 Google của chúng trùng nhau đáng kể, tức Google đang coi chúng là cùng một nhu cầu. Cách làm này tránh tình trạng hai trang trên cùng website tranh nhau một từ khoá, một lỗi phổ biến khiến cả hai trang cùng đứng yên.")
    s+=h2("chi-phi-dich-vu-seo","Chi phí dịch vụ SEO là bao nhiêu?")
    s+=lead("Chi phí SEO không có một con số chung; nó phụ thuộc vào bốn nhóm yếu tố và chỉ được chốt sau khi audit website.")
    s+=p("Đây là câu hỏi doanh nghiệp tìm nhiều nhất khi cân nhắc thuê SEO. Câu trả lời trung thực là: hai website cùng ngành có thể cần mức đầu tư chênh nhau nhiều lần. Một website đã có nền kỹ thuật tốt và vài trăm bài viết chỉ cần định hướng lại; một website mới dựng, chưa có nội dung, cần làm gần như từ đầu. Vì vậy DigicomVN không công bố bảng giá cố định cho dịch vụ SEO mà gửi báo giá sau buổi audit miễn phí, kèm phạm vi công việc chi tiết để doanh nghiệp so sánh được.")
    s+=tiers([
        ("Hiện trạng website","Số trang, lỗi kỹ thuật, nội dung đã có, lịch sử phạt hoặc tụt hạng"),
        ("Độ cạnh tranh từ khoá","Đối thủ đang đứng top là ai, họ đầu tư nội dung và liên kết đến mức nào"),
        ("Khối lượng công việc","Số bài cần viết, số trang cần tối ưu, nhu cầu liên kết từ báo và site cùng ngành"),
        ("Mục tiêu và thời hạn","Thị trường, số khu vực hoặc ngôn ngữ, tốc độ mong muốn và nguồn lực nội bộ của doanh nghiệp"),
    ],"Bốn lớp yếu tố quyết định chi phí, từ hẹp đến rộng.")
    s+=p("Một số khoản có giá công khai ngay từ đầu, như "+a("/mua-textlink/","textlink")+", "+a("/guest-post/","guest post")+" hay "+a("/booking-bao-pr/","bài PR trên báo")+". Khi các khoản này nằm trong dự án SEO, DigicomVN liệt kê riêng từng dòng thay vì gộp vào phí quản lý, để doanh nghiệp biết tiền đi vào đâu. Nếu website cần làm lại hạ tầng, có thể tham khảo thêm "+a("/hosting/","hosting")+" và "+a("/ten-mien/","tên miền")+".")
    s+=h2("vi-sao-khong-cam-ket-top-1","Vì sao DigicomVN không cam kết top 1 Google?")
    s+=lead("Vì không ai kiểm soát được thuật toán Google, và chính Google khuyến cáo cảnh giác với lời hứa đó.")
    s+=p("Trong tài liệu "+ext(GSC,"Do you need an SEO?")+", Google viết rõ rằng không ai có thể đảm bảo vị trí số 1 trên Google. Thứ hạng thay đổi theo từng truy vấn, từng khu vực, từng thiết bị và sau mỗi đợt cập nhật thuật toán. Một cam kết top 1 trong thời gian cố định thường dẫn tới hai hệ quả: hoặc đơn vị chọn những từ khoá rất ít người tìm để dễ đạt, hoặc dùng thủ thuật nằm trong "+ext(SPAM,"chính sách spam của Google")+" như mua liên kết ồ ạt, tạo nội dung hàng loạt giá trị thấp. Cả hai đều không mang lại khách hàng thật.")
    s+=p("Thay vào đó, DigicomVN cam kết những điều kiểm soát được: phạm vi công việc rõ ràng, bàn giao đúng hạng mục, báo cáo bằng dữ liệu thật từ Google Search Console và mọi thay đổi trên website đều được ghi lại kèm lý do. Đây cũng là những tiêu chí Google gợi ý doanh nghiệp hỏi khi chọn đơn vị SEO.")
    s+=h2("cau-hoi-truoc-khi-thue-seo","Nên hỏi gì trước khi thuê một đơn vị SEO?")
    s+=lead("Dựa trên gợi ý của Google, đây là những câu hỏi giúp sàng lọc đơn vị SEO trong buổi gặp đầu tiên.")
    s+=ul([
        "Đơn vị có làm theo nguyên tắc Google Search Essentials không, và ví dụ cụ thể là gì?",
        "Kết quả nào là hợp lý để kỳ vọng, sau khoảng thời gian bao lâu, đo bằng chỉ số nào?",
        "Đơn vị có kinh nghiệm với ngành, thị trường hoặc khu vực của doanh nghiệp không?",
        "Mọi thay đổi trên website có được báo lại kèm lý do không?",
        "Liên kết off-page lấy từ đâu, có danh sách và trạng thái index để kiểm tra không?",
    ])
    s+=p("Câu hỏi cuối cùng đặc biệt quan trọng. DigicomVN không bán và không triển khai liên kết trên tên miền .gov.vn hay .edu.vn, vì cơ quan nhà nước và trường học không có cơ chế bán liên kết; nguồn cung loại này trên thị trường chủ yếu đến từ website bị chèn link trái phép. Mọi liên kết trong dự án đều có danh sách cụ thể để doanh nghiệp tự kiểm tra.")
    s+=h2("dich-vu-seo-chuyen-sau","Các dịch vụ SEO chuyên sâu theo nhu cầu")
    s+=lead("Ngoài SEO tổng thể, DigicomVN có các gói chuyên biệt cho từng mục tiêu tăng trưởng.")
    s+=cards([
        (a("/dich-vu-seo-ai/","SEO AI (GEO)"),"Tăng khả năng thương hiệu được AI Overviews, AI Mode, ChatGPT và Perplexity trích dẫn."),
        (a("/dich-vu-seo-local/","SEO local"),"Tối ưu Google Business Profile và Google Maps cho cửa hàng, phòng khám, chi nhánh."),
        (a("/dich-vu-seo-quoc-te/","SEO quốc tế"),"Website đa ngôn ngữ, hreflang và nội dung bản địa hoá cho thị trường nước ngoài."),
        (a("/dich-vu-viet-bai-chuan-seo/","Viết bài chuẩn SEO"),"Nội dung theo kế hoạch cụm chủ đề, có biên tập và kiểm chứng số liệu."),
    ])
    s+=p("Doanh nghiệp có đội SEO nội bộ có thể chỉ cần công cụ: xem tư vấn "+a("/phan-mem-seo/","phần mềm SEO")+" chính hãng. Người muốn tự học có thể theo dõi "+a("/khoa-hoc-seo/","khoá học SEO")+" sắp mở hoặc đọc các bài kiến thức trên "+a("/blog/","blog DigicomVN")+". Tài liệu gốc nên đọc trước khi bắt đầu là "+ext(SEG,"hướng dẫn SEO cơ bản của Google")+" và nguyên tắc "+ext(HC,"nội dung hữu ích, đáng tin cậy")+".")
    s+=p("Để bắt đầu, gửi địa chỉ website và nhóm sản phẩm chủ lực qua "+a("/lien-he/","trang liên hệ")+" hoặc gọi hotline 0988 769 317. DigicomVN sẽ audit miễn phí và gửi đề xuất phạm vi công việc trước khi báo giá.")
    return s
