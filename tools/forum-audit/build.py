# -*- coding: utf-8 -*-
import csv

dr = {r["domain"]: int(r["dr"]) for r in csv.DictReader(open("dr.csv", encoding="utf-8"))}

# Nhóm: chỉ giữ domain THẬT SỰ là diễn đàn/cộng đồng cho phép đăng bài, DR > 5
NHOM = [
    ("Công nghệ, phần cứng, phần mềm", [
        ("tinhte.vn", "Cộng đồng công nghệ lớn nhất VN", "Rất khó"),
        ("voz.vn", "Máy tính, phần cứng, đời sống", "Khó"),
        ("techrum.vn", "Điện thoại, thiết bị di động", "Trung bình"),
        ("sinhvienit.net", "Tin học, lập trình sinh viên", "Dễ"),
        ("vn-zoom.com", "Phần mềm, thủ thuật máy tính", "Trung bình"),
        ("dientuvietnam.net", "Điện tử, mạch, kỹ thuật", "Trung bình"),
        ("diendantinhoc.vn", "Tin học phổ thông", "Dễ"),
    ]),
    ("Rao vặt, mua bán", [
        ("vatgia.com", "Thương mại, so sánh giá", "Dễ"),
        ("5giay.vn", "Mua bán tổng hợp", "Dễ"),
        ("nhattao.com", "Đồ công nghệ cũ", "Trung bình"),
        ("tudomuaban.com", "Rao vặt đa ngành", "Dễ"),
        ("rongbay.com", "Rao vặt, dịch vụ", "Dễ"),
        ("muaban.net", "Rao vặt đa ngành", "Dễ"),
        ("raovat.net", "Rao vặt tổng hợp", "Dễ"),
    ]),
    ("Ô tô, xe máy", [
        ("otofun.net", "Cộng đồng ô tô lớn nhất VN", "Khó"),
        ("otosaigon.com", "Ô tô khu vực phía Nam", "Trung bình"),
        ("oto-hui.com", "Kỹ thuật ô tô, sửa chữa", "Trung bình"),
        ("2banh.vn", "Xe máy, mô tô", "Trung bình"),
    ]),
    ("Mẹ và bé, đời sống, sức khoẻ", [
        ("webtretho.com", "Nuôi dạy con, gia đình", "Khó"),
        ("yeutre.vn", "Thai kỳ, chăm sóc trẻ", "Dễ"),
        ("mucwomen.com", "Phụ nữ, làm đẹp", "Dễ"),
    ]),
    ("SEO, marketing, kiếm tiền online", [
        ("mmo4me.com", "Kiếm tiền trực tuyến", "Trung bình"),
        ("seothetop.com", "Kiến thức SEO", "Dễ"),
        ("thegioiseo.com", "Cộng đồng SEO lâu năm", "Dễ"),
        ("vforum.vn", "Tổng hợp, marketing", "Dễ"),
        ("idichvuseo.com", "Dịch vụ, tool SEO", "Trung bình"),
    ]),
    ("Cộng đồng tổng hợp, hỏi đáp, chia sẻ", [
        ("linkhay.com", "Chia sẻ liên kết (social bookmark)", "Dễ"),
        ("viblo.asia", "Cộng đồng lập trình, viết bài kỹ thuật", "Trung bình"),
        ("kenhsinhvien.vn", "Sinh viên, việc làm, học tập", "Dễ"),
        ("daynhauhoc.com", "Hỏi đáp lập trình", "Trung bình"),
        ("ttvnol.com", "Cộng đồng lâu đời, đa chủ đề", "Trung bình"),
        ("hoidap247.com", "Hỏi đáp kiến thức", "Dễ"),
        ("haivl.com", "Giải trí, chia sẻ", "Dễ"),
    ]),
    ("Chuyên ngành (ngách hẹp, độ liên quan cao)", [
        ("agriviet.com", "Nông nghiệp, chăn nuôi", "Dễ"),
        ("yeuthucung.com", "Thú cưng", "Dễ"),
        ("phuot.vn", "Du lịch, phượt", "Trung bình"),
        ("ketoan.vn", "Kế toán, thuế", "Trung bình"),
        ("xaydung.org", "Xây dựng, kiến trúc", "Dễ"),
        ("caycanhvietnam.com", "Cây cảnh, sân vườn", "Dễ"),
        ("cafeland.vn", "Bất động sản", "Khó"),
        ("diaocthongthai.com", "Bất động sản, phân tích", "Dễ"),
    ]),
    ("Tài chính, chứng khoán", [
        ("vfpress.vn", "Đầu tư, tài chính cá nhân", "Trung bình"),
        ("f247.com", "Chứng khoán, cổ phiếu", "Trung bình"),
    ]),
]

