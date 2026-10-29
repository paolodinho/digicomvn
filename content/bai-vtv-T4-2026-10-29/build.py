import json,re
P=lambda s:'<!-- wp:paragraph -->\n<p class="wp-block-paragraph">%s</p>\n<!-- /wp:paragraph -->\n\n'%s
H2=lambda s:'<!-- wp:heading -->\n<h2 class="wp-block-heading">%s</h2>\n<!-- /wp:heading -->\n\n'%s
H3=lambda s:'<!-- wp:heading {"level":3} -->\n<h3 class="wp-block-heading">%s</h3>\n<!-- /wp:heading -->\n\n'%s
CAP='position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0'
def table(cap,head,rows):
    th=''.join('<th>%s</th>'%h for h in head)
    tr=''.join('<tr>'+''.join('<td data-label="%s">%s</td>'%(head[i],c) for i,c in enumerate(r))+'</tr>' for r in rows)
    return '<!-- wp:html -->\n<figure class="wp-block-table dgc-data-table"><table><caption style="%s">%s</caption><thead><tr>%s</tr></thead><tbody>%s</tbody></table></figure>\n<!-- /wp:html -->\n\n'%(CAP,cap,th,tr)
def cards(items,ordered=False,num=False):
    tag='ol' if ordered else 'ul'
    out='<%s style="display:flex;flex-wrap:wrap;gap:14px;margin:20px 0;list-style:none;padding:0">'%tag
    for i,(t,d) in enumerate(items):
        n='<div aria-hidden="true" style="width:32px;height:32px;border-radius:50%%;background:#0E8C7F;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;margin-bottom:10px">%d</div>'%(i+1) if num else ''
        out+='<li style="flex:1 1 240px;background:#F1FAF8;border:1px solid rgba(14,140,127,.22);border-radius:12px;padding:16px 18px;color:#1C2035">%s<dl class="dl-card" style="margin:0"><dt style="font-weight:700;margin-bottom:4px">%s</dt><dd style="font-size:13.5px;margin:0">%s</dd></dl></li>'%(n,t,d)
    return '<!-- wp:html -->\n'+out+'</%s>\n<!-- /wp:html -->\n\n'%tag
def img(f,alt,cap): return '<!--IMG:%s|%s|%s-->\n\n'%(f,alt,cap)
A=lambda u,t:'<a href="%s">%s</a>'%(u,t)
h='<!-- wp:heading {"level":1} -->\n<h1 class="wp-block-heading">Bảng Giá Quảng Cáo Truyền Hình VTV 2026 Theo Khung Giờ Và Thời Lượng</h1>\n<!-- /wp:heading -->\n\n'
h+=P('Giá quảng cáo truyền hình VTV năm 2026 dao động từ khoảng 14,4 triệu đồng cho một spot 15 giây buổi sáng đến hơn 152 triệu đồng cho một spot 30 giây trước gameshow giờ vàng, tính cho một lần phát. Khoảng cách gần mười lần đó đến từ ba yếu tố: kênh, khung giờ và thời lượng spot. Bài này đặt toàn bộ mức giá đang niêm yết lên một bảng sắp theo giờ trong ngày, rồi chỉ cách đọc bảng, cách cộng ra ngân sách cho một đợt phát sóng và các bước cần làm trước khi mẫu quảng cáo được lên sóng.')
h+='<!-- wp:group {"className":"summary"} -->\n<div class="wp-block-group summary"><div class="wp-block-group__inner-container is-layout-flow wp-block-group-is-layout-flow">\n<ul class="wp-block-list">'
h+='<li><strong>Khung sáng rẻ nhất</strong>: VTV1 6h00-7h00 có giá 16,44 triệu đồng cho TVC 30 giây; VTV3 Cà phê Sáng 24,02 triệu đồng.</li>'
h+='<li><strong>Giờ vàng đắt nhất</strong>: VTV1 khoảng 19h55 trước Thời sự là 126,06 triệu đồng; trước gameshow giờ vàng trên VTV3 là 152,76 triệu đồng cho 30 giây.</li>'
h+='<li><strong>Spot 15 giây</strong> trong bảng có giá bằng 60% spot 30 giây cùng vị trí, không phải 50%.</li>'
h+='<li><strong>Giá tham khảo, chưa gồm VAT</strong>, cập nhật ngày 29/10/2026; đơn giá chốt theo thông báo giá mới nhất của đài tại thời điểm ký.</li>'
h+='</ul>\n</div></div>\n<!-- /wp:group -->\n\n'
h+=P('Toàn bộ các mức giá dưới đây là giá '+A('/booking-truyen-hinh/','booking quảng cáo truyền hình VTV')+' DigicomVN đang niêm yết công khai, không phải ảnh chụp biểu giá cũ. Nếu bạn cần hiểu trước quảng cáo truyền hình gồm những hình thức nào và luật quy định ra sao, bài '+A('/quang-cao-truyen-hinh/','quảng cáo truyền hình: hình thức và quy định 2026')+' đã phân tích riêng phần đó.')

