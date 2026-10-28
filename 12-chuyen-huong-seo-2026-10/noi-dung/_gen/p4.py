from h import *
MR="https://developers.google.com/search/docs/specialty/international/managing-multi-regional-sites"
HL="https://developers.google.com/search/docs/specialty/international/localized-versions"
GAI="https://developers.google.com/search/docs/fundamentals/using-gen-ai-content"
def build():
    s=""
    s+=p("<strong>Dịch vụ SEO quốc tế</strong> là tối ưu website để xếp hạng trên Google ở thị trường nước ngoài, bằng ngôn ngữ của người mua tại đó. DigicomVN tư vấn cấu trúc URL đa ngôn ngữ, triển khai hreflang, nghiên cứu từ khoá từng thị trường, bản địa hoá nội dung và xây liên kết quốc tế.")
    s+=summary([
        ("Phù hợp với","doanh nghiệp xuất khẩu, logistics, du lịch, phần mềm, giáo dục muốn có khách hàng nước ngoài từ Google"),
        ("Phạm vi","cấu trúc URL, hreflang, từ khoá theo thị trường, nội dung bản địa hoá, off-page quốc tế, đo lường theo quốc gia"),
        ("Nguyên tắc","nghiên cứu lại từ khoá cho mỗi thị trường, không dịch máy rồi đăng nguyên văn"),
        ("Chi phí","báo giá sau audit miễn phí, theo số ngôn ngữ, số thị trường và khối lượng nội dung"),
    ])
    s+=h2("seo-quoc-te-la-gi","SEO quốc tế khác SEO trong nước ở điểm nào?")
    s+=lead("Cùng nguyên tắc nền, nhưng mỗi thị trường là một cuộc cạnh tranh riêng với đối thủ, từ khoá và thói quen tìm kiếm riêng.")
    s+=p("Một doanh nghiệp đứng top ở Việt Nam không tự động có thứ hạng ở Mỹ, Nhật hay Úc. Người mua ở mỗi nơi dùng từ khác nhau cho cùng một sản phẩm, so sánh với nhà cung cấp khác nhau và tin vào nguồn khác nhau. SEO quốc tế vì vậy có ba phần việc mà SEO trong nước không cần: chọn cấu trúc website cho nhiều phiên bản, báo cho Google biết phiên bản nào dành cho ai, và xây độ tin cậy tại thị trường mới.")
    s+=h2("chon-cau-truc-url","Chọn cấu trúc URL cho website đa ngôn ngữ")
    s+=lead("Google mô tả bốn cách tổ chức; ba cách dùng được, cách dùng tham số URL không được khuyến nghị.")
    s+=p("Theo tài liệu "+ext(MR,"quản lý website đa vùng và đa ngôn ngữ")+" của Google, mỗi cách tổ chức URL có ưu nhược điểm riêng. Quyết định này khó thay đổi về sau, nên DigicomVN chốt cùng doanh nghiệp ngay từ đầu dựa trên số thị trường, ngân sách hạ tầng và đội ngũ vận hành.")
    s+=table("So sánh bốn cách tổ chức URL cho website nhiều quốc gia theo tài liệu Google",
        ["Cách tổ chức","Ví dụ","Ưu điểm","Hạn chế"],[
        ["Tên miền quốc gia","example.de","Nhắm thị trường rõ ràng nhất, tách biệt dễ","Chi phí cao, mỗi tên miền chỉ nhắm một quốc gia, quy định đăng ký riêng"],
        ["Thư mục con","example.com/de/","Dễ triển khai, chung một hạ tầng, dễ duy trì","Người dùng khó đoán thị trường chỉ từ URL"],
        ["Tên miền phụ","de.example.com","Dễ triển khai, có thể đặt máy chủ khác nhau","Khó phân biệt de là ngôn ngữ hay quốc gia"],
        ["Tham số URL","site.com?loc=de","Không có ưu điểm đáng kể","Google không khuyến nghị"],
    ])
    s+=p("Với phần lớn doanh nghiệp Việt Nam mở rộng ra một vài thị trường, thư mục con trên một "+a("/ten-mien/","tên miền")+" quốc tế là lựa chọn cân bằng nhất: chi phí thấp, uy tín tên miền được chia sẻ cho mọi phiên bản. Tên miền quốc gia phù hợp khi một thị trường đủ lớn để có đội ngũ và ngân sách riêng. "+a("/hosting/","Hosting")+" và CDN cũng cần đủ nhanh cho người dùng ở xa máy chủ.")
    s+=h2("hreflang","Hreflang: báo cho Google phiên bản nào dành cho ai")
    s+=lead("Hreflang giúp Google hiển thị đúng phiên bản ngôn ngữ cho đúng người, và phải được khai báo hai chiều.")
    s+=p("Theo "+ext(HL,"hướng dẫn phiên bản bản địa hoá của Google")+", hreflang có thể khai báo trong thẻ HTML, trong HTTP header hoặc trong sitemap. Mỗi phiên bản phải liệt kê chính nó và tất cả phiên bản còn lại; nếu trang A trỏ sang B mà B không trỏ lại A, khai báo có thể bị bỏ qua. Giá trị x-default dùng cho trang mặc định khi không có phiên bản khớp ngôn ngữ của người dùng.")
    s+=tiers([
        ("x-default","Trang mặc định, ví dụ trang chọn ngôn ngữ hoặc bản tiếng Anh chung"),
        ("vi  ⇄  en  ⇄  ja","Mỗi phiên bản khai báo chính nó và mọi phiên bản còn lại, theo cả hai chiều"),
        ("en-US  ⇄  en-AU  ⇄  en-GB","Cùng ngôn ngữ, khác quốc gia: dùng mã ngôn ngữ kèm mã vùng khi nội dung thật sự khác nhau (giá, đơn vị, vận chuyển)"),
    ],"Mô hình khai báo hreflang ba tầng: mặc định, theo ngôn ngữ, theo ngôn ngữ và quốc gia.")
    s+=p("Hai điểm thường bị hiểu sai. Thứ nhất, Google xác định ngôn ngữ trang dựa vào nội dung hiển thị, không dựa vào thuộc tính lang trong mã nguồn hay vào URL. Thứ hai, Google khuyên tránh tự động chuyển hướng người dùng sang phiên bản ngôn ngữ theo địa chỉ IP, vì cách đó có thể khiến cả người dùng lẫn công cụ tìm kiếm không thấy được mọi phiên bản; nên đặt liên kết chuyển ngôn ngữ rõ ràng thay vào đó.")
    s+=h2("ban-dia-hoa-noi-dung","Dịch nội dung và bản địa hoá nội dung khác nhau thế nào?")
    s+=lead("Dịch giữ nguyên câu chữ; bản địa hoá viết lại cho người mua ở thị trường đích, bắt đầu từ việc nghiên cứu lại từ khoá.")
    s+=compare("Chỉ dịch từ bản tiếng Việt",[
        "Dùng lại từ khoá đã dịch, có thể không ai tìm",
        "Ví dụ, đơn vị đo, tiền tệ theo kiểu Việt Nam",
        "Thiếu chứng nhận, tiêu chuẩn mà người mua nước ngoài kiểm tra",
        "Dễ thành nội dung trùng lặp, giá trị thấp nếu dịch máy hàng loạt",
    ],"Bản địa hoá theo thị trường",[
        "Nghiên cứu từ khoá mới bằng ngôn ngữ và công cụ của thị trường đó",
        "Đơn vị, tiền tệ, điều khoản giao hàng, múi giờ hỗ trợ đúng địa phương",
        "Nêu chứng nhận, tiêu chuẩn, phương thức thanh toán người mua quen dùng",
        "Có người đọc bản xứ hoặc thông thạo biên tập trước khi đăng",
    ],"Nội dung bản địa hoá tốn công hơn, nhưng là điều kiện để cạnh tranh với doanh nghiệp bản xứ.")
    s+=p("Công cụ dịch và AI hỗ trợ tốt ở khâu bản nháp. Google cho phép dùng AI tạo nội dung, nhưng "+ext(GAI,"lưu ý")+" rằng dùng công cụ tự động để tạo hàng loạt trang không mang giá trị cho người dùng có thể vi phạm chính sách spam. Vì vậy mọi bản dịch trong dự án SEO quốc tế của DigicomVN đều qua bước biên tập, kiểm tra thuật ngữ ngành và số liệu trước khi đăng.")
    s+=h2("quy-trinh-seo-quoc-te","Quy trình triển khai SEO quốc tế")
    s+=lead("Sáu bước, mỗi thị trường được xử lý như một dự án con có từ khoá và đối thủ riêng.")
    s+=steps([
        ("Chọn thị trường","Đánh giá nhu cầu tìm kiếm, đối thủ và khả năng phục vụ của doanh nghiệp ở từng quốc gia."),
        ("Chốt cấu trúc","Chọn tên miền quốc gia, thư mục con hoặc tên miền phụ; lên sơ đồ URL cho từng ngôn ngữ."),
        ("Nghiên cứu từ khoá","Đo top 10 Google tại thị trường đích, xác định dạng trang người mua ở đó đang thấy."),
        ("Kỹ thuật đa ngôn ngữ","Triển khai hreflang, sitemap, canonical, bộ chuyển ngôn ngữ, tốc độ cho người dùng ở xa."),
        ("Nội dung bản địa hoá","Viết và biên tập trang đích, trang sản phẩm, bài kiến thức theo từ khoá từng thị trường."),
        ("Liên kết, đo lường","Xây liên kết từ site quốc tế cùng ngành, báo cáo theo quốc gia trong Search Console."),
    ])
    s+=p("Khâu liên kết thường là rào cản lớn nhất, vì website Việt Nam ít được nhắc trên trang nước ngoài. DigicomVN có sẵn dịch vụ "+a("/backlink-quoc-te/","backlink quốc tế")+" gồm guest post trên site nước ngoài theo nhóm Domain Rating và phân phối thông cáo báo chí quốc tế, nên phần off-page được lên kế hoạch cùng lúc với nội dung thay vì làm sau.")
    s+=h2("do-luong-theo-quoc-gia","Đo lường SEO quốc tế theo từng quốc gia")
    s+=lead("Search Console cho phép lọc lượt hiển thị và lượt nhấp theo quốc gia, đây là thước đo chính.")
    s+=p("Báo cáo hằng tháng tách riêng từng thị trường: lượt hiển thị, lượt nhấp, vị trí trung bình của nhóm từ khoá mục tiêu, cùng lỗi hreflang nếu có. Thứ hạng ở thị trường mới thường cần thời gian dài hơn thị trường quen thuộc, nên giai đoạn đầu nên theo dõi xu hướng lượt hiển thị trước khi đánh giá thứ hạng từng từ. DigicomVN không cam kết thứ hạng cố định ở thị trường nước ngoài.")
    s+=h2("chi-phi-seo-quoc-te","Chi phí dịch vụ SEO quốc tế phụ thuộc vào đâu?")
    s+=lead("Số ngôn ngữ, số thị trường, khối lượng nội dung cần bản địa hoá và nhu cầu liên kết quốc tế.")
    s+=p("Một website thêm bản tiếng Anh cho một thị trường có khối lượng công việc khác hẳn website cần năm ngôn ngữ cho mười quốc gia. Báo giá được lập sau khi audit hiện trạng: website đã có phiên bản ngôn ngữ nào, hreflang đã đúng chưa, nội dung nào dùng lại được, đối thủ ở thị trường đích mạnh tới đâu. Chi phí liên kết quốc tế có bảng giá riêng và được liệt kê từng dòng.")
    s+=p("Nền tảng cho SEO quốc tế vẫn là một website khoẻ về kỹ thuật, xem "+a("/dich-vu-seo/","dịch vụ SEO tổng thể")+". Doanh nghiệp muốn thương hiệu được AI nhắc tới khi người nước ngoài hỏi về nhà cung cấp Việt Nam có thể kết hợp "+a("/dich-vu-seo-ai/","SEO AI")+"; nội dung tiếng nước ngoài có thể đặt qua "+a("/dich-vu-viet-bai-chuan-seo/","dịch vụ viết bài chuẩn SEO")+". Đội nội bộ tự nghiên cứu từ khoá quốc tế có thể tham khảo "+a("/phan-mem-seo/","phần mềm SEO")+" chính hãng. Gửi website và thị trường mục tiêu qua "+a("/lien-he/","trang liên hệ")+" hoặc gọi 0988 769 317.")
    return s