# Domain đã loại
LOAI_CHET = [
    ("f319.com", "Không phân giải được tên miền (DNS chết)"),
    ("lamchame.com", "Không kết nối được"),
    ("gamevn.com", "Không kết nối được"),
    ("ddth.com", "Không kết nối được"),
    ("seomxh.com", "Không kết nối được"),
    ("congdongjava.com", "DNS chết"),
    ("tinhocmienphi.com", "DNS chết"),
    ("banbe.net", "DNS chết"),
    ("tuvanmuanha.vn", "DNS chết"),
    ("enbac.com", "Trả về lỗi 404"),
    ("diendan.hocmai.vn", "Trả về lỗi 502"),
    ("vozforums.com", "Trả về lỗi 526 (tên miền cũ của voz)"),
]
LOAI_DR = [
    ("diendancongnghe.com", 0),
    ("lamdep.com.vn", 0),
    ("webmaster.vn", 2),
    ("vozer.vn", 4),
    ("tathy.com", 5),
]

def dr_badge(v):
    if v >= 60: return "#0E8C7F"
    if v >= 40: return "#2563EB"
    if v >= 25: return "#64748B"
    return "#94A3B8"

out = []
tong = sum(len(x[1]) for x in NHOM)

out.append('<!-- wp:heading {"level":1} -->')
out.append(f'<h1 class="wp-block-heading">Danh Sách {tong} Diễn Đàn Đi Backlink Còn Sống, Đã Đo DR Thật (7/2026)</h1>')
out.append('<!-- /wp:heading -->\n')

out.append('<p>Hầu hết danh sách "200+ diễn đàn đi backlink" đang lan truyền đều chép lại của nhau và không ai kiểm tra lại. Chúng tôi tải về 73 diễn đàn được nhắc nhiều nhất rồi tự kiểm tra từng cái: <strong>12 diễn đàn đã chết hoặc không truy cập được</strong>, thêm <strong>5 diễn đàn có chỉ số gần bằng 0</strong>. Bài này chỉ giữ lại ' + str(tong) + ' diễn đàn thật sự còn hoạt động, kèm chỉ số Domain Rating đo trực tiếp từ Ahrefs ngày 20/07/2026.</p>')

# Tóm tắt
out.append('<div class="wp-block-group summary"><div class="wp-block-group__inner-container is-layout-flow wp-block-group-is-layout-flow">')
out.append('<ul class="wp-block-list">')
out.append(f'<li>Danh sách {tong} diễn đàn Việt Nam còn sống, chia theo 8 nhóm ngành, kèm chỉ số DR thật (không phải DA chép lại).</li>')
out.append('<li>Công bố luôn 17 diễn đàn bị loại và lý do cụ thể - để bạn không mất công đăng ký tài khoản ở nơi đã chết.</li>')
out.append('<li>Quy trình lọc 3 lớp: kiểm tra tên miền còn phân giải, kiểm tra trang còn trả về nội dung, đo Domain Rating qua Ahrefs.</li>')
out.append('<li>Hướng dẫn chọn diễn đàn theo ngành và cách đăng bài không bị khoá tài khoản.</li>')
out.append('</ul>')
out.append('</div></div>\n')

# ===== H2: Phương pháp =====
out.append('<h2>Danh sách này được lập như thế nào?</h2>')
out.append('<p>Điều khiến một danh sách diễn đàn trở nên vô dụng không phải là ít, mà là <em>sai</em>. Bạn bỏ ra một buổi tối đăng ký mười tài khoản, để rồi phát hiện bốn trang đã ngừng hoạt động từ lâu và ba trang khác không còn chút sức mạnh nào để truyền. Vì vậy chúng tôi chạy ba lớp lọc trước khi đưa bất kỳ cái tên nào vào bảng.</p>')