h+=H2('Bảng giá quảng cáo VTV 2026 theo khung giờ')
h+=P('Bảng dưới sắp các vị trí phát theo thứ tự thời gian trong ngày, từ sáng sớm đến giờ vàng buổi tối. Mỗi dòng là giá cho một lần phát, cột 15 giây để trống ở những vị trí hiện chỉ nhận spot 30 giây.')
rows=[["VTV1","6h00-7h00","Khung sáng","-","16.440.000"],
["VTV1","Khoảng 6h20","Sau bản tin Chào buổi sáng","28.829.000","48.048.000"],
["VTV3","6h30-7h15","Chương trình Cà phê Sáng","14.414.000","24.024.000"],
["VTV3","Ban ngày","Khung ban ngày","-","32.760.000"],
["VTV1","Khoảng 19h55","Trước bản tin Thời sự 20h","75.636.000","126.060.000"],
["VTV1","20h, thứ 2 đến thứ 6","Phim truyện Việt Nam","-","98.280.000"],
["VTV3","Giờ vàng buổi tối","Ai là triệu phú, ngoài chương trình","-","98.280.000"],
["VTV3","Giờ vàng buổi tối","Ai là triệu phú, trong chương trình","-","109.200.000"],
["VTV3","Giờ vàng buổi tối","Trước gameshow","-","152.760.000"]]
h+=table('Bảng giá quảng cáo TVC trên VTV1 và VTV3 năm 2026 theo khung giờ, đơn vị đồng một lần phát',["Kênh","Khung giờ","Vị trí phát","TVC 15 giây (đồng)","TVC 30 giây (đồng)"],rows)
h+=P('Giá trong bảng là giá tham khảo cho một lần phát, chưa gồm VAT, cập nhật ngày 29/10/2026. Giá chưa gồm chi phí sản xuất mẫu quảng cáo. Với chương trình đặc biệt như sự kiện thể thao lớn hay chương trình dịp Tết, đài ban hành đơn giá riêng nên cần báo giá theo từng đợt.')
h+=P('Hai dòng của VTV1 buổi sáng cho thấy vì sao không nên chỉ nhìn tên khung giờ. Cùng nằm trong khoảng 6h đến 7h, nhưng vị trí ngay sau bản tin Chào buổi sáng có giá 48,05 triệu đồng, gần gấp ba khung sáng chung 16,44 triệu đồng. Vị trí càng sát chương trình nhiều người xem, giá càng cao, dù chỉ cách nhau vài phút.')

