from h import *
SP="sponsored noopener"
TERMS="https://ahrefs.com/legal/terms"
def build():
    s=""
    s+=p("<strong>Phần mềm SEO</strong> là công cụ giúp nghiên cứu từ khoá, phân tích đối thủ, kiểm tra backlink, audit kỹ thuật và theo dõi thứ hạng website, tiêu biểu như Ahrefs, Semrush, SE Ranking, Moz, Screaming Frog, Surfer. DigicomVN tư vấn chọn công cụ theo nhu cầu và hỗ trợ đặt mua gói chính hãng đứng tên doanh nghiệp.")
    s+=summary([
        ("DigicomVN làm gì","tư vấn chọn công cụ, hỗ trợ đặt mua gói chính hãng đứng tên khách hàng, hoặc giới thiệu qua liên kết chính hãng"),
        ("Không làm","không bán, không chia sẻ tài khoản mua chung hay group buy"),
        ("Giá","theo giá niêm yết của hãng; bảng dưới ghi giá công bố tại thời điểm 10/2026, có thể thay đổi"),
        ("Phù hợp với","đội SEO nội bộ, agency, freelancer, chủ website tự làm SEO"),
    ])
    s+=h2("cac-phan-mem-seo-pho-bien","Các phần mềm SEO phổ biến và giá niêm yết")
    s+=lead("Mỗi công cụ mạnh ở một nhóm việc; bảng dưới tổng hợp giá theo tháng công bố trên trang chính hãng, tháng 10/2026.")
    s+=p("Giá trong bảng là giá niêm yết của hãng tại thời điểm 10/2026, tính theo tháng khi thanh toán hằng tháng, bằng đô la Mỹ hoặc bảng Anh, chưa gồm thuế. Các hãng thường giảm giá khi trả theo năm và thay đổi gói định kỳ, vì vậy hãy kiểm tra lại trang giá chính hãng trước khi quyết định. Công cụ nào DigicomVN chưa đối chiếu được giá trực tiếp, bảng ghi "+'"xem trang hãng"'+" thay vì đưa số không chắc chắn.")
    s+=table("Phần mềm SEO phổ biến, thế mạnh và giá niêm yết của hãng tháng 10/2026",
        ["Phần mềm","Thế mạnh chính","Giá niêm yết (10/2026)","Bản miễn phí"],[
        [ext("https://ahrefs.com/pricing","Ahrefs",SP),"Backlink, nghiên cứu từ khoá, phân tích đối thủ","Starter 29 USD; Lite 129 USD; Standard 249 USD; Advanced 449 USD; Enterprise 1.499 USD (cam kết năm)","Có bản Ahrefs Free, giới hạn"],
        [ext("https://www.semrush.com/prices/","Semrush",SP),"Từ khoá, quảng cáo, theo dõi hiện diện trên AI Search","SEO 139 USD; Starter 199 USD; Pro+ 299 USD; Advanced theo báo giá","Có bản Free, giới hạn"],
        [ext("https://seranking.com/subscription.html","SE Ranking",SP),"Theo dõi thứ hạng, audit, báo cáo cho agency","Core 129 USD; Growth 279 USD; Enterprise theo báo giá","Có dùng thử"],
        [ext("https://moz.com/products/pro/pricing","Moz Pro",SP),"Chỉ số Domain Authority, nghiên cứu từ khoá","Xem trang hãng","Có công cụ miễn phí giới hạn"],
        [ext("https://www.screamingfrog.co.uk/seo-spider/pricing/","Screaming Frog SEO Spider",SP),"Crawl và audit kỹ thuật website","199 GBP mỗi năm cho một giấy phép","Có, giới hạn 500 URL mỗi lần crawl"],
        [ext("https://surfer.ai/pricing","Surfer",SP),"Tối ưu nội dung theo trang đang top","Xem trang hãng","Xem trang hãng"],
    ])
    s+=p("Tên gói và mức giá được lấy trực tiếp từ trang giá của từng hãng khi biên soạn trang này. Liên kết trong bảng dẫn thẳng tới trang chính hãng; khi DigicomVN tham gia chương trình đối tác của hãng, liên kết có thể được thay bằng liên kết giới thiệu chính thức, giá khách trả vẫn là giá hãng công bố.")
    s+=h2("chon-phan-mem-theo-nhu-cau","Chọn phần mềm SEO theo nhu cầu")
    s+=lead("Không cần mua công cụ đắt nhất; chọn theo việc đội ngũ làm hằng ngày và quy mô số website quản lý.")
    s+=tiers([
        ("Chủ website tự làm SEO","Google Search Console, GA4 và bản miễn phí của Ahrefs hoặc Semrush, cộng Screaming Frog bản miễn phí"),
        ("Đội SEO nội bộ 1 đến 3 người","Một bộ công cụ chính (Ahrefs hoặc Semrush hoặc SE Ranking) cộng Screaming Frog có giấy phép"),
        ("Agency, nhiều website","Gói có nhiều người dùng và dự án, công cụ báo cáo cho khách, thêm công cụ tối ưu nội dung khi cần"),
    ],"Ba mức nhu cầu và bộ công cụ tương ứng.")
    s+=p("Câu hỏi nên trả lời trước khi mua: đội ngũ cần dữ liệu backlink sâu hay chủ yếu theo dõi thứ hạng? Có cần nhiều người cùng đăng nhập không? Thị trường mục tiêu là Việt Nam hay nước ngoài? Cơ sở dữ liệu từ khoá tiếng Việt của các công cụ khác nhau đáng kể, nên DigicomVN khuyên dùng thử bản miễn phí hoặc kỳ dùng thử với chính từ khoá của doanh nghiệp trước khi trả tiền cho gói năm.")
    s+=h2("vi-sao-khong-ban-tai-khoan-mua-chung","Vì sao DigicomVN không bán tài khoản mua chung, group buy?")
    s+=lead("Vì mô hình chia sẻ một tài khoản cho nhiều người mua trái điều khoản của nhà cung cấp, và người mua là bên chịu rủi ro mất quyền truy cập.")
    s+=p("Khi tìm mua tài khoản Ahrefs, nhiều kết quả chào bán tài khoản dùng chung với giá vài chục tới vài trăm nghìn đồng mỗi tháng. Mức giá đó chỉ có được khi một tài khoản trả tiền được chia cho nhiều người không quen biết. Điều khoản dịch vụ của "+ext(TERMS,"Ahrefs")+" có các quy định trực tiếp liên quan:")
    s+=ul([
        "Mục 12.4: giấy phép sử dụng là không độc quyền, không được chuyển nhượng, không được cấp phép lại, và chỉ dùng cho hoạt động kinh doanh nội bộ của bên mua.",
        "Mục 12.7(a): cấm bán, trao đổi, chuyển giao hoặc khai thác thương mại việc sử dụng, truy cập dịch vụ khi chưa có đồng ý bằng văn bản của Ahrefs.",
        "Mục 8.4(i): Ahrefs có quyền chấm dứt khi có việc sử dụng dịch vụ trái phép.",
        "Mục 4.2: chủ tài khoản chịu trách nhiệm về mọi hoạt động diễn ra trong tài khoản.",
    ])
    s+=p("Hệ quả thực tế: tài khoản dùng chung có thể bị khoá giữa kỳ mà người mua không có quan hệ hợp đồng nào với hãng để khiếu nại; dữ liệu dự án, danh sách từ khoá theo dõi nằm trong tài khoản không thuộc về mình; và người khác dùng chung có thể xem được website, đối thủ mà doanh nghiệp đang phân tích. Với doanh nghiệp làm SEO nghiêm túc, rủi ro này lớn hơn khoản tiết kiệm.")
    s+=compare("Tài khoản mua chung, group buy",[
        "Nhiều người không quen biết dùng một đăng nhập",
        "Trái điều khoản nhà cung cấp, có thể bị khoá bất cứ lúc nào",
        "Không có hoá đơn hay hợp đồng với hãng",
        "Thường bị giới hạn tính năng, lịch sử dự án không riêng tư",
    ],"Gói chính hãng đứng tên doanh nghiệp",[
        "Tài khoản đăng ký bằng email của doanh nghiệp",
        "Đúng điều khoản, được hãng hỗ trợ trực tiếp",
        "Hoá đơn do hãng phát hành cho người đăng ký",
        "Dữ liệu dự án thuộc về doanh nghiệp, thêm người dùng theo gói",
    ],"So sánh hai cách sở hữu tài khoản phần mềm SEO.")
    s+=h2("quy-trinh-dat-mua","Quy trình đặt mua phần mềm SEO chính hãng qua DigicomVN")
    s+=lead("Năm bước, tài khoản luôn đứng tên doanh nghiệp ngay từ đầu.")
    s+=steps([
        ("Tư vấn nhu cầu","Trao đổi việc đội ngũ làm hằng ngày, số website, ngân sách; đề xuất công cụ và gói."),
        ("Dùng thử","Hướng dẫn kiểm tra bản miễn phí hoặc kỳ dùng thử với từ khoá và website thật của doanh nghiệp."),
        ("Đăng ký chính hãng","Tạo tài khoản bằng email doanh nghiệp trên trang của hãng; doanh nghiệp giữ toàn quyền đăng nhập."),
        ("Thanh toán","Doanh nghiệp thanh toán trực tiếp cho hãng, hoặc DigicomVN hỗ trợ thanh toán theo thoả thuận riêng."),
        ("Hướng dẫn sử dụng","Thiết lập dự án đầu tiên, theo dõi từ khoá, báo cáo; nhắc lịch gia hạn trước kỳ thanh toán."),
    ])
    s+=p("Ở bước thanh toán, nhiều doanh nghiệp gặp khó khi cần thẻ quốc tế hoặc chứng từ thanh toán ra nước ngoài. Phương án hỗ trợ cụ thể (thanh toán hộ, chứng từ đi kèm) được thống nhất theo từng trường hợp trước khi đăng ký, để doanh nghiệp biết rõ mình nhận được hoá đơn và chứng từ gì.")
    s+=h2("cong-cu-mien-phi-cua-google","Công cụ miễn phí của Google: nền tảng trước khi mua phần mềm")
    s+=lead("Google Search Console là nguồn dữ liệu chính xác nhất về cách Google nhìn website; phần mềm trả phí bổ sung chứ không thay thế.")
    s+=p("Các phần mềm SEO bên thứ ba ước tính lưu lượng và thứ hạng bằng dữ liệu riêng, nên con số thường lệch so với thực tế của website. Google Search Console cho biết chính xác truy vấn nào đưa người dùng tới, trang nào được lập chỉ mục, lỗi nào Google gặp khi thu thập dữ liệu. GA4 cho biết người dùng làm gì sau khi vào trang. Hai công cụ này miễn phí và nên được thiết lập trước khi chi tiền cho phần mềm khác.")
    s+=p("Phần mềm trả phí phát huy giá trị ở những việc Google không cung cấp: xem backlink và từ khoá của đối thủ, nghiên cứu thị trường khi website chưa có dữ liệu, theo dõi thứ hạng hằng ngày cho nhiều từ khoá, crawl toàn bộ website để tìm lỗi kỹ thuật. Hiểu rõ ranh giới này giúp chọn đúng gói và không trả tiền cho tính năng trùng với công cụ miễn phí.")
    s+=h2("khong-can-mua-cong-cu","Khi nào không cần tự mua công cụ?")
    s+=lead("Nếu doanh nghiệp chỉ cần kết quả SEO, không cần đội ngũ thao tác công cụ hằng ngày, thuê dịch vụ thường hợp lý hơn.")
    s+=p("Một gói phần mềm SEO đầy đủ có chi phí hằng năm đáng kể, và chỉ hiệu quả khi có người biết dùng. Doanh nghiệp chưa có nhân sự SEO có thể thuê "+a("/dich-vu-seo/","dịch vụ SEO tổng thể")+", trong đó DigicomVN dùng công cụ của mình để nghiên cứu và báo cáo. Nếu chỉ cần nội dung, xem "+a("/dich-vu-viet-bai-chuan-seo/","dịch vụ viết bài chuẩn SEO")+"; nếu cần liên kết, xem "+a("/dich-vu-backlink/","dịch vụ backlink")+" và "+a("/guest-post/","guest post")+".")
    s+=p("Người mới muốn học cách dùng công cụ một cách bài bản có thể đăng ký nhận thông tin "+a("/khoa-hoc-seo/","khoá học SEO")+" sắp mở, hoặc đọc hướng dẫn trên "+a("/blog/","blog DigicomVN")+". Để được tư vấn chọn gói phù hợp, gửi nhu cầu qua "+a("/lien-he/","trang liên hệ")+" hoặc gọi hotline 0988 769 317.")
    return s
