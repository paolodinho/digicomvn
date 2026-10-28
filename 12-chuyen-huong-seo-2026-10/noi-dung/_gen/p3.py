from h import *
RANK="https://support.google.com/business/answer/7091?hl=vi"
GUIDE="https://support.google.com/business/answer/3038177?hl=vi"
LB="https://developers.google.com/search/docs/appearance/structured-data/local-business"
AIF="https://developers.google.com/search/docs/appearance/ai-features"
def build():
    s=""
    s+=p("<strong>Dịch vụ SEO local</strong> là tối ưu để doanh nghiệp có địa điểm thật xuất hiện cao hơn khi khách tìm dịch vụ gần họ trên Google Maps. DigicomVN xử lý Google Business Profile, trang chi nhánh trên website, dữ liệu NAP nhất quán và quy trình xin đánh giá từ khách thật.")
    s+=summary([
        ("Phù hợp với","cửa hàng, phòng khám, nhà hàng, showroom, văn phòng dịch vụ, doanh nghiệp nhiều chi nhánh"),
        ("Kênh chính","Google Business Profile, Google Maps, khối bản đồ trong kết quả tìm kiếm và trang địa phương trên website"),
        ("Nguyên tắc","chỉ dùng thông tin thật: tên đúng biển hiệu, địa chỉ thật, đánh giá từ khách thật"),
        ("Chi phí","báo giá sau audit miễn phí, theo số địa điểm và mức cạnh tranh khu vực"),
    ])
    s+=h2("google-xep-hang-dia-phuong","Google xếp hạng kết quả địa phương dựa trên gì?")
    s+=lead("Ba yếu tố: mức liên quan, khoảng cách và mức độ nổi bật. Không có cách trả tiền để xếp hạng địa phương cao hơn.")
    s+=p("Theo trang hỗ trợ "+ext(RANK,"Cách cải thiện thứ hạng địa phương trên Google")+", kết quả địa phương được quyết định chủ yếu bởi ba yếu tố. Google cũng nói rõ không có cách nào yêu cầu hay trả tiền để có thứ hạng địa phương tốt hơn, nên mọi gói dịch vụ hứa hẹn kiểu đó đều cần được kiểm tra kỹ.")
    s+=cards([
        ("Mức liên quan","Hồ sơ doanh nghiệp khớp với điều người dùng tìm tới đâu: danh mục, dịch vụ, mô tả, nội dung website."),
        ("Khoảng cách","Doanh nghiệp cách người tìm bao xa. Yếu tố này không tối ưu được, nhưng có thể chọn đúng khu vực phục vụ."),
        ("Mức độ nổi bật","Doanh nghiệp được biết đến tới đâu, dựa một phần vào liên kết, đánh giá và mức hiện diện trên web."),
    ],"Ba yếu tố xếp hạng địa phương theo tài liệu hỗ trợ Google Business Profile.")
    s+=p("Trong ba yếu tố, khoảng cách nằm ngoài tầm kiểm soát. Vì vậy dịch vụ SEO local tập trung vào hai yếu tố còn lại: làm cho hồ sơ và website liên quan chặt chẽ hơn với từ khoá khách hay tìm, và tăng mức độ nổi bật bằng đánh giá thật, liên kết từ báo địa phương, hồ sơ trên các danh bạ uy tín. Google cũng ghi nhận rằng có nhiều đánh giá và điểm đánh giá tốt hơn có thể giúp thứ hạng địa phương.")
    s+=h2("hang-muc-seo-local","Dịch vụ SEO local gồm những hạng mục nào?")
    s+=lead("Công việc chia đều giữa hồ sơ Google Business Profile và website, vì hai nơi này hỗ trợ lẫn nhau.")
    s+=table("Hạng mục công việc trong dịch vụ SEO local và đầu ra bàn giao",
        ["Hạng mục","Công việc","Đầu ra"],[
        ["Hồ sơ Google Business Profile","Xác minh, chọn danh mục chính và phụ, giờ mở cửa, dịch vụ, sản phẩm, ảnh thật, mô tả","Hồ sơ đầy đủ trường thông tin, ảnh chụp trước và sau"],
        ["Trang địa phương trên website","Mỗi chi nhánh một trang riêng: địa chỉ, bản đồ, giờ làm việc, dịch vụ, hướng dẫn đường đi","Trang đã đăng, có dữ liệu có cấu trúc LocalBusiness"],
        ["Dữ liệu NAP","Thống nhất tên, địa chỉ, số điện thoại trên website, hồ sơ mạng xã hội, danh bạ","Bảng đối chiếu NAP và danh sách chỗ đã sửa"],
        ["Đánh giá khách hàng","Quy trình xin đánh giá sau giao dịch, mẫu phản hồi đánh giá tích cực và tiêu cực","Tài liệu quy trình cho nhân viên, mẫu phản hồi"],
        ["Liên kết địa phương","Bài trên "+a("/booking-bao-tinh/","báo tỉnh")+", hồ sơ "+a("/backlink-social-entity/","social entity")+" chuẩn NAP","Danh sách link kèm trạng thái index"],
        ["Theo dõi","Lượt xem hồ sơ, cuộc gọi, yêu cầu chỉ đường, lượt nhấp từ Google Maps","Báo cáo tháng từ Google Business Profile và Search Console"],
    ])
    s+=p("Dữ liệu có cấu trúc cho doanh nghiệp địa phương được triển khai theo "+ext(LB,"hướng dẫn LocalBusiness của Google")+", với thông tin khớp đúng nội dung hiển thị trên trang. DigicomVN không thêm đánh giá hay điểm số vào schema khi chưa có đánh giá thật.")
    s+=h2("quy-trinh-seo-local","Quy trình triển khai SEO local")
    s+=lead("Năm bước, ưu tiên sửa những lỗi khiến hồ sơ bị tạm ngưng hoặc không hiển thị trước khi tối ưu sâu.")
    s+=steps([
        ("Audit hiện trạng","Kiểm tra hồ sơ, vị trí trên bản đồ theo từ khoá, đối thủ quanh khu vực, NAP trên web."),
        ("Sửa hồ sơ","Đưa tên, địa chỉ, danh mục về đúng nguyên tắc; bổ sung đủ trường, ảnh thật, dịch vụ."),
        ("Trang địa phương","Viết trang riêng cho từng chi nhánh với nội dung thật, không nhân bản đổi tên quận."),
        ("Độ nổi bật","Quy trình xin đánh giá thật, liên kết từ báo và danh bạ địa phương, hồ sơ chuẩn NAP."),
        ("Đo và duy trì","Theo dõi cuộc gọi, chỉ đường, lượt nhấp; cập nhật bài đăng, ảnh, giờ nghỉ lễ."),
    ])
    s+=p("Bước 2 thường mang lại thay đổi nhanh nhất. Nhiều hồ sơ đặt tên kèm từ khoá dịch vụ, số điện thoại hoặc khẩu hiệu. Theo "+ext(GUIDE,"nguyên tắc đại diện doanh nghiệp trên Google")+", tên hồ sơ phải khớp tên thật trên biển hiệu và giấy tờ; thêm thông tin không cần thiết vào tên không được phép và có thể khiến hồ sơ bị tạm ngưng. Văn phòng ảo cũng không đủ điều kiện có hồ sơ. Sửa đúng nguyên tắc trước giúp tránh rủi ro mất hồ sơ đúng lúc đang có thứ hạng.")
    s+=h2("ho-so-va-website","Hồ sơ Google Business và website: nên đầu tư bên nào?")
    s+=lead("Cả hai. Hồ sơ giúp xuất hiện trên bản đồ, website cung cấp mức liên quan và thông tin chi tiết mà hồ sơ không chứa hết.")
    s+=compare("Google Business Profile",[
        "Xuất hiện trong Google Maps và khối bản đồ",
        "Khách gọi điện, chỉ đường, xem giờ mở cửa ngay trên Google",
        "Đánh giá và ảnh của khách hàng hiển thị công khai",
        "Giới hạn về lượng nội dung mô tả dịch vụ",
    ],"Trang địa phương trên website",[
        "Mô tả đầy đủ dịch vụ, bảng giá, đội ngũ tại từng chi nhánh",
        "Xếp hạng trong kết quả tự nhiên cho từ khoá kèm địa danh",
        "Liên kết từ hồ sơ về website tăng mức liên quan",
        "Nguồn để AI và công cụ tìm kiếm đối chiếu thông tin",
    ],"Hai kênh bổ trợ cho nhau; hồ sơ thiếu website thường khó cạnh tranh ở từ khoá nhiều đối thủ.")
    s+=p("Với doanh nghiệp nhiều chi nhánh, mỗi địa điểm cần một hồ sơ và một trang riêng. Lỗi phổ biến là tạo hàng loạt trang chỉ khác tên quận nhưng nội dung giống hệt; Google coi đây là trang mỏng. Mỗi trang chi nhánh nên có thông tin riêng: địa chỉ, cách đi, nhân sự, dịch vụ thực tế có tại điểm đó.")
    s+=h2("danh-gia-khach-hang","Đánh giá khách hàng: làm thế nào cho đúng?")
    s+=lead("Chỉ xin đánh giá từ khách đã dùng dịch vụ; không mua, không tạo đánh giá ảo.")
    s+=p("Đánh giá là một phần của mức độ nổi bật, nhưng cũng là chỗ dễ vi phạm nhất. Đánh giá giả, đánh giá được trả tiền hay đánh giá đổi lấy quà đều vi phạm "+ext("https://support.google.com/contributionpolicy/answer/7400114?hl=vi","chính sách nội dung bị cấm của Google")+" (mục tương tác giả mạo) và có thể khiến đánh giá bị xoá hàng loạt hoặc hồ sơ bị hạn chế. DigicomVN không cung cấp đánh giá ảo dưới bất kỳ hình thức nào.")
    s+=p("Thay vào đó, chúng tôi xây quy trình để nhân viên chủ động xin đánh giá đúng thời điểm: ngay sau khi khách hài lòng với dịch vụ, kèm đường link ngắn hoặc mã QR dẫn thẳng tới ô viết đánh giá. Đi kèm là bộ mẫu phản hồi, vì cách doanh nghiệp trả lời một đánh giá tiêu cực được khách hàng mới đọc kỹ không kém chính đánh giá đó.")
    s+=h2("seo-local-va-ai","SEO local trong thời kỳ tìm kiếm bằng AI")
    s+=lead("Câu hỏi tìm địa điểm trên AI Mode và AI Overviews dựa nhiều vào thông tin hồ sơ doanh nghiệp đã được cập nhật.")
    s+=p("Trong "+ext(AIF,"hướng dẫn về tính năng AI trên Google Search")+", Google khuyến nghị giữ thông tin Business Profile luôn cập nhật. Với câu hỏi kiểu tìm phòng khám gần đây hay quán mở cửa tối nay, thông tin giờ mở cửa, dịch vụ, ảnh và đánh giá trên hồ sơ là dữ liệu đầu vào. Doanh nghiệp muốn đầu tư sâu hơn vào kênh này có thể xem "+a("/dich-vu-seo-ai/","dịch vụ SEO AI")+".")
    s+=h2("chi-phi-seo-local","Chi phí dịch vụ SEO local phụ thuộc vào đâu?")
    s+=lead("Chủ yếu vào số địa điểm, mức cạnh tranh của khu vực và tình trạng hiện tại của hồ sơ.")
    s+=p("Một phòng khám ở thị trấn nhỏ và một chuỗi cửa hàng tại trung tâm Hà Nội hay TP.HCM có khối lượng công việc rất khác nhau. Các yếu tố chính gồm: số chi nhánh cần quản lý, số danh mục dịch vụ, mức cạnh tranh trên bản đồ tại khu vực, hồ sơ đã xác minh hay chưa, có bị tạm ngưng trước đó không, và nhu cầu liên kết từ báo địa phương. DigicomVN audit miễn phí rồi mới gửi báo giá, không cam kết vị trí cố định trong khối bản đồ vì khoảng cách tới người tìm thay đổi theo từng lượt tìm.")
    s+=p("SEO local cho hiệu quả cao nhất khi website nền đã khoẻ; xem thêm "+a("/dich-vu-seo/","dịch vụ SEO tổng thể")+". Nội dung trang chi nhánh có thể đặt qua "+a("/dich-vu-viet-bai-chuan-seo/","dịch vụ viết bài chuẩn SEO")+", và các bài hướng dẫn tự tối ưu hồ sơ được cập nhật trên "+a("/blog/","blog DigicomVN")+". Gửi tên hồ sơ và website qua "+a("/lien-he/","trang liên hệ")+" hoặc gọi 0988 769 317 để nhận bản audit hồ sơ miễn phí.")
    return s