h+=H2('Giá chênh nhau thế nào giữa các khung giờ?')
h+=img('ig-bang-gia-quang-cao-vtv-khung-gio.webp','Biểu đồ bảng giá quảng cáo VTV 2026 theo khung giờ cho TVC 30 giây','Giá một lần phát TVC 30 giây theo khung giờ, bảng giá booking truyền hình DigicomVN cập nhật 29/10/2026')
h+=P('Có thể chia bảng giá VTV thành ba tầng. Tầng thấp là khung sáng sớm và ban ngày, từ 16 đến 33 triệu đồng cho 30 giây. Đây là tầng hợp với ngân sách vừa phải hoặc chiến dịch cần phát nhiều lần để tạo tần suất.')
h+=P('Tầng giữa là các vị trí bám vào bản tin buổi sáng, khoảng 48 triệu đồng. Tầng cao là giờ vàng buổi tối, từ khoảng 98 triệu đồng trở lên: phim truyện 20h, gameshow và vị trí trước bản tin Thời sự 20h. Khung tối đắt vì đây là thời điểm có nhiều người xem truyền hình nhất trong ngày, một spot chạm tới nhiều người trong cùng một lần phát.')
h+=P('Một lưu ý pháp lý liên quan trực tiếp đến vị trí phát: Luật Quảng cáo không cho phép quảng cáo trong chương trình thời sự. Vì vậy vị trí "trước Thời sự 20h" là khối quảng cáo phát ngay trước bản tin, không chen vào giữa bản tin.')

h+=H2('Giá theo thời lượng: chọn spot 15 giây hay 30 giây?')
h+=P('Trong bảng giá hiện có, spot 15 giây luôn bằng 60% giá spot 30 giây cùng vị trí. Nói cách khác, cắt đôi thời lượng chỉ tiết kiệm 40% chi phí mỗi lần phát. Ba cặp giá cùng vị trí cho thấy tỷ lệ này lặp lại đều:')
h+=cards([("VTV1 khoảng 19h55","30 giây: 126.060.000 đồng. 15 giây: 75.636.000 đồng."),
("VTV1 sau Chào buổi sáng","30 giây: 48.048.000 đồng. 15 giây: 28.829.000 đồng."),
("VTV3 Cà phê Sáng","30 giây: 24.024.000 đồng. 15 giây: 14.414.000 đồng.")])
h+=P('Spot 30 giây đủ để kể một câu chuyện ngắn và giới thiệu sản phẩm mới. Spot 15 giây hợp với thương hiệu đã có nhận diện, cần nhắc lại thông điệp hoặc một chương trình khuyến mãi. Cách nhiều doanh nghiệp dùng là phát bản 30 giây trong tuần đầu ra mắt, sau đó chuyển sang bản 15 giây cắt từ chính bản gốc để tăng tần suất với cùng ngân sách.')
h+=P('Nếu chỉ có một bản quảng cáo, hãy quyết định thời lượng trước khi quay. Cắt một TVC 30 giây xuống 15 giây sau khi đã dựng xong thường làm mất mạch kể, nhiều khi phải dựng lại. Phần chi phí sản xuất và cấu trúc một TVC được phân tích trong bài '+A('/quang-cao-tvc-la-gi/','TVC là gì và quy trình sản xuất')+'.')

h+=H2('Giá phóng sự và chuyên mục doanh nghiệp trên VTV')
h+=P('Không phải doanh nghiệp nào cũng cần một spot TVC. Với dự án, sự kiện hay câu chuyện thương hiệu có hình ảnh thật để quay, hình thức phóng sự trong bản tin hoặc chuyên mục doanh nghiệp cho thời lượng dài hơn, từ 30 đến 120 giây, với mức giá tham khảo sau:')
h+=cards([("VTV1: bản tin, chuyên mục Doanh nghiệp và Thương hiệu","Phóng sự hoặc bản tin 30-120 giây: 48.000.000 đồng."),
("VTV3: bản tin, chuyên mục doanh nghiệp","Phóng sự hoặc bản tin 30-120 giây: 36.000.000 đồng.")])
h+=P('So với một spot 30 giây giờ vàng, phóng sự có giá thấp hơn nhiều và cho nhiều thời gian hơn để giải thích sản phẩm. Đổi lại, phóng sự phát trong khung chuyên mục, số người xem ít hơn giờ vàng, và nội dung phải có dấu hiệu nhận biết là quảng cáo theo quy định, không được trình bày như tin thời sự.')

