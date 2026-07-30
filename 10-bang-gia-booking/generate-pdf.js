// Sinh "Bảng giá tổng hợp Digicom.pdf" tu publish-gia.json, dung puppeteer-core (ket noi Chrome
// da cai san, khong tai Chromium rieng) de co header/footer LAP LAI THAT SU tren MOI trang -
// thu Chrome CLI --print-to-pdf KHONG lam duoc viec nay (position:fixed chi tinh theo TOAN BO
// tai lieu dai, khong lap lai theo tung trang in - da kiem chung thuc te 2026-07-30).
// Chay: node generate-pdf.js
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');

const BASE = __dirname;
const DATA_FILE = path.join(BASE, 'publish-gia.json');
const PDF_FILE = path.join(BASE, 'bao-gia-tong-hop-digicom.pdf');
const CHROME = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';

const COLOR_ACTION = '#4761FF';
const COLOR_TEAL = '#0E8C7F';
const COLOR_HEADING = '#1C2035';
const COLOR_INK = '#14182B';
const COLOR_INK_SOFT = '#333A4D';
const COLOR_LINE = '#D8E0E8';
const COLOR_SURFACE = '#F1F3FA';

const DEFAULT_META = {
  hotline: '0988 769 317',
  email: 'sales@digicomvn.com',
  website: 'https://digicomvn.com/bang-gia/',
};

