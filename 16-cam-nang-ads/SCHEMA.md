# Cẩm nang tra cứu Ads + SEO - định dạng dữ liệu (đọc trước khi viết JSON)

Mỗi file JSON = 1 pane của trang. Tất cả tiếng Việt, KHÔNG dùng gạch dài (— hoặc –), chỉ dùng "-".

```json
{
  "platform": "google | meta | seo | faq-google | faq-meta | faq-seo",
  "updated": "2026-11-07",
  "groups": [
    {
      "id": "slug-duy-nhat",
      "title": "Tên nhóm ngắn",
      "intro": "1-2 câu nhóm này gom những tình huống gì",
      "nodes": [ NODE, ... ]
    }
  ]
}
```

NODE:
```json
{
  "id": "slug-duy-nhat-toan-file",
  "if": "Nếu ... (tình huống) HOẶC câu hỏi đúng kiểu người ta hỏi trên diễn đàn",
  "hat": "white | gray | black",      // FAQ và SEO: white = cách làm đúng chính sách; gray = vùng xám (nền tảng không cấm rõ nhưng rủi ro); black = vi phạm chính sách
  "asked": ["Reddit r/PPC", "BlackHatWorld", "Nhóm FB Việt Nam"],   // FAQ: nơi câu hỏi hay xuất hiện (chỉ tên cộng đồng, không cần link)
  "check": ["Kiểm tra gì trước, mỗi dòng 1 việc cụ thể"],
  "do": ["Xử lý/trả lời: mỗi dòng 1 ý, có số liệu/ngưỡng khi nguồn có"],
  "avoid": ["Việc không được làm, kèm lý do"],
  "evidence": "chinh-thuc | chuyen-gia | kinh-nghiem",
  "sources": [{"title": "Tên trang nguồn", "url": "https://..."}],
  "children": [ NODE, ... ]           // nhánh con "Nếu ... thì ..." (0-6 nhánh)
}
```

Nhãn evidence:
- chinh-thuc: có ít nhất 1 nguồn chính thức (Google Ads Help, Google Search Central, Meta Business Help, Meta Policies, tài liệu nền tảng).
- chuyen-gia: nguồn là chuyên gia có tên/đơn vị uy tín (Search Engine Land, Moz, Ahrefs, Jon Loomer, Brad Geddes...). Ghi tên trong "title".
- kinh-nghiem: không có nguồn, chỉ kinh nghiệm cộng đồng. Phải nói rõ trong "do" là "chưa có nguồn chính thức".

Quy tắc nội dung:
- Không bịa số. Ngưỡng/số liệu không có nguồn thì ghi "cộng đồng hay dùng ~X, chưa có số chính thức".
- Câu hỏi black hat: TRẢ LỜI theo khung: (1) người ta làm gì và tại sao, (2) chính sách nền tảng nói gì (trích nguồn), (3) nền tảng phát hiện/phạt thế nào, hậu quả thật (treo tài khoản, mất domain, mất tiền), (4) cách làm đúng đạt cùng mục đích. KHÔNG viết hướng dẫn từng bước để lách/né phát hiện.
- Mỗi "do" tối đa ~6 dòng, mỗi dòng 1 câu đầy đủ, dễ hiểu cho người làm nghề.
- id chỉ chữ thường, số, dấu gạch ngang; duy nhất trong toàn file.
- Kiểm tra file hợp lệ: `python3 -c "import json;json.load(open('<file>'))"`.

## Viết lại cho ĐẦY ĐỦ, DỄ HIỂU (Hiếu yêu cầu 07/11: "mọi câu trả lời cần đầy đủ và dễ hiểu", bản cũ "vắn tắt quá đọc chả hiểu gì")

Thêm 2 trường cho MỌI node (kể cả children):
- "tomtat": 2-4 câu trả lời thẳng tình huống/câu hỏi bằng lời thường, như đồng nghiệp giỏi nói với người mới: chuyện gì đang xảy ra, nên làm gì trước tiên, kết quả mong đợi.
- "visao": 2-5 câu giải thích CƠ CHẾ bằng lời đời thường: nền tảng (Google/Meta) đang xét gì, vì sao dẫn tới tình trạng này, vì sao cách xử lý lại hiệu quả. Có thể dùng ví von ngắn.

Viết lại "check", "do", "avoid":
- Mỗi dòng là câu đầy đủ chủ ngữ - vị ngữ, không viết kiểu ghi chú/rút gọn.
- "check": nói rõ VÀO ĐÂU (menu/báo cáo/công cụ cụ thể), NHÌN CÁI GÌ, và THẤY GÌ THÌ KẾT LUẬN GÌ.
- "do": từng bước theo thứ tự ưu tiên; mỗi bước nói làm gì, làm thế nào, và mong đợi điều gì sau khi làm (bao lâu thì thấy, dấu hiệu đã ổn).
- "avoid": sai lầm hay gặp + hậu quả cụ thể nếu mắc.
- Thuật ngữ tiếng Anh/viết tắt (learning phase, CAPI, Quality Score, manual action, canonical, SpamBrain, BM, via, ngưỡng...) giải thích ngắn trong ngoặc ở lần đầu xuất hiện trong node.
- Được tăng số dòng lên tới 8 nếu cần cho đủ ý; mỗi dòng tối đa ~45 từ.

Giữ nguyên tuyệt đối: "id", "if", "hat", "asked", "evidence", "sources", cấu trúc "children", thứ tự nhóm/node.
KHÔNG thêm sự kiện/số liệu mới không có trong node gốc hoặc trong chính các URL ở "sources" của node đó. Muốn thêm chi tiết thì mở nguồn của node để lấy, không lấy từ trí nhớ. Ngưỡng không có nguồn giữ nhãn "chưa có số chính thức".
Black/gray hat: vẫn đúng khung 4 phần, không hướng dẫn lách.