h+=H2('Ví dụ tính chi phí một đợt quảng cáo VTV')
h+=P('Ngân sách phát sóng bằng đơn giá một lần phát nhân số lần phát mỗi tuần, nhân số tuần chạy, rồi cộng các vị trí với nhau. Dưới đây là một kế hoạch ví dụ cho bốn tuần, kết hợp khung sáng để tạo tần suất và giờ vàng để tạo độ phủ. Đây là ví dụ minh hoạ cách tính theo bảng giá hiện có, không phải đề xuất cho một ngành cụ thể.')
h+=cards([("Khung sáng tạo tần suất","VTV3 Cà phê Sáng, spot 15 giây, 5 lần mỗi tuần trong 4 tuần: 14.414.000 x 20 = 288.280.000 đồng."),
("Giờ vàng tạo độ phủ","VTV1 khoảng 19h55, spot 15 giây, 2 lần mỗi tuần trong 4 tuần: 75.636.000 x 8 = 605.088.000 đồng."),
("Cộng ngân sách phát sóng","288.280.000 + 605.088.000 = 893.368.000 đồng cho 28 lần phát, chưa gồm VAT và chi phí sản xuất."),
("Phương án ngân sách nhỏ","Chỉ dùng VTV1 khung 6h00-7h00, spot 30 giây, 3 lần mỗi tuần trong 4 tuần: 16.440.000 x 12 = 197.280.000 đồng.")],ordered=True,num=True)
h+=P('Hai phương án chênh nhau hơn bốn lần nhưng phục vụ hai mục tiêu khác nhau. Phương án đầu hợp với ra mắt sản phẩm đại chúng cần nhiều người biết đến trong thời gian ngắn. Phương án sau hợp với thương hiệu muốn hiện diện đều đặn trên sóng quốc gia với ngân sách giới hạn, chấp nhận tệp khán giả hẹp hơn.')
h+=P('Một spot phát đơn lẻ hiếm khi đủ để người xem nhớ thương hiệu. Khi lập kế hoạch, hãy tính theo đợt và giữ một phần ngân sách cho sản xuất mẫu, vì đài chỉ nhận file đạt chuẩn kỹ thuật.')

h+=H2('Vì sao giá có thể thay đổi giữa lúc báo giá và lúc phát?')
h+=P('Biểu giá quảng cáo của VTV không cố định cả năm. Đơn vị khai thác quảng cáo của Đài Truyền hình Việt Nam (TVAd) quản lý giá theo từng mã giờ, và thường xuyên ra thông báo giá mới cho từng chương trình. Chỉ riêng tháng 9/2026, trang thông báo giá của TVAd có ít nhất mười thông báo, gồm đơn giá cho các chương trình thể thao châu lục, chương trình mới lên sóng và thông báo huỷ hoặc bổ sung mã giờ.')
h+=cards([("Mã giờ thay đổi","Đài có thể bổ sung, huỷ hoặc đổi thời gian phát của một mã giờ khi lịch chương trình thay đổi."),
("Chương trình đặc biệt","Sự kiện thể thao, gameshow mùa mới, chương trình dịp Tết có đơn giá riêng, thường cao hơn khung thường."),
("Thời điểm đặt","Khung giờ đông khách có thể hết chỗ, nên đặt sớm giúp giữ được vị trí mong muốn.")])
h+=P('Vì vậy, khi nhận báo giá, hãy kiểm tra ba điểm: báo giá có ghi rõ kênh, mã giờ hoặc vị trí phát, thời lượng spot hay không; báo giá còn hiệu lực đến ngày nào; và hợp đồng có điều khoản phát bù nếu spot bị dời hoặc không phát được hay không.')

