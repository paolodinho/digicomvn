<?php
/*
 * Template Name: DGC Landing - Dich vu Backlink
 * Standalone landing (redesign 2026-07-04). Gan cho trang tuong ung trong WP Admin.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dịch Vụ Backlink Chất Lượng Cao — Hệ Thống Đa Tầng An Toàn | Digicom</title>
<meta name="description" content="Dịch vụ backlink chất lượng cao của Digicom: hệ thống backlink đa tầng an toàn, đa nguồn (textlink, guest post, báo, social entity), có ngách bất động sản. Không PBN, báo cáo minh bạch.">
<style>
:root{
  --blue:#0048D8; --blue-d:#0A2A66; --blue-ink:#0B2350; --blue-2:#0038AD;
  --teal:#0048D8; --teal-d:#0038AD;
  --cta:#00AE9C; --cta-d:#008576;
  --ink:#14233B; --ink-2:#586A7E; --line:#E4E9F1;
  --paper:#FFFFFF; --paper-2:#F3F7FC; --tint-blue:#EAF1FF; --tint-teal:#EAF1FF;
  --maxw:1180px; --sans:'Be Vietnam Pro',-apple-system,'Segoe UI',Roboto,sans-serif;
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:var(--sans);background:var(--paper);color:var(--ink);line-height:1.65;-webkit-font-smoothing:antialiased}
img,svg{max-width:100%;display:block}
a{color:var(--blue);text-decoration:none}
.wrap{max-width:var(--maxw);margin:0 auto;padding:0 24px}
h1,h2,h3,h4{line-height:1.13;letter-spacing:-.02em;font-weight:700;color:var(--blue-ink)}
.kicker{font-size:12.5px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--teal)}
.btn{display:inline-flex;align-items:center;gap:8px;font-weight:700;font-size:15.5px;padding:14px 28px;border-radius:9px;border:1.5px solid transparent;cursor:pointer;transition:.15s}
.btn-primary{background:var(--cta);color:#fff;box-shadow:0 12px 24px -8px rgba(0,174,156,.6)}.btn-primary:hover{background:var(--cta-d);box-shadow:0 16px 30px -8px rgba(0,174,156,.65);transform:translateY(-2px)}
.btn-outline{border-color:#CBD5E4;color:var(--blue-ink);background:#fff}.btn-outline:hover{border-color:var(--blue);color:var(--blue)}
.btn-white{background:#fff;color:var(--blue-ink)}.btn-cta{background:var(--cta);color:#fff}.btn-cta:hover{background:var(--cta-d)}
.sec{padding:50px 0}

header{position:sticky;top:0;z-index:40;background:rgba(255,255,255,.92);backdrop-filter:blur(8px);border-bottom:1px solid var(--line)}
.hd{display:flex;align-items:center;gap:32px;height:70px}
.logo{font-size:24px;font-weight:800;letter-spacing:-.03em;color:var(--blue)}.logo b{color:var(--teal)}
nav{display:flex;gap:26px;font-size:15px;font-weight:500}nav a{color:var(--ink)}nav a:hover{color:var(--blue)}
.hd-cta{margin-left:auto;display:flex;align-items:center;gap:16px}
.hd-phone{font-weight:700;color:var(--blue-ink);font-size:15px}
.crumb{background:var(--paper-2);border-bottom:1px solid var(--line);font-size:13.5px;color:var(--ink-2)}
.crumb .wrap{padding:11px 24px}.crumb a{color:var(--ink-2)}.crumb span{margin:0 8px;opacity:.5}

/* HERO */
.phero{padding:40px 0 34px;background:radial-gradient(120% 90% at 88% -10%,var(--tint-blue),transparent 52%)}
.phero-grid{display:grid;grid-template-columns:1.05fr .95fr;gap:48px;align-items:center}
.phero h1{font-size:46px;letter-spacing:-.033em;margin:14px 0 18px}
.phero h1 em{font-style:normal;color:var(--blue)}
.phero .sub{font-size:17.5px;color:var(--ink-2);max-width:32em;margin-bottom:24px}
.phero-actions{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:24px}
.hero-checks{display:flex;gap:22px;flex-wrap:wrap}
.hero-checks .hc{display:flex;align-items:center;gap:8px;font-size:14.5px;color:var(--ink-2)}
.hero-checks .hc b{color:var(--blue-ink)}
.hero-checks .hc:before{content:"✓";color:var(--teal);font-weight:800}
.report{background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 34px 64px -32px rgba(14,36,56,.34);overflow:hidden;transform:rotate(1.1deg)}
.report-top{display:flex;align-items:center;gap:8px;padding:14px 18px;border-bottom:1px solid var(--line);background:var(--paper-2)}
.rdot{width:11px;height:11px;border-radius:50%;background:#D3DCEA}
.report-top .rt{margin-left:8px;font-size:13px;font-weight:600;color:var(--ink-2)}
.report-body{padding:22px}
.mrow{display:flex;gap:14px;margin-bottom:18px}
.metric{flex:1;border:1px solid var(--line);border-radius:10px;padding:14px}
.metric .mv{font-size:25px;font-weight:800;color:var(--blue-ink)}.metric .mv span{color:var(--teal)}
.metric .ml{font-size:11px;color:var(--ink-2);text-transform:uppercase;letter-spacing:.04em}
.bars{display:flex;align-items:flex-end;gap:7px;height:64px;margin-bottom:18px}
.bars i{flex:1;background:var(--paper-2);border-radius:4px 4px 0 0}.bars i.on{background:var(--teal)}
.plabel{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--ink-2);margin-bottom:8px}
.tier{display:flex;align-items:center;gap:10px;padding:8px 0;border-top:1px solid var(--line);font-size:13.5px}
.tier b{width:26px;height:26px;border-radius:7px;background:var(--tint-teal);color:var(--teal-d);display:flex;align-items:center;justify-content:center;font-size:12px}
.tier .ok{margin-left:auto;font-size:11.5px;font-weight:700;color:#0048D8;background:#EAF1FF;padding:2px 9px;border-radius:20px}

/* CLIENT LOGO WALL */
.clients{border-top:1px solid var(--line);border-bottom:1px solid var(--line);background:var(--paper-2);padding:30px 0 34px}
.clients .chead{text-align:center;margin-bottom:20px}
.clients .chead .t{font-size:15px;font-weight:600;color:var(--ink-2)}
.clients .chead .t b{color:var(--blue-ink)}
.client-logos{display:flex;flex-wrap:wrap;justify-content:center;gap:14px;max-width:1120px;margin:0 auto}
.clogo{flex:0 1 calc((100% - 70px)/6);min-width:142px;display:flex;align-items:center;justify-content:center;height:76px;background:#fff;border:1px solid var(--line);border-radius:10px;padding:14px 18px;transition:.15s}
.clogo:hover{border-color:#C7D6EE;box-shadow:0 10px 22px -14px rgba(11,35,80,.35)}
.clogo img{max-height:32px;max-width:78%;width:auto;object-fit:contain}

/* EDITORIAL */
.edi{display:grid;grid-template-columns:.85fr 1.15fr;gap:48px;align-items:start}
.edi-side{position:sticky;top:96px}
.edi-num{font-size:80px;font-weight:800;line-height:.8;color:var(--tint-blue);letter-spacing:-.05em}
.edi-side .pull{font-size:21px;font-weight:700;color:var(--blue-ink);margin-top:-16px;letter-spacing:-.02em}
.edi-side .pull b{color:var(--blue);background:linear-gradient(transparent 62%,var(--tint-teal) 62%)}
.edi-body p{margin-bottom:16px;font-size:16.5px;color:#33404F}
.edi-body h3{font-size:21px;margin:26px 0 10px}
.edi-body strong{color:var(--blue-ink)}

/* BENTO */
.bento{display:grid;grid-template-columns:repeat(3,1fr);grid-auto-rows:1fr;gap:16px}
.bcell{border:1px solid var(--line);border-radius:16px;padding:24px;background:#fff;transition:.15s;display:flex;flex-direction:column}
.bcell:hover{border-color:#C7D6EE;box-shadow:0 16px 34px -22px rgba(0,72,216,.45);transform:translateY(-2px)}
.bcell .ic{width:46px;height:46px;border-radius:12px;background:var(--tint-blue);display:flex;align-items:center;justify-content:center;margin-bottom:12px}
.bcell .ic.t{background:var(--tint-teal)}
.bcell h3{font-size:17.5px;margin-bottom:6px}.bcell p{font-size:14px;color:var(--ink-2)}
.bcell.feat{grid-column:span 2;grid-row:span 2;background:linear-gradient(160deg,var(--blue-ink) 0%,var(--blue-d) 100%);border:0;color:#fff;justify-content:space-between}
.bcell.feat h3{color:#fff;font-size:24px;margin:14px 0 8px}
.bcell.feat p{color:#C9D9FB;font-size:15.5px;max-width:30em}
.bcell.feat .ic{background:rgba(255,255,255,.16)}
.feat-logos{display:flex;gap:10px;flex-wrap:wrap;margin-top:20px}
.feat-logos img{height:24px;width:auto;background:#fff;border-radius:5px;padding:4px 7px}

/* CRITERIA */
.crit-wrap{display:grid;grid-template-columns:.8fr 1.2fr;gap:44px;align-items:center}
.crit{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.crit-item{border:1px solid var(--line);border-left:3px solid var(--teal);border-radius:12px;padding:18px 20px;background:#fff}
.crit-item .n{font-size:19px;font-weight:800;color:var(--blue)}
.crit-item h4{font-size:15px;margin:4px 0 4px}.crit-item p{font-size:13px;color:var(--ink-2)}

/* PROCESS */
.proc{display:grid;grid-template-columns:repeat(4,1fr);gap:0;position:relative;margin-top:6px}
.proc:before{content:"";position:absolute;top:19px;left:12%;right:12%;height:2px;background:var(--line)}
.pstep{text-align:center;padding:0 16px;position:relative}
.pstep .pn{width:40px;height:40px;border-radius:50%;background:#fff;border:2px solid var(--blue);color:var(--blue);font-weight:800;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;position:relative;z-index:1}
.pstep h3{font-size:16px;margin-bottom:5px}.pstep p{font-size:13.5px;color:var(--ink-2)}

/* EXPERIENCE & TEAM */
.exp-grid{display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center}
.exp-copy h2{font-size:32px;margin:12px 0 14px}
.exp-copy p{color:var(--ink-2);font-size:16.5px;margin-bottom:22px;max-width:34em}
.exp-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px}
.exp-stat{border:1px solid var(--line);border-radius:12px;padding:16px 18px;background:#fff}
.exp-stat .n{font-size:26px;font-weight:800;color:var(--blue)}
.exp-stat .l{font-size:12.5px;color:var(--ink-2)}
.collage{position:relative;height:380px}
.collage img{position:absolute;border-radius:14px;object-fit:cover;box-shadow:0 24px 48px -24px rgba(11,35,80,.4);border:4px solid #fff}
.collage .c1{width:66%;height:70%;top:0;right:0;z-index:1}
.collage .c2{width:52%;height:52%;bottom:0;left:0;z-index:2}
.collage .cbadge{position:absolute;right:6%;bottom:4%;z-index:3;background:var(--blue-ink);color:#fff;border-radius:12px;padding:12px 16px;box-shadow:0 16px 30px -14px rgba(0,0,0,.5)}
.collage .cbadge .n{font-size:20px;font-weight:800;color:#7FB0FF}
.collage .cbadge .l{font-size:11.5px;color:#C6D3E7}

/* TESTIMONIALS */
.tm-top{display:grid;grid-template-columns:1.05fr .95fr;gap:48px;align-items:center;margin-bottom:26px}
.tm-rate{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.tm-rate .stars{color:#00AE9C;letter-spacing:2px;font-size:16px}
.tm-rate b{font-size:18px;color:var(--blue-ink)}
.tm-rate .rr{font-size:14px;color:var(--ink-2)}
.tm-photo{position:relative;border-radius:16px;overflow:hidden;box-shadow:0 26px 50px -26px rgba(11,35,80,.4)}
.tm-photo img{width:100%;aspect-ratio:16/10;object-fit:cover;object-position:center 38%}
.tm-badge{position:absolute;left:18px;bottom:18px;background:var(--blue-ink);color:#fff;border-radius:11px;padding:10px 15px}
.tm-badge b{color:#fff;font-size:15px;display:block}.tm-badge span{color:#9FB2CE;font-size:12px}
.tm-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.tm{background:#fff;border:1px solid var(--line);border-radius:14px;padding:26px 24px}
.tm .stars{color:#00AE9C;letter-spacing:3px;font-size:14px;margin-bottom:12px}
.tm blockquote{font-size:15.5px;margin-bottom:20px}
.tm .who{display:flex;align-items:center;gap:12px}
.tm .av{width:42px;height:42px;border-radius:50%;background:var(--blue-ink);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:15px}
.tm .av.t{background:var(--teal)}
.tm .who b{font-size:14.5px;color:var(--blue-ink);display:block}
.tm .who span{font-size:12.5px;color:var(--ink-2)}

/* FAQ */
.faq-wrap{display:grid;grid-template-columns:.8fr 1.2fr;gap:48px;align-items:start}
.faq-side{position:sticky;top:96px}
.faq-side h2{font-size:30px;margin:12px 0 14px}.faq-side p{color:var(--ink-2);margin-bottom:20px}
.faq-list details{background:#fff;border:1px solid var(--line);border-radius:10px;margin-bottom:12px;overflow:hidden}
.faq-list summary{cursor:pointer;list-style:none;padding:18px 22px;font-weight:600;font-size:16px;color:var(--blue-ink);display:flex;justify-content:space-between;gap:12px}
.faq-list summary::-webkit-details-marker{display:none}
.faq-list summary:after{content:"+";color:var(--blue);font-size:22px;line-height:1}
.faq-list details[open] summary:after{content:"–"}
.faq-list .a{padding:0 22px 20px;color:var(--ink-2);font-size:15.5px}

/* RELATED */
.rel-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.rel{border:1px solid var(--line);border-radius:12px;padding:18px 20px;background:#fff}
.rel .k{font-size:12px;font-weight:700;color:var(--teal);text-transform:uppercase;letter-spacing:.04em}
.rel a{font-weight:600;color:var(--blue-ink);font-size:15.5px;display:block;margin-top:6px}.rel a:hover{color:var(--blue)}

/* CTA */
.cta{background:linear-gradient(120deg,var(--blue) 0%,var(--teal) 130%);border-radius:20px;padding:50px 46px;display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap}
.cta h2{color:#fff;font-size:28px;margin-bottom:8px}.cta p{color:#E6EEFF}.cta .acts{display:flex;gap:14px;flex-wrap:wrap}

footer{background:var(--blue-d);color:#94A6C2;padding:46px 0 26px;margin-top:52px;font-size:14.5px}
.ft-grid{display:grid;grid-template-columns:1.4fr 1fr 1fr 1fr;gap:36px}
footer .logo{color:#fff;margin-bottom:12px}footer a{color:#94A6C2}footer a:hover{color:#fff}
footer h4{color:#fff;font-size:13px;text-transform:uppercase;letter-spacing:.08em;margin-bottom:14px}
footer ul{list-style:none;display:grid;gap:9px}

@media(max-width:900px){
  .phero-grid,.edi,.crit-wrap,.tm-top,.faq-wrap{grid-template-columns:1fr;gap:32px}
  .clogo{flex:0 1 calc((100% - 28px)/3);min-width:0}
  .bento{grid-template-columns:1fr 1fr}.bcell.feat{grid-column:span 2;grid-row:auto}
  .tm-grid,.rel-grid{grid-template-columns:1fr}
  .proc{grid-template-columns:1fr 1fr;gap:26px}.proc:before{display:none}
  .edi-side,.faq-side{position:static}.edi-num{font-size:76px}
  .collage{height:320px}
  nav,.hd-phone{display:none}.phero h1{font-size:34px}
}
</style>
</head>
<body>

<header><div class="wrap hd">
  <a class="logo" href="<?php echo esc_url( home_url( "/" ) ); ?>" style="text-decoration:none">Digi<b>com</b></a>
  <nav><a href="<?php echo esc_url( home_url( "/" ) ); ?>">Trang chủ</a><a href="<?php echo esc_url( home_url( "/dich-vu/" ) ); ?>">Dịch vụ</a><a href="<?php echo esc_url( home_url( "/bang-gia/" ) ); ?>">Bảng giá</a><a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>">Blog</a><a href="<?php echo esc_url( home_url( "/ve-digicom/" ) ); ?>">Về Digicom</a><a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>">Liên hệ</a></nav>
  <div class="hd-cta"><span class="hd-phone">0988 769 317</span><a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>" class="btn btn-primary">Nhận báo giá</a></div>
</div></header>

<div class="crumb"><div class="wrap"><a>Trang chủ</a><span>›</span><a>Dịch vụ</a><span>›</span>Dịch vụ Backlink</div></div>

<!-- 1. HERO -->
<section class="phero"><div class="wrap phero-grid">
  <div>
    <span class="kicker">Dịch vụ Backlink</span>
    <h1>Dịch vụ <em>backlink chất lượng cao</em>, hệ thống đa tầng an toàn</h1>
    <p class="sub">Chúng tôi chọn từng site theo chỉ số thật rồi mới đặt link. Bạn duyệt danh sách trước khi chạy, nhận báo cáo đầy đủ khi bàn giao.</p>
    <div class="phero-actions">
      <a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>" class="btn btn-primary">Nhận báo giá backlink</a>
      <a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>" class="btn btn-outline">Xem bảng giá chi tiết</a>
    </div>
    <div class="hero-checks">
      <div class="hc"><b>Không PBN</b>, không spam</div>
      <div class="hc">Index <b>98%</b></div>
      <div class="hc">Duyệt site <b>trước khi chạy</b></div>
    </div>
  </div>
  <div class="report">
    <div class="report-top"><i class="rdot"></i><i class="rdot"></i><i class="rdot"></i><span class="rt">Hệ thống backlink đa tầng — minh hoạ</span></div>
    <div class="report-body">
      <div class="mrow">
        <div class="metric"><div class="mv">DR <span>30–90</span></div><div class="ml">Dải chỉ số site</div></div>
        <div class="metric"><div class="mv">98<span>%</span></div><div class="ml">Tỷ lệ index</div></div>
      </div>
      <div class="bars"><i style="height:34%"></i><i style="height:50%"></i><i style="height:44%"></i><i class="on" style="height:66%"></i><i class="on" style="height:80%"></i><i class="on" style="height:96%"></i></div>
      <div class="plabel">Cấu trúc đa tầng</div>
      <div class="tier"><b>T1</b><span>Backlink báo &amp; site DR cao trỏ trực tiếp</span><span class="ok">dofollow</span></div>
      <div class="tier"><b>T2</b><span>Guest post &amp; textlink site vệ tinh</span><span class="ok">index</span></div>
      <div class="tier"><b>T3</b><span>Social &amp; entity củng cố tín hiệu</span><span class="ok">an toàn</span></div>
    </div>
  </div>
</div></section>

<!-- 3a. SERVICE: la gi -->
<section class="sec"><div class="wrap edi">
  <div class="edi-side">
    <div class="edi-num">“”</div>
    <p class="pull">Mỗi backlink chất lượng là một <b>phiếu tín nhiệm</b> gửi tới Google.</p>
  </div>
  <div class="edi-body">
    <span class="kicker">Dịch vụ backlink là gì</span>
    <h2 style="font-size:30px;margin:10px 0 16px">Xây backlink theo hệ thống, không chạy theo số lượng</h2>
    <p><strong>Backlink</strong> là liên kết từ website khác trỏ về trang của bạn. Đây vẫn là một trong những yếu tố xếp hạng quan trọng nhất của Google. Website có nhiều liên kết từ nguồn uy tín sẽ lên hạng nhanh và giữ hạng lâu hơn.</p>
    <p>Vấn đề là link từ site rác hay PBN có thể khiến website dính án phạt <strong>Google Penguin</strong>, mất luôn thứ hạng đang có. Nên chuyện quan trọng không phải mua được bao nhiêu link, mà là link đó đến từ đâu.</p>
    <h3>Cách Digicom làm</h3>
    <p>Digicom không bán gói "1000 backlink giá rẻ". Mỗi chiến dịch được thiết kế theo <strong>hệ thống đa tầng</strong>: lớp T1 là link mạnh từ báo và site DR cao trỏ thẳng về website; lớp T2, T3 bồi phía sau để link chính khỏe hơn, index tốt hơn. Nhìn từ phía Google, hồ sơ liên kết của bạn tăng trưởng tự nhiên như một thương hiệu đang lớn dần.</p>
  </div>
</div></section>

<!-- 3b. SERVICE: 6 loai -->
<section class="sec" style="background:var(--paper-2);padding-top:56px"><div class="wrap">
  <div style="max-width:620px;margin-bottom:24px">
    <span class="kicker">Nguồn link</span>
    <h2 style="font-size:32px;margin:12px 0 10px">Các loại backlink Digicom triển khai</h2>
    <p style="color:var(--ink-2);font-size:16.5px">Mỗi ngành, mỗi giai đoạn cần một cách đi link khác nhau. Tuỳ mục tiêu, Digicom phối các nguồn dưới đây thành một hệ thống hoàn chỉnh.</p>
  </div>
  <div class="bento">
    <div class="bcell feat">
      <div><div class="ic"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"><path d="M4 5h13v14H6a2 2 0 0 1-2-2zM17 8h3v9a2 2 0 0 1-2 2M7 9h7M7 13h7"/></svg></div>
      <h3>Backlink báo điện tử</h3><p>Loại link mạnh và khó lấy nhất. Digicom booking trực tiếp với các đầu báo lớn, không qua trung gian, nên giá tốt và chủ động lịch đăng.</p></div>
      <div class="feat-logos"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>press-logos/vnexpress.png"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>press-logos/dantri.png"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>press-logos/tuoitre.png"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>press-logos/cafef.png"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>press-logos/vietnamnet.png"></div>
    </div>
    <div class="bcell"><div class="ic"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0048D8" stroke-width="2" stroke-linecap="round"><path d="M9 15l6-6M10.5 6.5L13 4a4 4 0 0 1 5.5 5.5L16 12M8 12l-2.5 2.5A4 4 0 0 0 11 20l2.5-2.5"/></svg></div><h3>Textlink</h3><p>Chèn link vào bài viết đã có traffic trên site cùng chủ đề.</p></div>
    <div class="bcell"><div class="ic t"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0048D8" stroke-width="2" stroke-linecap="round"><rect x="4" y="3" width="16" height="18" rx="2.5"/><path d="M8 8h8M8 12h8M8 16h5"/></svg></div><h3>Guest Post</h3><p>Viết bài mới đăng trên site đúng ngành, link dofollow nằm tự nhiên trong bài.</p></div>
    <div class="bcell"><div class="ic t"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0048D8" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="3.2"/><path d="M5 20a7 7 0 0 1 14 0"/></svg></div><h3>Social &amp; Entity</h3><p>Bồi tín hiệu thương hiệu từ mạng xã hội và các nền tảng lớn.</p></div>
    <div class="bcell"><div class="ic"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0048D8" stroke-width="2" stroke-linecap="round"><path d="M12 3l8 4v5c0 4-3.5 7-8 9-4.5-2-8-5-8-9V7z"/><path d="M9 12l2 2 4-4"/></svg></div><h3>Gov/Edu &amp; ngách BĐS</h3><p>Link từ tên miền chính phủ, giáo dục; riêng bất động sản có hệ site chuyên ngành.</p></div>
  </div>
</div></section>

<!-- 3c. SERVICE: tieu chi -->
<section class="sec"><div class="wrap crit-wrap">
  <div>
    <span class="kicker">Chọn lọc</span>
    <h2 style="font-size:30px;margin:12px 0 12px">Site nào được vào hệ thống?</h2>
    <p style="color:var(--ink-2);font-size:16px">Site nào cũng phải qua vòng kiểm tra bằng Ahrefs và Majestic trước. Danh sách gửi bạn duyệt luôn kèm đủ chỉ số, thấy ổn mới chạy.</p>
  </div>
  <div class="crit">
    <div class="crit-item"><div class="n">DR / DA</div><h4>Chỉ số uy tín</h4><p>Đủ ngưỡng cam kết của từng gói.</p></div>
    <div class="crit-item"><div class="n">Traffic</div><h4>Lưu lượng thật</h4><p>Site còn sống, còn người đọc thật.</p></div>
    <div class="crit-item"><div class="n">TF / CF</div><h4>Trust &amp; Citation</h4><p>Tỷ lệ cân đối, loại site từng spam.</p></div>
    <div class="crit-item"><div class="n">Chủ đề</div><h4>Đúng ngành</h4><p>Link cùng lĩnh vực mới có giá trị cao.</p></div>
  </div>
</div></section>

<!-- 3d. SERVICE: quy trinh -->
<section class="sec" style="background:var(--paper-2)"><div class="wrap">
  <div style="text-align:center;max-width:560px;margin:0 auto 26px">
    <span class="kicker">Quy trình</span>
    <h2 style="font-size:30px;margin-top:12px">4 bước từ khảo sát đến bàn giao</h2>
  </div>
  <div class="proc">
    <div class="pstep"><div class="pn">1</div><h3>Khảo sát</h3><p>Xem hồ sơ backlink hiện tại, từ khoá mục tiêu và ngân sách của bạn.</p></div>
    <div class="pstep"><div class="pn">2</div><h3>Duyệt danh sách</h3><p>Digicom gửi danh sách site kèm chỉ số. Bạn duyệt xong mới triển khai.</p></div>
    <div class="pstep"><div class="pn">3</div><h3>Đặt link</h3><p>Đi link theo lộ trình, tốc độ tự nhiên, tránh tăng đột biến.</p></div>
    <div class="pstep"><div class="pn">4</div><h3>Bàn giao</h3><p>Gửi báo cáo từng link, kiểm tra index và theo dõi thứ hạng cùng bạn.</p></div>
  </div>
</div></section>

<!-- related (chuyen len truoc phan khach hang) -->
<section class="sec"><div class="wrap">
  <div style="max-width:620px;margin-bottom:26px"><span class="kicker">Tìm hiểu thêm</span><h2 style="font-size:30px;margin-top:12px">Kiến thức backlink liên quan</h2></div>
  <div class="rel-grid">
    <div class="rel"><span class="k">Kiến thức</span><a>Backlink là gì? Hướng dẫn A-Z xây dựng backlink chất lượng →</a></div>
    <div class="rel"><span class="k">Kỹ thuật</span><a>Backlink dofollow và nofollow: so sánh và tỷ lệ vàng →</a></div>
    <div class="rel"><span class="k">Công cụ</span><a>Kiểm tra backlink: top công cụ và hướng dẫn chi tiết →</a></div>
    <div class="rel"><span class="k">Chất lượng</span><a>Backlink chất lượng cao: tiêu chí đánh giá và cách xây →</a></div>
    <div class="rel"><span class="k">Uy tín</span><a>Backlink Gov/Edu: cách lấy liên kết từ trang chính phủ →</a></div>
    <div class="rel"><span class="k">Dịch vụ khác</span><a>Mua Textlink · Guest Post · Booking báo &amp; PR →</a></div>
  </div>
</div></section>

<!-- 7. TESTIMONIALS (kem anh doi ngu) -->
<section class="sec" style="background:var(--paper-2)"><div class="wrap">
  <div class="tm-top">
    <div>
      <span class="kicker">Khách hàng</span>
      <h2 style="font-size:32px;margin:12px 0 12px">Khách hàng nói gì về chúng tôi</h2>
      <p style="color:var(--ink-2);font-size:16.5px;margin-bottom:18px">Đằng sau mỗi chiến dịch là đội off-page của Digicom trực tiếp khảo sát, chọn site và theo dõi index — không khoán ngoài, không chạy tool spam.</p>
      <div class="tm-rate"><span class="stars">★★★★★</span><b>4.9/5</b><span class="rr">từ 100+ khách hàng doanh nghiệp</span></div>
    </div>
    <div class="tm-photo">
      <img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>team/team-bg.png" alt="Đội ngũ Digicom">
      <div class="tm-badge"><b>Digicom</b><span>team off-page SEO</span></div>
    </div>
  </div>
  <div class="tm-grid">
    <div class="tm"><div class="stars">★★★★★</div><blockquote>"Trước tôi mua link chỗ khác toàn nhận file Excel không kiểm chứng được. Bên này gửi danh sách trước, check được từng site nên mới dám làm tiếp."</blockquote><div class="who"><span class="av">TP</span><div><b>Trưởng phòng Marketing</b><span>Dịch vụ Backlink</span></div></div></div>
    <div class="tm"><div class="stars">★★★★★</div><blockquote>"Từ khoá chính lên top 5 sau khoảng 3 tháng. Điều tôi ưng nhất là link báo lên đúng lịch đã hẹn, không phải giục."</blockquote><div class="who"><span class="av t">CD</span><div><b>Chủ doanh nghiệp SME</b><span>Hệ thống đa tầng</span></div></div></div>
    <div class="tm"><div class="stars">★★★★★</div><blockquote>"Làm BĐS nên tôi cần link đúng ngành, anchor theo tên dự án. Digicom hiểu việc này ngay từ buổi tư vấn đầu, đỡ mất công giải thích."</blockquote><div class="who"><span class="av">GD</span><div><b>Giám đốc sàn BĐS</b><span>Backlink Bất động sản</span></div></div></div>
  </div>
</div></section>

<!-- 2. CLIENT LOGO WALL -->
<div class="clients"><div class="wrap">
  <div class="chead"><span class="t"><b>Khách hàng đã đồng hành</b> cùng Digicom</span></div>
  <div class="client-logos">
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/palletgo.jpg" alt="PalletGo Vietnam"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/serene.jpg" alt="Serene Hotel Tuần Châu"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/nghikigai.png" alt="Nghikigai"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/star.png" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/bauer.png" alt="Bauer"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c06.jpg" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c07.png" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c08.png" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c09.png" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c10.jpg" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c11.png" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c12.png" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c13.png" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c14.png" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c15.webp" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c16.png" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c17.jpg" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c18.jpg" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c19.webp" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c20.png" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c21.png" alt="Khách hàng Digicom"></span>
    <span class="clogo"><img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>client-logos/c22.png" alt="Khách hàng Digicom"></span>
  </div>
</div></div>

<!-- 8. FAQ -->
<section class="sec"><div class="wrap faq-wrap">
  <div class="faq-side">
    <span class="kicker">Hỏi đáp</span>
    <h2>Câu hỏi thường gặp</h2>
    <p>Chưa thấy câu trả lời bạn cần? Gọi thẳng cho Digicom, tư vấn không tính phí.</p>
    <a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>" class="btn btn-primary">Gọi 0988 769 317</a>
  </div>
  <div class="faq-list">
    <details open><summary>Mua backlink có bị Google phạt không?</summary><div class="a">Không, nếu làm đúng cách. Google phạt link spam từ site rác và PBN, chứ không phạt link chất lượng từ site thật. Digicom chọn nguồn sạch, đi link với tốc độ tự nhiên nên tránh được thuật toán Penguin.</div></details>
    <details><summary>Hệ thống backlink đa tầng là gì?</summary><div class="a">Là cách xây link theo lớp: lớp T1 trỏ thẳng về website của bạn, lớp T2 và T3 trỏ về T1 để bồi sức mạnh. Link chính vì thế khỏe hơn, index tốt hơn và bền hơn so với đi link đơn lẻ.</div></details>
    <details><summary>Backlink dofollow và nofollow khác nhau thế nào?</summary><div class="a">Dofollow truyền sức mạnh SEO trực tiếp về trang đích, nofollow thì không. Nhưng một hồ sơ chỉ toàn dofollow lại thiếu tự nhiên, nên chiến dịch tốt cần cả hai với tỷ lệ hợp lý.</div></details>
    <details><summary>Bao lâu thì thấy kết quả?</summary><div class="a">Thường 4–12 tuần tuỳ độ cạnh tranh của từ khoá và nền tảng website. Google cần thời gian index và đánh giá link, nên Digicom đi theo lộ trình chứ không đẩy ồ ạt để "thấy nhanh".</div></details>
    <details><summary>Chi phí dịch vụ backlink bao nhiêu?</summary><div class="a">Gói khởi đầu từ 500.000đ; hệ thống đa tầng từ 2.5 triệu/tháng. Giá phụ thuộc số lượng và chỉ số site bạn chọn — xem chi tiết từng mức ở trang Bảng giá, hoặc gọi để được tư vấn theo ngân sách.</div></details>
  </div>
</div></section>

<!-- 9. CTA -->
<section class="sec" style="padding-top:0"><div class="wrap"><div class="cta">
  <div><h2>Cần một hệ thống backlink tử tế?</h2><p>Gửi website của bạn, Digicom khảo sát và đề xuất lộ trình trong 24 giờ.</p></div>
  <div class="acts"><a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>" class="btn btn-cta">Gọi 0988 769 317</a><a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>" class="btn btn-white">Chat Zalo</a></div>
</div></div></section>

<footer><div class="wrap ft-grid">
  <div><div class="logo">Digi<b style="color:var(--teal)">com</b></div><p style="max-width:26em">Chuyên Textlink, Backlink, Guest Post &amp; Booking báo PR cho doanh nghiệp và agency SEO.</p></div>
  <div><h4>Dịch vụ</h4><ul><li><a href="<?php echo esc_url( home_url( "/dich-vu/mua-textlink/" ) ); ?>">Mua Textlink</a></li><li><a href="<?php echo esc_url( home_url( "/dich-vu/dich-vu-backlink/" ) ); ?>">Dịch vụ Backlink</a></li><li><a href="<?php echo esc_url( home_url( "/dich-vu/guest-post/" ) ); ?>">Guest Post</a></li><li><a href="<?php echo esc_url( home_url( "/dich-vu/booking-bao-pr/" ) ); ?>">Booking báo &amp; PR</a></li></ul></div>
  <div><h4>Hỗ trợ</h4><ul><li><a href="<?php echo esc_url( home_url( "/bang-gia/" ) ); ?>">Bảng giá</a></li><li><a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>">Blog</a></li><li><a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>">Liên hệ</a></li></ul></div>
  <div><h4>Liên hệ</h4><ul><li>Hotline 0988 769 317</li><li>info@digicomvn.com</li><li>Gamuda Garden, Hà Nội</li></ul></div>
</div></footer>

</body>
</html>