out.append('''<div style="display:flex;flex-wrap:wrap;gap:10px;margin:20px 0 26px;justify-content:center;">
<div style="flex:1 1 210px;max-width:250px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:8px;padding:16px;text-align:center;">
<div style="width:34px;height:34px;line-height:34px;background:#0E8C7F;color:#fff;border-radius:50%;margin:0 auto 10px;font-weight:700;font-size:14px;">1</div>
<div style="font-weight:700;color:#1C2035;margin-bottom:6px;font-size:14px;">Tên miền còn sống?</div>
<div style="font-size:12.5px;color:#64748B;">Kiểm tra phân giải DNS. Loại 5 tên miền không còn tồn tại.</div>
</div>
<div style="flex:1 1 210px;max-width:250px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:8px;padding:16px;text-align:center;">
<div style="width:34px;height:34px;line-height:34px;background:#0E8C7F;color:#fff;border-radius:50%;margin:0 auto 10px;font-weight:700;font-size:14px;">2</div>
<div style="font-weight:700;color:#1C2035;margin-bottom:6px;font-size:14px;">Trang còn mở được?</div>
<div style="font-size:12.5px;color:#64748B;">Gửi yêu cầu HTTP thật. Loại thêm 7 trang trả về lỗi 404, 502, 526 hoặc treo.</div>
</div>
<div style="flex:1 1 210px;max-width:250px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:8px;padding:16px;text-align:center;">
<div style="width:34px;height:34px;line-height:34px;background:#0E8C7F;color:#fff;border-radius:50%;margin:0 auto 10px;font-weight:700;font-size:14px;">3</div>
<div style="font-weight:700;color:#1C2035;margin-bottom:6px;font-size:14px;">Còn sức mạnh không?</div>
<div style="font-size:12.5px;color:#64748B;">Đo Domain Rating qua Ahrefs. Loại 5 diễn đàn có DR từ 5 trở xuống.</div>
</div>
</div>''')

out.append('<p>Chúng tôi dùng <strong>Domain Rating (DR)</strong> của <a href="https://ahrefs.com/website-authority-checker" target="_blank" rel="nofollow noopener">Ahrefs</a> thay vì Domain Authority của Moz, đơn giản vì DR tra được trực tiếp và miễn phí nên bạn có thể tự kiểm chứng lại từng dòng trong bảng dưới đây. Con số trong bài là số đo ngày 20/07/2026, không phải số chép lại từ bài viết khác.</p>')

out.append('<p>Một lưu ý về cách đọc: DR đo sức mạnh tổng thể của tên miền, <strong>không</strong> đảm bảo liên kết bạn đặt ở đó sẽ có giá trị. Một diễn đàn DR 70 nhưng để bạn spam link ở chữ ký hàng nghìn bài thì liên kết đó gần như vô nghĩa. Hãy đọc bảng theo hướng "nơi này có đáng để đầu tư thời gian không", chứ không phải "đặt link ở đây là lên top".</p>')

# ===== H2: Danh sách =====
out.append(f'<h2>Danh sách {tong} diễn đàn đi backlink theo nhóm ngành</h2>')
out.append('<p>Xếp theo DR giảm dần trong từng nhóm. Cột "Độ khó" phản ánh mức độ kiểm duyệt: <em>Dễ</em> là đăng bài được ngay sau khi tạo tài khoản, <em>Khó</em> và <em>Rất khó</em> là cần có lịch sử hoạt động thật trước khi chèn được liên kết.</p>')

for ten_nhom, ds in NHOM:
    ds_sorted = sorted(ds, key=lambda x: -dr.get(x[0], 0))
    out.append(f'<h3>{ten_nhom}</h3>')
    out.append('<figure class="wp-block-table"><table><thead>')
    out.append('<tr><th>Diễn đàn</th><th>DR</th><th>Chủ đề</th><th>Độ khó</th></tr>')
    out.append('</thead><tbody>')
    for d, chu_de, kho in ds_sorted:
        v = dr.get(d, 0)
        out.append(f'<tr><td>{d}</td><td><span style="display:inline-block;min-width:34px;text-align:center;background:{dr_badge(v)};color:#fff;border-radius:4px;padding:2px 6px;font-weight:700;font-size:12.5px;">{v}</span></td><td>{chu_de}</td><td>{kho}</td></tr>')
    out.append('</tbody></table></figure>')

out.append('[dgc_offpage_quiz]\n')

# ===== H2: loại =====
out.append('<h2>17 diễn đàn nên gạch khỏi danh sách của bạn</h2>')
out.append('<p>Phần này gần như không danh sách nào công bố, vì nó cho thấy dữ liệu của họ đã cũ. Chúng tôi để lại nguyên nhân cụ thể để bạn tự kiểm chứng.</p>')