h+=H2('Quy trình booking và duyệt kịch bản quảng cáo VTV')
h+=img('ig-bang-gia-quang-cao-vtv-quy-trinh.webp','Quy trình 5 bước booking và duyệt mẫu quảng cáo truyền hình VTV','Năm bước từ chọn khung giờ đến phát sóng và đối soát')
h+=P('Mẫu quảng cáo chỉ được phát khi đã qua bước duyệt của đài. TVAd công bố phiếu đề nghị duyệt chương trình, mẫu quảng cáo cùng các yêu cầu kỹ thuật như nhận file theo chuẩn HD và khuôn hình 16:9. Mẫu không đạt kỹ thuật hoặc nội dung chưa phù hợp sẽ bị yêu cầu sửa, nên nên nộp sớm để còn thời gian chỉnh trước ngày phát.')
h+=P('Hồ sơ tối thiểu gồm giấy đăng ký kinh doanh và file mẫu đúng chuẩn. Sản phẩm, dịch vụ đặc biệt như thuốc, mỹ phẩm, thực phẩm bảo vệ sức khoẻ, thiết bị và dịch vụ y tế cần thêm giấy tờ chứng minh đủ điều kiện quảng cáo theo pháp luật chuyên ngành. Lời khuyến cáo, cảnh báo trong spot phải được đọc rõ, không đọc nhanh hơn phần còn lại.')
h+=P('Ở bước kịch bản, nên rà ba điểm trước khi quay: thông điệp có tuyên bố nào không chứng minh được không, có dùng từ "nhất", "số một" khi không có tài liệu hợp pháp chứng minh không, và thời lượng lời thoại có vừa đúng 15 hoặc 30 giây không. Sửa kịch bản trên giấy rẻ hơn rất nhiều so với quay lại.')
h+=P('Sau khi phát, đối soát số lần phát thực tế với lịch đã ký theo từng vị trí. Đây là căn cứ để yêu cầu phát bù nếu có spot bị lỡ.')

h+=H2('Nên chọn VTV, đài địa phương hay phát thanh?')
h+=P('VTV phù hợp khi sản phẩm bán trên toàn quốc và cần độ tin cậy của đài quốc gia. Doanh nghiệp bán theo vùng thường tiết kiệm hơn với đài địa phương, nơi có các mục tự giới thiệu 60 đến 90 giây giá dễ tiếp cận. Còn khi ngân sách không đủ cho truyền hình, phát thanh là lựa chọn rẻ hơn để duy trì tần suất.')
h+=cards([("VTV","Phủ toàn quốc, đơn giá cao, hợp ra mắt sản phẩm đại chúng và thương hiệu quốc gia."),
("Đài địa phương","Phủ trong tỉnh, thành phố; hợp chuỗi cửa hàng, dự án, doanh nghiệp bán theo vùng."),
("Phát thanh","Chi phí thấp hơn, hợp nhắc lại thông điệp với người nghe khi lái xe, làm việc. Xem "+A('/quang-cao-phat-thanh/','bảng giá quảng cáo phát thanh')+".")])

