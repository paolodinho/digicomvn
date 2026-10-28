from h import *
SEG="https://developers.google.com/search/docs/fundamentals/seo-starter-guide"
HSW="https://developers.google.com/search/docs/fundamentals/how-search-works"
AIF="https://developers.google.com/search/docs/appearance/ai-features"
def build():
    s=""
    s+=p("<strong>Khoá học SEO</strong> là chương trình hướng dẫn đưa website lên Google và các công cụ trả lời bằng AI, từ từ khoá, onpage, nội dung tới liên kết và đo lường. DigicomVN đang chuẩn bị khoá học SEO thực hành; lớp khai giảng khi đủ học viên, đăng ký để nhận lịch.")
    s+=summary([
        ("Trạng thái","khoá học đang được chuẩn bị, chưa khai giảng; chưa có lịch học cố định"),
        ("Đăng ký","để lại thông tin để nhận lịch khai giảng, đề cương chi tiết và học phí khi công bố"),
        ("Nội dung dự kiến","tám học phần từ nền tảng tới SEO AI, thực hành trên website thật"),
        ("Cam kết","thông tin về giảng viên, học phí, hình thức sẽ được công bố đầy đủ trước khi nhận học phí"),
    ])
    s+=h2("trang-thai-khoa-hoc","Khoá học SEO của DigicomVN đang ở giai đoạn nào?")
    s+=lead("Khoá học đang trong giai đoạn xây dựng chương trình. DigicomVN chưa nhận học phí và chỉ mở lớp khi đủ số học viên đăng ký.")
    s+=p("Trang này dành cho người muốn được thông báo sớm khi lớp đầu tiên mở. Nội dung bên dưới là lộ trình dự kiến, có thể được điều chỉnh dựa trên góp ý của người đăng ký. Học phí, giảng viên, lịch học và hình thức cấp giấy xác nhận hoàn thành chưa được chốt, vì vậy trang không đưa ra các thông tin này. Khi có thông tin chính thức, người đăng ký sẽ nhận đầy đủ trước khi quyết định tham gia.")
    s+=p("Lý do DigicomVN chọn mở lớp khi đủ người thay vì chạy lịch cố định: nhóm học viên có trình độ và mục tiêu gần nhau giúp phần thực hành sát nhu cầu hơn. Người đăng ký sẽ được hỏi thêm về website đang quản lý và mục tiêu học để xếp lớp phù hợp.")
    s+=h2("doi-tuong-phu-hop","Khoá học SEO dành cho ai?")
    s+=lead("Bốn nhóm người học được thiết kế làm trọng tâm, từ người mới bắt đầu tới người đã làm nội dung muốn hệ thống lại kiến thức.")
    s+=cards([
        ("Chủ doanh nghiệp nhỏ","Tự hiểu SEO để làm chủ website, đánh giá được đơn vị SEO thuê ngoài, không bị phụ thuộc."),
        ("Nhân viên marketing","Cần thêm kỹ năng SEO để phụ trách website công ty, phối hợp với đội nội dung và kỹ thuật."),
        ("Người viết nội dung","Muốn viết bài vừa hay vừa xếp hạng tốt, hiểu cách nghiên cứu ý định tìm kiếm."),
        ("Người mới vào nghề","Muốn có nền tảng bài bản trước khi nhận dự án SEO hoặc làm việc tại agency."),
    ],"Bốn nhóm học viên mục tiêu của khoá học dự kiến.")
    s+=h2("lo-trinh-du-kien","Lộ trình học dự kiến gồm những gì?")
    s+=lead("Tám học phần đi từ cách Google hoạt động tới SEO cho công cụ trả lời bằng AI, mỗi học phần có bài thực hành.")
    s+=steps([
        ("Google hoạt động thế nào","Thu thập dữ liệu, lập chỉ mục, xếp hạng; thiết lập Google Search Console và GA4."),
        ("Nghiên cứu từ khoá","Tìm từ khoá, đọc top 10 Google, gom nhóm theo ý định tìm kiếm, lập bản đồ từ khoá."),
        ("SEO kỹ thuật cơ bản","Cấu trúc URL, sitemap, robots.txt, tốc độ, lỗi lập chỉ mục, dữ liệu có cấu trúc."),
        ("Tối ưu onpage","Tiêu đề, mô tả, heading, ảnh, liên kết nội bộ, cấu trúc cụm chủ đề."),
        ("Viết nội dung chuẩn SEO","Lập dàn ý từ SERP, tạo thông tin mới, dùng AI hỗ trợ có kiểm chứng."),
        ("Liên kết và thương hiệu","Backlink, bài PR trên báo, guest post, social entity; nhận diện liên kết rủi ro."),
        ("SEO local và SEO AI","Google Business Profile, Google Maps, AI Overviews, ChatGPT, Perplexity."),
        ("Đo lường và lập kế hoạch","Đọc số liệu Search Console, báo cáo, lập kế hoạch SEO cho website của chính học viên."),
    ],"Lộ trình có thể điều chỉnh trước khi khai giảng.")
    s+=p("Phần thực hành được dự kiến làm trên website của chính học viên hoặc website mẫu, để kết thúc khoá học viên có trong tay bản đồ từ khoá, danh sách lỗi kỹ thuật cần sửa và kế hoạch nội dung cho vài tháng tiếp theo. Học phần 7 được đưa vào vì cách người dùng tìm kiếm đang thay đổi: Google đã có "+ext(AIF,"AI Overviews và AI Mode")+", và nhiều người hỏi ChatGPT hay Perplexity thay vì gõ từ khoá.")
    s+=h2("hinh-thuc-va-thong-tin","Hình thức học và những thông tin chưa chốt")
    s+=lead("Bảng dưới phân biệt rõ điều đã định hướng và điều còn chờ công bố, để người đăng ký không bị kỳ vọng sai.")
    s+=table("Thông tin dự kiến và trạng thái của khoá học SEO DigicomVN",
        ["Hạng mục","Định hướng hiện tại","Trạng thái"],[
        ["Hình thức học","Trực tuyến hoặc trực tiếp, tuỳ số học viên và khu vực đăng ký","Chưa chốt"],
        ["Lịch khai giảng","Mở lớp khi đủ số học viên tối thiểu","Thông báo cho người đăng ký"],
        ["Học phí","Công bố cùng đề cương chi tiết trước khi nhận đăng ký chính thức","Chưa công bố"],
        ["Giảng viên","Giới thiệu đầy đủ hồ sơ khi mở lớp","Chưa công bố"],
        ["Tài liệu","Slide, bảng mẫu bản đồ từ khoá, checklist kỹ thuật","Đang biên soạn"],
        ["Xác nhận hoàn thành","Hình thức xác nhận sẽ thông báo khi mở lớp","Chưa chốt"],
    ])
    s+=p("DigicomVN không đăng đánh giá học viên hay số người đã học, vì lớp đầu tiên chưa diễn ra. Khi khoá học đi vào hoạt động, phản hồi thật từ học viên sẽ được cập nhật trên trang này.")
    s+=h2("can-chuan-bi-gi","Cần chuẩn bị gì trước khi học SEO?")
    s+=lead("Không cần biết lập trình; cần một website để thực hành, quyền truy cập công cụ đo lường và thời gian làm bài tập đều đặn.")
    s+=p("SEO là kỹ năng học qua thực hành nhiều hơn qua nghe giảng. Người học có lợi thế lớn nếu đã có một website đang chạy, dù nhỏ, và có quyền chỉnh sửa nội dung trên đó. Nếu chưa có, có thể dựng một website thử nghiệm với "+a("/ten-mien/","tên miền")+" và "+a("/hosting/","hosting")+" chi phí thấp để tự do thử nghiệm mà không ảnh hưởng tới website của công ty.")
    s+=p("Về công cụ, Google Search Console và GA4 là đủ cho phần lớn học phần. Phần mềm trả phí chỉ cần ở học phần liên kết và phân tích đối thủ, khi đó bản miễn phí hoặc kỳ dùng thử của các hãng thường đáp ứng được mục đích học. Về thời gian, nên dành thêm vài giờ mỗi tuần ngoài giờ học để làm bài tập trên website thật, vì kết quả SEO cần thời gian để Google ghi nhận và chỉ quan sát được khi theo dõi liên tục.")
    s+=p("Với câu hỏi khoá học SEO có chứng chỉ không: giá trị của một giấy xác nhận hoàn thành phụ thuộc vào uy tín đơn vị đào tạo, còn khi tìm việc hay nhận dự án, kết quả thực tế trên một website cụ thể là bằng chứng năng lực dễ kiểm chứng hơn. Vì vậy lộ trình dự kiến ưu tiên sản phẩm đầu ra là bản kế hoạch SEO cho website thật, có thể dùng làm hồ sơ năng lực.")
    s+=h2("cach-chon-khoa-hoc-seo","Cách chọn một khoá học SEO đáng tiền")
    s+=lead("Dù học ở đâu, bốn tiêu chí dưới đây giúp phân biệt khoá học thực hành với khoá học chỉ đọc lý thuyết.")
    s+=compare("Dấu hiệu nên cân nhắc lại",[
        "Hứa hẹn lên top 1 sau vài tuần",
        "Dạy thủ thuật lách thuật toán, mua link hàng loạt",
        "Không công bố đề cương hoặc người dạy",
        "Nội dung không cập nhật AI Overviews, AI Mode",
    ],"Dấu hiệu khoá học thực chất",[
        "Đề cương chi tiết, người dạy có dự án thật",
        "Thực hành trên website thật, có bài tập nộp",
        "Bám tài liệu chính thức của Google",
        "Cập nhật thay đổi tìm kiếm bằng AI",
    ],"Bốn cặp tiêu chí so sánh khi chọn khoá học SEO.")
    s+=p("Tiêu chí bám tài liệu chính thức quan trọng hơn vẻ ngoài. Google công khai khá nhiều tài liệu nền tảng, và một khoá học tốt nên giúp học viên đọc hiểu, áp dụng các tài liệu đó thay vì thay thế chúng bằng mẹo truyền miệng.")
    s+=h2("tu-hoc-truoc-khi-khai-giang","Tự học gì trong lúc chờ khai giảng?")
    s+=lead("Hai tài liệu miễn phí của Google là điểm bắt đầu tốt nhất, sau đó là thực hành trên chính website của bạn.")
    s+=p("Hãy đọc "+ext(SEG,"hướng dẫn SEO cơ bản của Google")+" và bài "+ext(HSW,"cách Google Search hoạt động")+", rồi thiết lập Google Search Console cho website để quen với dữ liệu thật. Các bài kiến thức trên "+a("/blog/","blog DigicomVN")+" được viết để bổ trợ cho lộ trình học phía trên. Ai cần chọn công cụ thực hành có thể xem tư vấn "+a("/phan-mem-seo/","phần mềm SEO")+" chính hãng.")
    s+=p("Nếu doanh nghiệp cần kết quả trước khi đội ngũ kịp học, DigicomVN có "+a("/dich-vu-seo/","dịch vụ SEO tổng thể")+", "+a("/dich-vu-seo-local/","SEO local")+" và "+a("/dich-vu-viet-bai-chuan-seo/","viết bài chuẩn SEO")+" để triển khai song song.")
    s+=h2("dang-ky-nhan-thong-tin","Đăng ký nhận thông tin khoá học")
    s+=lead("Để lại họ tên, số điện thoại hoặc email và mục tiêu học; DigicomVN chỉ liên hệ khi có lịch khai giảng hoặc đề cương chi tiết.")
    s+=p("Gửi thông tin qua "+a("/lien-he/","trang liên hệ")+", ghi rõ mục đăng ký khoá học SEO, hoặc gọi hotline 0988 769 317. Đăng ký nhận thông tin không phát sinh chi phí và không ràng buộc tham gia; học phí chỉ được thu sau khi người học đã xem đề cương, lịch học và thông tin giảng viên chính thức.")
    return s