function esc(v) {
  if (v === null || v === undefined || v === '') return '-';
  return String(v).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

function fmtGia(v) {
  const n = parseFloat(v);
  if (isNaN(n)) return esc(v);
  return Math.round(n).toLocaleString('vi-VN') + ' đ';
}

// Watermark lap deu qua MOI trang bang background-image tiled that su tren <body> (khac voi
// position:fixed - da xac nhan KHONG lap lai theo trang khi in; con chen thu cong truoc moi
// <table> chi lap 1 lan/nhom, khong du day cho bang dai hang chuc trang). Background thi
// LUON lap theo dung nghia CSS repeat, xuyen suot toan bo chieu dai tai lieu -> moi trang cat
// ra tu tai lieu dai deu thay it nhat vai lan lap. Can printBackground:true (da bat o page.pdf).
function watermarkTileDataUri() {
  const svg = `<svg xmlns="http://www.w3.org/2000/svg" width="260" height="200">
    <text x="130" y="100" font-family="Arial,sans-serif" font-size="16" font-weight="700"
      fill="${COLOR_INK}" fill-opacity="0.07" text-anchor="middle"
      transform="rotate(-28 130 100)">DIGICOMVN.COM</text>
  </svg>`;
  return 'data:image/svg+xml;base64,' + Buffer.from(svg).toString('base64');
}

function buildBodyHtml(data) {
  const sections = [];
  for (const slug of Object.keys(data)) {
    if (slug.startsWith('_')) continue;
    const block = data[slug];
    const label = esc(block.label);
    const rows = block.rows || [];
    let body;
    if (!rows.length) {
      body = '<p class="empty">Chưa có dữ liệu công khai cho nhóm này tại thời điểm xuất file.</p>';
    } else {
      const trs = rows.map(r => (
        `<tr><td>${esc(r.ten)}</td><td>${esc(r.vi_tri)}</td>` +
        `<td class="num">${fmtGia(r.gia)}</td>` +
        `<td>${esc(r.so_link)}</td><td>${esc(r.yeu_cau)}</td></tr>`
      )).join('');
      body = `<table>
        <thead><tr><th>Tên báo / trang</th><th>Vị trí đăng</th><th>Giá (VNĐ)</th><th>Số link / loại link</th><th>Yêu cầu bài viết</th></tr></thead>
        <tbody>${trs}</tbody>
      </table>`;
    }
    sections.push(`<section><h2>${label} <span class="count">(${rows.length} mục)</span></h2>${body}</section>`);
  }

  return `<!doctype html><html lang="vi"><head><meta charset="utf-8"><style>
    *{box-sizing:border-box}
    body{font-family:'Helvetica Neue',Arial,sans-serif;color:${COLOR_INK};margin:0;padding:0 4mm;
      background-image:url('${watermarkTileDataUri()}');background-repeat:repeat}
    table,th,td{background:transparent}
    h1{font-size:20px;color:${COLOR_HEADING};margin:0 0 14px}
    section{margin-bottom:22px}
    table{width:100%;border-collapse:collapse;font-size:10.5px;page-break-inside:auto}
    tr{page-break-inside:avoid}
    thead{display:table-header-group}
    h2{font-size:14px;color:${COLOR_TEAL};border-left:4px solid ${COLOR_TEAL};padding-left:8px;margin:0 0 8px}
    h2 .count{font-size:11px;color:${COLOR_INK_SOFT};font-weight:normal}
    th{background:${COLOR_SURFACE};color:${COLOR_HEADING};text-align:left;padding:6px 8px;border-bottom:2px solid ${COLOR_LINE}}
    td{padding:5px 8px;border-bottom:1px solid ${COLOR_LINE};vertical-align:top}
    td.num{text-align:right;white-space:nowrap;font-weight:600}
    tr:nth-child(even) td{background:#FAFBFE}
    .empty{font-size:12px;color:${COLOR_INK_SOFT};font-style:italic}
  </style></head><body>
    <h1>Bảng giá tổng hợp - Digicom</h1>
    ${sections.join('')}
  </body></html>`;
}

// Header/footer template cua Chrome: HTML rieng, lap lai TREN TUNG TRANG that su (CDP
// Page.printToPDF). Class dac biet ('date','title','url','pageNumber','totalPages') Chrome tu
// dien gia tri - o day khong dung, tu ve toan bo bang JS/CSS inline vi template nay doc lap
// voi trang chinh, khong doc duoc bien tu ben ngoai.
function buildHeaderTemplate(nowStr, meta) {
  return `<div style="font-size:9px;width:100%;padding:0 12mm;color:${COLOR_INK_SOFT};
    display:flex;justify-content:flex-end;font-family:Arial,sans-serif">
    <span>Cập nhật ${esc(nowStr)} &nbsp;·&nbsp; ${esc(meta.website)} &nbsp;·&nbsp; Hotline ${esc(meta.hotline)}</span>
  </div>`;
}

function buildFooterTemplate(meta) {
  return `<div style="font-size:8.5px;width:100%;padding:0 12mm;color:${COLOR_INK_SOFT};
    display:flex;justify-content:space-between;font-family:Arial,sans-serif;border-top:1px solid ${COLOR_LINE};padding-top:2mm">
    <span>© Digicom - Bảng giá độc quyền, vui lòng không sao chép/phát tán dưới mọi hình thức.</span>
    <span>${esc(meta.email)} &nbsp;·&nbsp; <span class="pageNumber"></span>/<span class="totalPages"></span></span>
  </div>`;
}

async function main() {
  if (!fs.existsSync(DATA_FILE)) {
    console.error(`LOI: khong thay ${DATA_FILE}. Chay dump-publish-gia.php tren live truoc.`);
    process.exit(1);
  }
  const data = JSON.parse(fs.readFileSync(DATA_FILE, 'utf8'));
  const meta = Object.assign({}, DEFAULT_META, data._meta || {});
  const website = (meta.website || '').replace(/^https?:\/\//, '').replace(/\/$/, '');
  meta.website = website;

  const nowStr = new Intl.DateTimeFormat('vi-VN').format(new Date());
  const bodyHtml = buildBodyHtml(data);

  const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new' });
  const page = await browser.newPage();
  await page.setContent(bodyHtml, { waitUntil: 'load' });

  await page.pdf({
    path: PDF_FILE,
    format: 'A4',
    landscape: true,
    printBackground: true,
    displayHeaderFooter: true,
    headerTemplate: buildHeaderTemplate(nowStr, meta),
    footerTemplate: buildFooterTemplate(meta),
    margin: { top: '18mm', bottom: '14mm', left: '12mm', right: '12mm' },
  });

  await browser.close();

  const sizeKb = (fs.statSync(PDF_FILE).size / 1024).toFixed(0);
  console.log(`Da tao: ${PDF_FILE} (${sizeKb} KB)`);
  console.log('Deploy len live:');
  console.log(`  scp -P 65002 -i ~/.ssh/id_ed25519 "${PDF_FILE}" u704250056@145.79.26.63:/home/u704250056/domains/digicomvn.com/public_html/wp-content/uploads/bao-gia-tong-hop-digicom.pdf`);
}

main().catch(err => { console.error(err); process.exit(1); });