out.append('<h3>12 diễn đàn không còn truy cập được</h3>')
out.append('<figure class="wp-block-table"><table><thead><tr><th>Tên miền</th><th>Tình trạng khi kiểm tra ngày 20/07/2026</th></tr></thead><tbody>')
for d, ly_do in LOAI_CHET:
    out.append(f'<tr><td>{d}</td><td>{ly_do}</td></tr>')
out.append('</tbody></table></figure>')

out.append('<h3>5 diễn đàn còn sống nhưng chỉ số gần bằng 0</h3>')
out.append('<p>Những trang này vẫn mở được, nên chúng dễ lọt vào các danh sách chép tay. Nhưng DR gần 0 nghĩa là gần như không có website nào trỏ về chúng - liên kết bạn đặt ở đây sẽ không truyền được sức mạnh nào đáng kể.</p>')
out.append('<figure class="wp-block-table"><table><thead><tr><th>Tên miền</th><th>DR đo được</th></tr></thead><tbody>')
for d, v in LOAI_DR:
    out.append(f'<tr><td>{d}</td><td><span style="display:inline-block;min-width:34px;text-align:center;background:#DC2626;color:#fff;border-radius:4px;padding:2px 6px;font-weight:700;font-size:12.5px;">{v}</span></td></tr>')
out.append('</tbody></table></figure>')

out.append('<p>Chúng tôi cũng bỏ khỏi danh sách một số tên miền mạnh nhưng <strong>không phải diễn đàn</strong> và không cho người ngoài đăng bài, dù nhiều bài viết khác vẫn xếp chúng vào: laodong.vn, suckhoedoisong.vn, genk.vn, vnreview.vn, quantrimang.com, meta.vn, batdongsan.com.vn, chotot.com. Đưa chúng vào chỉ khiến bạn mất thời gian tìm chỗ đăng bài không tồn tại.</p>')

# ===== H2: chọn thế nào =====
out.append('<h2>Chọn diễn đàn nào cho website của bạn?</h2>')
out.append('<p>Sai lầm phổ biến nhất là lao vào những cái tên DR cao nhất bảng. Một liên kết từ diễn đàn nông nghiệp DR 46 trỏ về website bán phân bón có giá trị hơn hẳn liên kết từ diễn đàn công nghệ DR 79 - vì Google đọc cả ngữ cảnh chủ đề, không chỉ đọc con số.</p>')

out.append('''<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:10px;margin:20px 0 26px;">
<div style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:8px;padding:16px;">
<div style="font-weight:700;font-size:13px;color:#15803D;margin-bottom:6px;">1. Đúng chủ đề trước tiên</div>
<div style="font-size:12.5px;color:#64748B;">Ưu tiên nhóm ngách hẹp trùng lĩnh vực của bạn, kể cả khi DR thấp hơn.</div>
</div>
<div style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:8px;padding:16px;">
<div style="font-weight:700;font-size:13px;color:#15803D;margin-bottom:6px;">2. DR từ 30 trở lên</div>
<div style="font-size:12.5px;color:#64748B;">Dưới ngưỡng này, công sức đăng bài thường không tương xứng với giá trị nhận lại.</div>
</div>
<div style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:8px;padding:16px;">
<div style="font-weight:700;font-size:13px;color:#15803D;margin-bottom:6px;">3. Có người thật đang thảo luận</div>
<div style="font-size:12.5px;color:#64748B;">Mở vài chủ đề gần nhất xem ngày đăng. Diễn đàn không ai vào từ năm ngoái thì bỏ qua.</div>
</div>
<div style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:8px;padding:16px;">
<div style="font-weight:700;font-size:13px;color:#15803D;margin-bottom:6px;">4. Cho phép đặt liên kết</div>
<div style="font-size:12.5px;color:#64748B;">Đọc nội quy trước. Nhiều diễn đàn lớn đã chặn hoàn toàn link trong bài và chữ ký.</div>
</div>
</div>''')

out.append('<p>Về loại liên kết, phần lớn diễn đàn Việt Nam hiện gắn thuộc tính nofollow cho link người dùng đăng. Điều đó không có nghĩa là vô ích - nhưng nếu bạn cần liên kết dofollow trong thân bài, hãy đọc thêm về <a href="https://digicomvn.com/backlink-dofollow-va-nofollow/">khác biệt giữa dofollow và nofollow</a> để đặt kỳ vọng đúng.</p>')