h+=H2('Câu hỏi thường gặp')
faq=[("Giá quảng cáo khung giờ vàng trên VTV là bao nhiêu?","Theo bảng giá tham khảo cập nhật 29/10/2026, một spot 30 giây giờ vàng trên VTV có giá từ khoảng 98,28 triệu đồng (phim truyện 20h VTV1) đến 152,76 triệu đồng (trước gameshow trên VTV3). Vị trí khoảng 19h55 trước Thời sự 20h là 126,06 triệu đồng. Giá chưa gồm VAT và chi phí sản xuất."),
("Giá quảng cáo trên VTV3 là bao nhiêu?","Trên VTV3, spot 30 giây có giá từ 24,02 triệu đồng ở chương trình Cà phê Sáng, 32,76 triệu đồng khung ban ngày, đến 98,28-109,2 triệu đồng ở Ai là triệu phú và 152,76 triệu đồng trước gameshow giờ vàng. Spot 15 giây Cà phê Sáng là 14,41 triệu đồng."),
("Quảng cáo trên VTV1 giá bao nhiêu?","VTV1 có giá từ 16,44 triệu đồng cho spot 30 giây khung 6h00-7h00, 48,05 triệu đồng sau bản tin Chào buổi sáng, 98,28 triệu đồng phim truyện 20h và 126,06 triệu đồng khoảng 19h55. Phóng sự trong chuyên mục doanh nghiệp 30-120 giây là 48 triệu đồng."),
("Chi phí quảng cáo trên truyền hình gồm những khoản nào?","Chi phí gồm hai phần: tiền phát sóng tính theo số lần phát nhân đơn giá từng vị trí, và tiền sản xuất mẫu quảng cáo đạt chuẩn kỹ thuật của đài. Giá phát sóng trong bảng chưa gồm VAT và chưa gồm sản xuất, vì vậy nên xin báo giá hai phần cùng lúc."),
("Bảng giá quảng cáo VTV có thay đổi trong năm không?","Có. Đài quản lý giá theo mã giờ và ra thông báo giá riêng cho chương trình mới, sự kiện thể thao, dịp Tết. Đơn giá áp dụng là đơn giá tại thời điểm ký hợp đồng, nên cần kiểm tra hiệu lực của báo giá trước khi chốt lịch phát.")]
for q,a in faq: h+=H3(q)+P(a)
h+='<!-- wp:html -->\n<div style="background:#F1FAF8;border:1px solid rgba(14,140,127,.22);border-radius:12px;padding:18px 20px;margin:20px 0;color:#1C2035"><p style="margin:0 0 8px;font-weight:700">Cần lịch phát và báo giá theo ngân sách của bạn?</p><p style="margin:0">Gửi kênh, khung giờ, thời lượng và số tuần dự kiến qua '+A('/dat-bai/','trang nhận báo giá')+'. DigicomVN gửi lại lịch phát theo vị trí, đơn giá đang áp dụng và tổng chi phí trước VAT.</p></div>\n<!-- /wp:html -->\n\n'
h+=H2('Tài liệu tham khảo')
refs=[("Bảng giá quảng cáo, Trung tâm Quảng cáo và Khai thác Bản quyền Đài Truyền hình Việt Nam (TVAd)","https://www.tvad.com.vn/bang-gia"),
("Thông báo giá quảng cáo trên VTV, TVAd","https://www.tvad.com.vn/thong-bao-gia"),
("Quy trình duyệt mẫu quảng cáo, TVAd","https://tvad.com.vn/quy-trinh-duyet-mau"),
("Luật số 75/2025/QH15 sửa đổi, bổ sung Luật Quảng cáo (Thư viện Pháp luật)","https://thuvienphapluat.vn/van-ban/Thuong-mai/Luat-Quang-cao-sua-doi-2025-so-75-2025-QH15-555035.aspx")]
h+='<!-- wp:list -->\n<ul class="wp-block-list">'+''.join('<li><a href="%s" target="_blank" rel="noopener">%s</a></li>'%(u,t) for t,u in refs)+'</ul>\n<!-- /wp:list -->\n'
open('bang-gia-quang-cao-vtv.html','w').write(h)
j={"title":"Bảng Giá Quảng Cáo Truyền Hình VTV 2026 Theo Khung Giờ","slug":"bang-gia-quang-cao-vtv",
"meta_desc":"Bảng giá quảng cáo truyền hình VTV 2026 theo khung giờ: VTV1, VTV3 từ 14,4 đến 152,8 triệu đồng/lần phát, giá spot 15 và 30 giây, ví dụ tính ngân sách.",
"excerpt":"Bảng giá quảng cáo VTV1, VTV3 năm 2026 sắp theo khung giờ từ sáng đến giờ vàng, giá spot 15 và 30 giây, giá phóng sự doanh nghiệp, ví dụ tính chi phí một đợt phát sóng và quy trình duyệt mẫu."}
json.dump(j,open('bang-gia-quang-cao-vtv.json','w'),ensure_ascii=False,indent=1)
t=re.sub(r'<!--.*?-->','',h,flags=re.S);t=re.sub('<[^>]+>',' ',t)
print('words',len(t.split()),'meta',len(j['meta_desc']),'title',len(j['title']))
print('dash', any(c in h for c in '—–'))
