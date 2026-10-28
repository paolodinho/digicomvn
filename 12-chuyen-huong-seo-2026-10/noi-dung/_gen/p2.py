from h import *
AIF="https://developers.google.com/search/docs/appearance/ai-features"
CRAWL="https://developers.google.com/search/docs/crawling-indexing/google-common-crawlers"
OAI="https://platform.openai.com/docs/bots"
HC="https://developers.google.com/search/docs/fundamentals/creating-helpful-content"
GSC="https://developers.google.com/search/docs/fundamentals/do-i-need-seo"
def build():
    s=""
    s+=p("<strong>Dịch vụ SEO AI</strong>, còn gọi là GEO, là tối ưu website và thương hiệu để Google AI Overviews, AI Mode, ChatGPT, Perplexity, Gemini đọc hiểu và trích dẫn. DigicomVN kết hợp nền SEO kỹ thuật, nội dung trả lời trực tiếp và độ phủ thương hiệu trên nguồn uy tín.")
    s+=summary([
        ("Mục tiêu","thương hiệu xuất hiện và được dẫn nguồn khi khách hỏi AI về lĩnh vực của doanh nghiệp"),
        ("Nền tảng","vẫn là SEO chuẩn: Google xác nhận không có yêu cầu kỹ thuật riêng cho AI Overviews và AI Mode"),
        ("Khác biệt","nội dung viết theo dạng câu hỏi và câu trả lời, thực thể thương hiệu nhất quán, được nhắc trên báo và nguồn bên thứ ba"),
        ("Chi phí","báo giá sau khi audit miễn phí; không cam kết số lần được AI trích dẫn"),
    ])
    s+=h2("seo-ai-la-gi","SEO AI khác SEO truyền thống ở điểm nào?")
    s+=lead("Phần lớn nền tảng giữ nguyên; thứ thay đổi là cách người dùng nhận câu trả lời và cách nội dung được chọn để trích dẫn.")
    s+=p("Với tìm kiếm truyền thống, mục tiêu là trang của doanh nghiệp nằm trong danh sách mười liên kết và được bấm vào. Với câu trả lời do AI tổng hợp, người dùng đọc một đoạn tóm tắt trước, kèm vài nguồn được dẫn. Doanh nghiệp vì vậy cần hai thứ cùng lúc: trang vẫn được lập chỉ mục và xếp hạng tốt, đồng thời có những đoạn nội dung đủ rõ ràng, đủ đáng tin để hệ thống AI chọn làm nguồn.")
    s+=compare("Giữ nguyên từ SEO truyền thống",[
        "Trang phải được thu thập dữ liệu và lập chỉ mục",
        "Nội dung hữu ích, có chuyên môn, có người chịu trách nhiệm",
        "Cấu trúc liên kết nội bộ rõ ràng, tốc độ tải tốt",
        "Liên kết và nhắc tên từ nguồn uy tín",
    ],"Cần làm thêm cho SEO AI",[
        "Mỗi câu hỏi quan trọng có một đoạn trả lời thẳng 40 đến 60 từ ngay dưới heading",
        "Tên, địa chỉ, sản phẩm, người đại diện thống nhất trên mọi kênh",
        "Thương hiệu được nhắc trên báo, diễn đàn, hồ sơ ngành mà AI hay dẫn",
        "Theo dõi câu trả lời của từng công cụ AI theo bộ câu hỏi mẫu",
    ],"Phần lớn công việc SEO AI là làm SEO tốt hơn, cộng thêm lớp thực thể thương hiệu và cách trình bày câu trả lời.")
    s+=h2("google-noi-gi-ve-ai-overviews","Google nói gì về việc xuất hiện trong AI Overviews và AI Mode?")
    s+=lead("Không có thẻ, tệp hay schema đặc biệt nào; trang chỉ cần đủ điều kiện xuất hiện trong Google Search với đoạn trích.")
    s+=p("Trong tài liệu "+ext(AIF,"AI features and your website")+", Google nêu rằng không có yêu cầu bổ sung nào để xuất hiện trong AI Overviews hay AI Mode, cũng không cần tối ưu đặc biệt, không cần tệp văn bản dành riêng cho AI và không có dữ liệu có cấu trúc schema.org bắt buộc. Điều kiện là trang được lập chỉ mục và đủ điều kiện hiển thị với đoạn trích trong kết quả tìm kiếm thông thường.")
    s+=p("Các khuyến nghị Google đưa ra vẫn là nền tảng quen thuộc: cho phép thu thập dữ liệu trong robots.txt và trên CDN, giúp nội dung dễ tìm qua liên kết nội bộ, giữ thông tin quan trọng ở dạng văn bản, dùng ảnh và video chất lượng khi phù hợp, để dữ liệu có cấu trúc khớp với nội dung hiển thị, cập nhật Google Business Profile và Merchant Center. Vì vậy, bất kỳ lời chào bán nào về một thủ thuật kỹ thuật bí mật để vào AI Overviews đều nên được nhìn với sự thận trọng.")
    s+=p("Một hiểu lầm phổ biến khác liên quan tới token Google-Extended trong robots.txt. Theo "+ext(CRAWL,"tài liệu trình thu thập dữ liệu của Google")+", Google-Extended điều khiển việc dùng nội dung cho huấn luyện mô hình Gemini và cho tính năng grounding trong Gemini Apps, Vertex AI; nó không ảnh hưởng việc website có mặt trong Google Search và không phải tín hiệu xếp hạng. Chặn hay mở token này là quyết định chính sách dữ liệu của doanh nghiệp, không phải đòn bẩy SEO.")
    s+=h2("nen-tang-ai-lay-nguon","Mỗi nền tảng AI lấy nguồn từ đâu?")
    s+=lead("Mỗi công cụ có trình thu thập dữ liệu riêng; chặn nhầm một bot là tự đóng cửa với nền tảng đó.")
    s+=table("Nguồn dữ liệu và việc cần kiểm tra trên từng nền tảng trả lời bằng AI",
        ["Nền tảng","Nguồn chính","Việc cần kiểm tra"],[
        ["Google AI Overviews, AI Mode","Chỉ mục Google Search (Googlebot)","Trang được lập chỉ mục, có đoạn trích, không bị chặn bởi noindex hay robots.txt"],
        ["ChatGPT search","Trình thu thập OAI-SearchBot của OpenAI","robots.txt và tường lửa không chặn OAI-SearchBot ("+ext(OAI,"tài liệu OpenAI")+")"],
        ["Perplexity","Trình thu thập PerplexityBot và kết quả tìm kiếm web","Không chặn PerplexityBot; nội dung có câu trả lời rõ, có nguồn"],
        ["Gemini","Dữ liệu Google; token Google-Extended cho huấn luyện và grounding","Quyết định chính sách cho Google-Extended, không nhầm với Googlebot"],
        ["Copilot","Chỉ mục Bing (Bingbot)","Website đã khai báo trên Bing Webmaster Tools, không chặn Bingbot"],
    ])
    s+=p("Trong các buổi audit, lỗi gặp nhiều nhất không nằm ở nội dung mà ở hạ tầng: tường lửa hoặc dịch vụ chống bot mặc định chặn các trình thu thập lạ, khiến website vô hình với một số công cụ AI dù đứng tốt trên Google. Đây là việc kiểm tra mất ít thời gian nhưng thường bị bỏ qua.")
    s+=h2("mo-hinh-3-lop","Mô hình ba lớp của dịch vụ SEO AI")
    s+=lead("Nội dung chỉ được trích dẫn khi AI đọc được trang, hiểu câu trả lời và tin vào nguồn.")
    s+=tiers([
        ("Lớp 1: Đọc được","Thu thập dữ liệu, lập chỉ mục, tốc độ, nội dung chính ở dạng văn bản, không bị chặn bot"),
        ("Lớp 2: Hiểu được","Heading dạng câu hỏi, đoạn trả lời thẳng, bảng so sánh, dữ liệu có cấu trúc khớp nội dung"),
        ("Lớp 3: Tin được","Thực thể thương hiệu nhất quán, tác giả thật, được nhắc trên báo và nguồn ngành uy tín"),
    ],"Ba lớp làm theo thứ tự: lớp dưới chưa vững thì đầu tư lớp trên ít hiệu quả.")
    s+=p("Lớp thứ ba là nơi nhiều website Việt Nam yếu nhất. Các hệ thống AI có xu hướng tổng hợp thông tin từ nhiều nguồn độc lập; một thương hiệu chỉ tự giới thiệu trên website của mình khó được dẫn hơn thương hiệu được báo chí, hiệp hội ngành và cộng đồng nhắc tới. DigicomVN có sẵn hạ tầng cho lớp này qua "+a("/booking-bao-pr/","booking báo PR")+", "+a("/backlink-social-entity/","hồ sơ social entity chuẩn NAP")+" và "+a("/guest-post/","guest post")+" trên site cùng lĩnh vực.")
    s+=h2("hang-muc-dich-vu-seo-ai","Hạng mục công việc trong dịch vụ SEO AI")
    s+=lead("Sáu bước, bắt đầu từ việc đo xem AI đang nói gì về doanh nghiệp.")
    s+=steps([
        ("Đo điểm xuất phát","Chạy bộ câu hỏi mẫu trên Google, ChatGPT, Perplexity, Gemini; ghi lại ai đang được trích dẫn."),
        ("Audit kỹ thuật","Kiểm tra robots.txt, tường lửa, lập chỉ mục, dữ liệu có cấu trúc và nội dung bị ẩn sau JavaScript."),
        ("Chuẩn hoá thực thể","Thống nhất tên, mô tả, địa chỉ, sản phẩm trên website, Google Business Profile và hồ sơ mạng xã hội."),
        ("Viết lại nội dung","Bổ sung đoạn trả lời thẳng, bảng so sánh, số liệu có nguồn cho các trang đích quan trọng."),
        ("Mở rộng độ phủ","Đăng bài trên báo và site cùng ngành để thương hiệu có mặt ở nguồn bên thứ ba."),
        ("Theo dõi, báo cáo","Lặp lại bộ câu hỏi theo tháng, so sánh nguồn được trích dẫn và lưu lượng từ Search Console."),
    ])
    s+=p("Bộ câu hỏi mẫu được xây từ câu hỏi thật của khách hàng: câu hỏi đội bán hàng hay nhận, câu hỏi trong mục Mọi người cũng hỏi của Google và gợi ý tìm kiếm. Câu trả lời của AI thay đổi theo thời điểm và cách đặt câu hỏi, nên báo cáo ghi rõ ngày đo và nguyên văn câu hỏi để kết quả so sánh được giữa các tháng.")
    s+=h2("do-hieu-qua-seo-ai","Đo hiệu quả SEO AI bằng cách nào?")
    s+=lead("Chưa có công cụ chính thức nào đếm số lần một thương hiệu được AI trích dẫn; cần kết hợp nhiều nguồn.")
    s+=p("DigicomVN dùng ba nhóm chỉ số. Thứ nhất là dữ liệu Google Search Console và GA4: lượt hiển thị, lượt nhấp và lưu lượng giới thiệu từ các nền tảng AI. Thứ hai là bảng theo dõi trích dẫn theo bộ câu hỏi mẫu, ghi lại thương hiệu có được nhắc, được dẫn link hay không. Thứ ba là tín hiệu thương hiệu gián tiếp như lượt tìm kiếm tên thương hiệu và số khách hàng cho biết họ biết tới doanh nghiệp qua công cụ AI.")
    s+=p("Vì kết quả của AI không ổn định và không công khai cơ chế chọn nguồn, DigicomVN không cam kết số lần được trích dẫn hay vị trí cố định trong câu trả lời. Điều này nhất quán với khuyến cáo của Google rằng "+ext(GSC,"không ai đảm bảo được thứ hạng số 1")+". Cam kết của chúng tôi là phạm vi công việc rõ ràng và dữ liệu đo trung thực.")
    s+=h2("chi-phi-seo-ai","Chi phí dịch vụ SEO AI phụ thuộc vào đâu?")
    s+=lead("Chi phí được chốt sau audit, dựa trên nền SEO hiện có và mức độ hiện diện thương hiệu ngoài website.")
    s+=p("Website đã có nền SEO tốt thường chỉ cần bổ sung lớp trình bày câu trả lời và chuẩn hoá thực thể, chi phí thấp hơn đáng kể so với website chưa được lập chỉ mục đầy đủ. Các yếu tố chính gồm: số trang đích cần viết lại, số câu hỏi cần theo dõi, số nền tảng AI cần đo, và nhu cầu đăng bài trên báo hay site bên ngoài. Các khoản đăng bài có "+a("/booking-bao-pr/","bảng giá công khai")+" và được liệt kê riêng trong báo giá.")
    s+=p("SEO AI hiệu quả nhất khi đi cùng "+a("/dich-vu-seo/","dịch vụ SEO tổng thể")+"; doanh nghiệp có cửa hàng nên kết hợp "+a("/dich-vu-seo-local/","SEO local")+", vì AI hay dùng dữ liệu Google Business Profile cho câu hỏi tìm địa điểm. Nội dung trả lời câu hỏi có thể đặt qua "+a("/dich-vu-viet-bai-chuan-seo/","dịch vụ viết bài chuẩn SEO")+". Tham khảo thêm nguyên tắc "+ext(HC,"nội dung hữu ích của Google")+" và các bài phân tích trên "+a("/blog/","blog DigicomVN")+". Gửi website qua "+a("/lien-he/","trang liên hệ")+" hoặc gọi 0988 769 317 để nhận bản đo điểm xuất phát miễn phí.")
    return s