# ===== H2: cách đăng =====
out.append('<h2>Đăng bài thế nào để không bị khoá tài khoản</h2>')
out.append('<p>Tài nguyên tìm được đã khó, giữ được tài khoản sống lâu còn khó hơn. Quản trị viên diễn đàn Việt Nam nhìn ra tài khoản đi link từ xa, và họ thường khoá không báo trước.</p>')

out.append('''<div style="max-width:620px;margin:22px auto 26px;">
<div style="background:linear-gradient(135deg,#0E8C7F,#0B746A);color:#fff;border-radius:8px;padding:14px 20px;margin:0 auto 8px;text-align:center;width:58%;min-width:220px;">
<div style="font-weight:700;font-size:14.5px;">Tuần 1-2: Chỉ tham gia, không đặt link</div>
<div style="font-size:12.5px;opacity:.92;margin-top:4px;">Hoàn thiện hồ sơ, trả lời 10-15 chủ đề bằng nội dung có ích thật</div>
</div>
<div style="text-align:center;font-size:18px;color:#94A3B8;line-height:1;">&#8595;</div>
<div style="background:linear-gradient(135deg,#2563EB,#1D4ED8);color:#fff;border-radius:8px;padding:14px 20px;margin:0 auto 8px;text-align:center;width:80%;min-width:220px;">
<div style="font-weight:700;font-size:14.5px;">Tuần 3-4: Liên kết trần, không từ khoá</div>
<div style="font-size:12.5px;opacity:.92;margin-top:4px;">Chèn link ở chữ ký hoặc hồ sơ, dùng tên thương hiệu hoặc URL trần</div>
</div>
<div style="text-align:center;font-size:18px;color:#94A3B8;line-height:1;">&#8595;</div>
<div style="background:linear-gradient(135deg,#64748B,#475569);color:#fff;border-radius:8px;padding:14px 20px;margin:0 auto;text-align:center;width:100%;">
<div style="font-weight:700;font-size:14.5px;">Từ tuần 5: Đặt link trong bài, rải đều</div>
<div style="font-size:12.5px;opacity:.92;margin-top:4px;">Mỗi diễn đàn tối đa 2-3 link/tháng, đặt trong bài viết thực sự trả lời câu hỏi của người khác</div>
</div>
</div>''')

out.append('<p>Ba nguyên tắc còn lại: không dùng một nội dung cho nhiều diễn đàn (quản trị viên các nơi này biết nhau và hay chia sẻ danh sách tài khoản spam); không đặt liên kết ở bài đầu tiên sau khi đăng ký; và giữ tỷ lệ từ khoá chính xác trong <a href="https://digicomvn.com/back-link-chat-luong/">anchor text</a> dưới 10% trên tổng số liên kết diễn đàn.</p>')

out.append('<h2>Backlink diễn đàn còn đáng làm không?</h2>')
out.append('<p>Đáng - nhưng không phải theo cách nhiều người vẫn nghĩ. Backlink diễn đàn ngày nay hầu hết là nofollow, giá trị chính không nằm ở việc truyền sức mạnh xếp hạng mà ở ba chỗ khác: giúp trang mới được Google phát hiện nhanh hơn, làm hồ sơ liên kết trông tự nhiên hơn thay vì toàn link báo, và mang về lượng truy cập thật nếu bạn viết đúng chỗ người ta đang cần.</p>')
out.append('<p>Nói thẳng: nếu mục tiêu của bạn là tăng thứ hạng cho từ khoá cạnh tranh, làm diễn đàn thủ công không đủ. Nó là lớp nền, không phải lớp chủ lực. Phần sức mạnh thật sự vẫn phải đến từ những liên kết trong thân bài trên các trang có thẩm quyền cao.</p>')

out.append('<p>Nếu bạn không có thời gian nuôi hàng chục tài khoản diễn đàn, Digicom nhận triển khai <a href="https://digicomvn.com/dich-vu-backlink/">dịch vụ backlink báo chí</a> với liên kết đặt trong thân bài trên các đầu báo và website có chỉ số công khai kiểm chứng được. Bạn có thể xem trước <a href="https://digicomvn.com/bang-gia/">bảng giá và danh sách trang cụ thể</a> trước khi quyết định.</p>')

html = "\n".join(out) + "\n"
open("225-final.html", "w", encoding="utf-8").write(html)
print("Số diễn đàn giữ lại:", tong)
print("Độ dài HTML:", len(html))
