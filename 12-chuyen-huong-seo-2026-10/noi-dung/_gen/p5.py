from h import *
HC="https://developers.google.com/search/docs/fundamentals/creating-helpful-content"
GAI="https://developers.google.com/search/docs/fundamentals/using-gen-ai-content"
TL="https://developers.google.com/search/docs/appearance/title-link"
SN="https://developers.google.com/search/docs/appearance/snippet"
SPAM="https://developers.google.com/search/docs/essentials/spam-policies"
def build():
    s=""
    s+=p("<strong>Dịch vụ viết bài chuẩn SEO</strong> là thuê đội biên tập viết nội dung đúng nhu cầu người tìm kiếm, được tối ưu để Google và công cụ AI hiểu, xếp hạng. DigicomVN đọc top 10 Google trước khi lập dàn ý, kiểm chứng số liệu và bàn giao bài đã tối ưu onpage.")
    s+=summary([
        ("Nhận viết","bài blog, trang dịch vụ, trang danh mục, mô tả sản phẩm, bài PR, nội dung tiếng Anh"),
        ("Trước khi viết","đọc top 10 Google thật, câu hỏi người dùng hay hỏi, rồi gửi dàn ý để duyệt"),
        ("Chất lượng","số liệu có nguồn, không sao chép, có biên tập viên đọc lại trước khi giao"),
        ("Chi phí","tính theo độ khó chủ đề, độ dài và yêu cầu chuyên môn; báo giá sau khi nhận danh sách chủ đề"),
    ])
    s+=h2("bai-viet-chuan-seo-la-gi","Thế nào là một bài viết chuẩn SEO?")
    s+=lead("Một bài chuẩn SEO trả lời đúng điều người tìm muốn biết, tốt hơn các trang đang đứng top, và được trình bày để máy đọc hiểu dễ dàng.")
    s+=p("Nhiều người hiểu chuẩn SEO là chèn đủ số lần từ khoá và đạt độ dài nhất định. Cách hiểu đó đã cũ. Google mô tả trong tài liệu "+ext(HC,"tạo nội dung hữu ích, đáng tin cậy, ưu tiên con người")+" rằng hệ thống xếp hạng ưu tiên nội dung tạo ra để giúp người đọc, thể hiện chuyên môn và kinh nghiệm thật, chứ không phải nội dung viết chủ yếu để thu hút lượt truy cập từ công cụ tìm kiếm. Từ khoá vẫn quan trọng, nhưng là điểm bắt đầu để hiểu nhu cầu, không phải mục tiêu.")
    s+=tiers([
        ("Đúng ý định tìm kiếm","Dạng bài khớp dạng trang Google đang ưu tiên: hướng dẫn, danh sách, so sánh hay trang dịch vụ"),
        ("Có thông tin mới","Số liệu, ví dụ, quy trình thực tế hoặc góc nhìn mà các trang top 10 chưa có"),
        ("Dễ đọc, dễ quét","Đoạn ngắn, heading rõ, câu trả lời thẳng ngay dưới heading, bảng và hình minh hoạ đúng chỗ"),
        ("Tối ưu kỹ thuật","Tiêu đề, mô tả, ảnh, liên kết nội bộ, dữ liệu có cấu trúc khớp nội dung hiển thị"),
    ],"Bốn tầng của một bài viết chuẩn SEO, từ nền tảng (trên) tới hoàn thiện (dưới).")
    s+=p("Tầng thứ hai là nơi phân biệt bài tốt và bài bình thường. Nếu bài mới chỉ tổng hợp lại điều mười trang khác đã nói, Google có rất ít lý do để xếp nó cao hơn. DigicomVN ghi rõ trong dàn ý điểm khác biệt của từng bài, ví dụ dữ liệu riêng của doanh nghiệp, bảng so sánh tự đo hay câu hỏi thật từ khách hàng.")
    s+=h2("quy-trinh-viet-bai","Quy trình viết bài chuẩn SEO tại DigicomVN")
    s+=lead("Sáu bước, doanh nghiệp duyệt dàn ý trước khi viết để tránh sửa đi sửa lại cả bài.")
    s+=steps([
        ("Nhận brief","Chủ đề, sản phẩm liên quan, khách hàng mục tiêu, tài liệu nội bộ và giọng văn thương hiệu."),
        ("Nghiên cứu SERP","Đọc top 10 Google, câu hỏi gợi ý, xác định dạng bài và khoảng trống thông tin."),
        ("Dàn ý để duyệt","Tiêu đề, cấu trúc heading, điểm khác biệt, nguồn tham khảo dự kiến."),
        ("Viết bài","Đoạn trả lời thẳng ở đầu mỗi mục, văn phong theo thương hiệu, minh hoạ đúng loại nội dung."),
        ("Biên tập, kiểm chứng","Đối chiếu số liệu với nguồn, kiểm tra trùng lặp, đọc lại câu chữ và chính tả."),
        ("Tối ưu và bàn giao","Tiêu đề SEO, mô tả, alt ảnh, liên kết nội bộ; giao file hoặc đăng trực tiếp lên website."),
    ])
    s+=p("Ở bước 6, tiêu đề và mô tả được viết theo hướng dẫn "+ext(TL,"liên kết tiêu đề")+" và "+ext(SN,"đoạn trích")+" của Google: mô tả đúng nội dung trang, không nhồi từ khoá. Google có thể tự viết lại tiêu đề hiển thị nếu tiêu đề không phản ánh nội dung, nên viết tiêu đề trung thực cũng là cách giữ quyền kiểm soát cách bài xuất hiện trên kết quả tìm kiếm.")
    s+=h2("loai-noi-dung","DigicomVN nhận viết những loại nội dung nào?")
    s+=lead("Mỗi loại nội dung có mục đích và cách trình bày khác nhau; viết sai loại là lỗi phổ biến nhất khiến bài không lên hạng.")
    s+=table("Các loại nội dung DigicomVN nhận viết, mục đích và cách trình bày",
        ["Loại nội dung","Mục đích","Cách trình bày chính"],[
        ["Bài blog kiến thức","Thu hút người đang tìm hiểu, xây chuyên môn cho cả chủ đề","Hướng dẫn từng bước, giải thích, so sánh, câu hỏi thường gặp"],
        ["Trang dịch vụ","Chuyển người tìm kiếm thành khách hàng","Lợi ích, quy trình, hạng mục, chi phí, câu hỏi trước khi mua"],
        ["Trang danh mục, mô tả sản phẩm","Xếp hạng từ khoá mua hàng, hỗ trợ quyết định mua","Thông số, khác biệt giữa các mẫu, hướng dẫn chọn"],
        ["Bài danh sách, so sánh","Trả lời câu hỏi chọn cái nào","Bảng so sánh theo tiêu chí rõ ràng, tiêu chí đánh giá minh bạch"],
        ["Bài PR trên báo","Xây uy tín thương hiệu ngoài website","Văn phong báo chí, đăng qua "+a("/booking-bao-pr/","booking báo PR")],
        ["Bài guest post","Tạo liên kết từ site cùng lĩnh vực","Nội dung hữu ích cho độc giả site đích, đăng qua "+a("/guest-post/","guest post")],
        ["Nội dung tiếng Anh","Phục vụ thị trường nước ngoài","Nghiên cứu từ khoá riêng, xem "+a("/dich-vu-seo-quoc-te/","SEO quốc tế")],
    ])
    s+=p("Trước khi nhận một chủ đề, DigicomVN kiểm tra xem website đã có trang nào cùng ý định tìm kiếm chưa. Nếu đã có, đề xuất sẽ là bổ sung bài cũ thay vì viết bài mới, vì hai trang cùng nhắm một nhu cầu thường kéo nhau xuống thay vì cùng lên.")
    s+=h2("ai-trong-viet-bai","DigicomVN có dùng AI để viết bài không?")
    s+=lead("Có dùng AI ở khâu hỗ trợ nghiên cứu và lập dàn ý, nhưng mọi bài đều qua biên tập viên kiểm chứng và chịu trách nhiệm trước khi giao.")
    s+=p("Google không cấm nội dung có sự hỗ trợ của AI. Trong tài liệu "+ext(GAI,"sử dụng nội dung do AI tạo")+", Google nêu rằng AI có thể hữu ích cho việc nghiên cứu và tạo cấu trúc, đồng thời cảnh báo việc dùng công cụ tạo hàng loạt trang không mang giá trị cho người dùng có thể thuộc diện lạm dụng nội dung quy mô lớn trong "+ext(SPAM,"chính sách spam")+". Ranh giới nằm ở giá trị và công sức, không nằm ở công cụ.")
    s+=compare("Nội dung sinh hàng loạt",[
        "Một khuôn mẫu, thay từ khoá cho nhiều bài",
        "Số liệu không có nguồn, đôi khi sai",
        "Không có người chịu trách nhiệm nội dung",
        "Giống các trang đang top, không thêm thông tin mới",
    ],"Nội dung DigicomVN bàn giao",[
        "Mỗi bài một ý định tìm kiếm, một góc riêng",
        "Số liệu đối chiếu với nguồn, ghi nguồn khi cần",
        "Biên tập viên đọc lại, doanh nghiệp duyệt dàn ý",
        "Có điểm khác biệt ghi rõ từ dàn ý",
    ],"Khác biệt nằm ở quy trình kiểm chứng và trách nhiệm biên tập, không phải ở việc có dùng công cụ hay không.")
    s+=p("Với lĩnh vực ảnh hưởng tới sức khoẻ, tài chính hay pháp lý, bài viết cần chuyên gia của chính doanh nghiệp duyệt nội dung chuyên môn trước khi đăng. DigicomVN chuẩn bị bản thảo và danh sách điểm cần chuyên gia xác nhận, không tự đứng tên chuyên gia thay doanh nghiệp.")
    s+=h2("gia-viet-bai-chuan-seo","Giá viết bài chuẩn SEO phụ thuộc vào đâu?")
    s+=lead("Giá tính theo từng bài hoặc theo gói, dựa vào độ khó chủ đề, độ dài cần thiết và khối lượng nghiên cứu.")
    s+=p("Trên thị trường có mức giá viết bài rất thấp tính theo số chữ. Mức giá đó thường chỉ đủ cho việc viết lại nội dung sẵn có, không đủ cho nghiên cứu SERP, kiểm chứng số liệu hay biên tập. DigicomVN báo giá sau khi nhận danh sách chủ đề, dựa trên các yếu tố: chủ đề phổ thông hay chuyên ngành sâu, độ dài cần thiết để trả lời đầy đủ (xác định từ các trang đang top, không đặt số chữ cố định), số lượng bảng, sơ đồ cần dựng, yêu cầu ngôn ngữ, và có cần đăng trực tiếp lên website hay không.")
    s+=p("Đặt theo gói hằng tháng phù hợp với doanh nghiệp cần nội dung đều đặn cho một cụm chủ đề; đặt lẻ phù hợp khi cần vài trang dịch vụ hoặc bài trụ cột. Trong cả hai cách, doanh nghiệp nhận bảng kế hoạch nội dung ghi rõ từ khoá, ý định tìm kiếm và URL đích của từng bài.")
    s+=h2("viet-bai-trong-chien-luoc-seo","Viết bài trong chiến lược SEO tổng thể")
    s+=lead("Nội dung là một mắt xích; hiệu quả cao nhất khi đi cùng nền kỹ thuật tốt và liên kết từ nguồn uy tín.")
    s+=cards([
        (a("/dich-vu-seo/","Dịch vụ SEO tổng thể"),"Lên kế hoạch cụm nội dung từ bản đồ từ khoá, kết hợp sửa kỹ thuật và đo lường."),
        (a("/dich-vu-seo-ai/","SEO AI (GEO)"),"Trình bày câu trả lời để được AI Overviews, ChatGPT, Perplexity trích dẫn."),
        (a("/mua-textlink/","Textlink")+" và "+a("/dich-vu-backlink/","backlink"),"Đưa liên kết từ website cùng lĩnh vực về bài viết quan trọng."),
    ])
    s+=p("Doanh nghiệp muốn tự viết có thể tham khảo các bài hướng dẫn trên "+a("/blog/","blog DigicomVN")+" hoặc theo dõi "+a("/khoa-hoc-seo/","khoá học SEO")+" sắp mở. Gửi danh sách chủ đề hoặc website qua "+a("/lien-he/","trang liên hệ")+", hoặc gọi hotline 0988 769 317 để nhận dàn ý mẫu cho một bài trước khi đặt.")
    return s
