<?php
/*
 * Template Name: DGC Landing - Mua Textlink
 * Standalone landing (redesign 2026-07-04). Gan cho trang tuong ung trong WP Admin.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mua Textlink Chất Lượng — Chèn Link Site DR/Traffic Cao | Digicom</title>
<meta name="description" content="Mua textlink chất lượng tại Digicom: chèn link vào bài viết có sẵn trên site DR/traffic cao đúng chủ đề, có textlink edu/gov. Tự chọn site theo chỉ số, báo giá minh bạch từng link.">
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

/* SITE PICKER (hero textlink) */
.picker{background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 34px 64px -32px rgba(14,36,56,.34);overflow:hidden}
.picker-top{display:flex;align-items:center;gap:8px;padding:14px 18px;border-bottom:1px solid var(--line);background:var(--paper-2)}
.picker-top .rt{margin-left:8px;font-size:13px;font-weight:600;color:var(--ink-2)}
.picker table{width:100%;border-collapse:collapse;font-size:13.5px}
.picker th{background:var(--paper-2);color:var(--ink-2);font-weight:700;text-transform:uppercase;font-size:10.5px;letter-spacing:.05em;text-align:left;padding:10px 16px}
.picker td{padding:12px 16px;border-top:1px solid var(--line)}
.picker .dom{font-weight:700;color:var(--blue-ink)}
.picker .dr{color:var(--blue);font-weight:700}
.picker .pr{font-weight:700;color:var(--ink)}
.picker tr.on{background:var(--tint-blue)}
.picker .tick{width:20px;height:20px;border-radius:6px;background:var(--teal);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800}
.picker .tick.off{background:#fff;border:1.5px solid var(--line)}
.picker-foot{display:flex;justify-content:space-between;align-items:center;padding:14px 18px;border-top:1px solid var(--line);background:var(--paper-2);font-size:13px}
.picker-foot b{color:var(--blue-ink);font-size:16px}

/* COMPARISON textlink vs backlink */
.vs{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.vs-card{border:1px solid var(--line);border-radius:16px;padding:28px;background:#fff}
.vs-card.hi{border:1.5px solid var(--blue);background:linear-gradient(180deg,var(--tint-blue),#fff 60%)}
.vs-card .tag{display:inline-block;font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--blue);background:var(--tint-blue);border-radius:20px;padding:4px 12px;margin-bottom:12px}
.vs-card h3{font-size:20px;margin-bottom:6px}
.vs-card .lead{font-size:14.5px;color:var(--ink-2);margin-bottom:16px}
.vs-card ul{list-style:none;display:grid;gap:9px}
.vs-card li{font-size:14px;color:var(--ink-2);padding-left:22px;position:relative}
.vs-card li:before{content:"✓";position:absolute;left:0;color:var(--teal);font-weight:800}
.vs-card .foot{margin-top:16px;font-size:13.5px}
@media(max-width:760px){.vs{grid-template-columns:1fr}}


/* FULL PRICE TABLE (textlink) */
.pt-wrap{border:1px solid var(--line);border-radius:16px;overflow:hidden;background:#fff;box-shadow:0 20px 44px -30px rgba(11,35,80,.35)}
.pt-bar{display:flex;gap:10px;flex-wrap:wrap;align-items:center;padding:16px 18px;border-bottom:1px solid var(--line);background:var(--paper-2)}
.pt-bar input{flex:1;min-width:200px;padding:10px 14px;border:1.5px solid var(--line);border-radius:8px;font-size:14px;font-family:inherit}
.pchip{font-size:13px;font-weight:600;color:var(--ink-2);background:#fff;border:1.5px solid var(--line);border-radius:20px;padding:7px 14px;cursor:pointer}
.pchip.on{background:var(--blue);color:#fff;border-color:var(--blue)}
.pt-scroll{overflow-x:auto}
.pt{width:100%;border-collapse:collapse;font-size:14.5px;min-width:680px}
.pt th{text-align:left;padding:12px 18px;color:var(--ink-2);font-size:11px;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid var(--line);white-space:nowrap}
.pt td{padding:14px 18px;border-bottom:1px solid var(--line);vertical-align:middle}
.pt tr:last-child td{border-bottom:0}
.pt .nm{font-weight:700;color:var(--blue-ink)}
.pt .sub{font-size:12.5px;color:var(--ink-2)}
.pt .tag{font-size:10px;font-weight:800;border-radius:20px;padding:2px 8px;margin-left:6px;letter-spacing:.03em}
.pt .edu{color:#0038AD;background:var(--tint-blue)}
.pt .gov{color:#fff;background:var(--blue)}
.pt .dr{color:var(--blue);font-weight:700}
.pt .old{color:var(--ink-2);text-decoration:line-through;font-size:12px;display:block}
.pt .now{color:var(--blue-ink);font-weight:800;font-size:15.5px}
.pt tr.hot{background:var(--tint-blue)}
.pt td:last-child{text-align:right;white-space:nowrap}
.pt .pick{background:var(--cta);color:#fff;border:0;border-radius:8px;padding:8px 16px;font-weight:700;font-size:13px;font-family:inherit;cursor:pointer}
.pt-note{font-size:13.5px;color:var(--ink-2);text-align:center;margin-top:16px}


/* TESTIMONIALS pha cach (dark spotlight) */
.tmx{position:relative;background:linear-gradient(160deg,var(--blue-ink),var(--blue-d));color:#fff;overflow:hidden;isolation:isolate}
.tmx:before{content:"\201C";position:absolute;top:-70px;left:10px;font-size:300px;font-weight:800;color:rgba(255,255,255,.05);line-height:1;font-family:Georgia,serif;z-index:-1}
.tmx-top{display:grid;grid-template-columns:1.25fr .75fr;gap:48px;align-items:center;margin-bottom:30px}
.tmx-lead .kicker{color:#7FB0FF}
.tmx-lead h2{color:#fff;font-size:30px;margin:12px 0 22px}
.tmx-quote{font-size:25px;line-height:1.42;font-weight:600;letter-spacing:-.01em;color:#EAF1FF;margin-bottom:22px}
.tmx-quote b{color:#5FD0FF;font-weight:600}
.tmx-by{display:flex;align-items:center;gap:14px}
.tmx-by .av{width:48px;height:48px;border-radius:50%;background:var(--cta);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800}
.tmx-by b{color:#fff;font-size:15px;display:block}.tmx-by span{color:#9FB2CE;font-size:13px}
.tmx-photo{position:relative;border-radius:16px;overflow:hidden;box-shadow:0 30px 56px -28px rgba(0,0,0,.6)}
.tmx-photo img{width:100%;aspect-ratio:4/3.2;object-fit:cover;object-position:center 36%}
.tmx-badge{position:absolute;left:16px;bottom:16px;background:#fff;color:var(--blue-ink);border-radius:12px;padding:9px 14px;display:flex;align-items:center;gap:8px;font-size:13px;box-shadow:0 12px 24px -12px rgba(0,0,0,.5)}
.tmx-badge b{font-size:16px}.tmx-badge .s{color:var(--cta);font-weight:800;letter-spacing:1px}
.tmx-mini{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.mini{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:14px;padding:20px;backdrop-filter:blur(3px)}
.mini .st{color:var(--cta);letter-spacing:2px;font-size:13px;margin-bottom:10px}
.mini p{color:#D4DEEE;font-size:14px;margin-bottom:14px;line-height:1.55}
.mini .who{display:flex;align-items:center;gap:10px}
.mini .av{width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,.16);color:#fff;font-weight:800;font-size:12px;display:flex;align-items:center;justify-content:center;flex:0 0 auto}
.mini .who b{color:#fff;font-size:13px;display:block}.mini .who span{color:#9FB2CE;font-size:11.5px}
@media(max-width:820px){.tmx-top{grid-template-columns:1fr;gap:26px}.tmx-mini{grid-template-columns:1fr}.tmx-quote{font-size:21px}}

</style>
</head>
<body>

<header><div class="wrap hd">
  <a class="logo" href="<?php echo esc_url( home_url( "/" ) ); ?>" style="text-decoration:none">Digi<b>com</b></a>
  <nav><a href="<?php echo esc_url( home_url( "/" ) ); ?>">Trang chủ</a><a href="<?php echo esc_url( home_url( "/dich-vu/" ) ); ?>">Dịch vụ</a><a href="<?php echo esc_url( home_url( "/bang-gia/" ) ); ?>">Bảng giá</a><a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>">Blog</a><a href="<?php echo esc_url( home_url( "/ve-digicom/" ) ); ?>">Về Digicom</a><a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>">Liên hệ</a></nav>
  <div class="hd-cta"><span class="hd-phone">0988 769 317</span><a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>" class="btn btn-primary">Nhận báo giá</a></div>
</div></header>

<div class="crumb"><div class="wrap"><a>Trang chủ</a><span>›</span><a>Dịch vụ</a><span>›</span>Mua Textlink</div></div>

<!-- 1. HERO -->
<section class="phero"><div class="wrap phero-grid">
  <div>
    <span class="kicker">Mua Textlink</span>
    <h1>Mua <em>textlink chất lượng</em>, chèn link site DR/traffic cao</h1>
    <p class="sub">Chèn link vào bài viết đã có sẵn trên site đúng chủ đề. Bạn tự chọn site theo chỉ số DR/traffic và giá — minh bạch, không mua mù.</p>
    <div class="phero-actions">
      <a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>" class="btn btn-primary">Nhận báo giá textlink</a>
      <a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>" class="btn btn-outline">Xem danh sách site</a>
    </div>
    <div class="hero-checks">
      <div class="hc">Chọn site <b>theo chỉ số</b></div>
      <div class="hc">Link <b>dofollow</b></div>
      <div class="hc">Có <b>edu / gov</b></div>
    </div>
  </div>
  <div class="picker">
    <div class="picker-top"><i class="rdot"></i><i class="rdot"></i><i class="rdot"></i><span class="rt">Chọn site đặt textlink — minh hoạ</span></div>
    <table>
      <thead><tr><th>Site</th><th>DR</th><th>Traffic</th><th>Giá/link</th><th></th></tr></thead>
      <tbody>
        <tr class="on"><td class="dom">tapchi-suckhoe.vn</td><td class="dr">DR 68</td><td>220K</td><td class="pr">450K</td><td><span class="tick">✓</span></td></tr>
        <tr><td class="dom">tin-congnghe.com</td><td class="dr">DR 54</td><td>90K</td><td class="pr">300K</td><td><span class="tick off"></span></td></tr>
        <tr class="on"><td class="dom">doanhnhan-online.vn</td><td class="dr">DR 72</td><td>310K</td><td class="pr">600K</td><td><span class="tick">✓</span></td></tr>
        <tr><td class="dom">blog-giaoduc.edu.vn</td><td class="dr">DR 61</td><td>140K</td><td class="pr">520K</td><td><span class="tick off"></span></td></tr>
        <tr class="on"><td class="dom">tapchi-bds.vn</td><td class="dr">DR 66</td><td>180K</td><td class="pr">550K</td><td><span class="tick">✓</span></td></tr>
      </tbody>
    </table>
    <div class="picker-foot"><span>Đã chọn 3 site</span><span>Tạm tính <b>1.600.000đ</b></span></div>
  </div>
</div></section>

<!-- 3b. BANG GIA FULL (trong tam trang textlink) -->
<section class="sec" style="background:var(--paper-2)"><div class="wrap">
  <div style="max-width:640px;margin-bottom:26px">
    <span class="kicker">Bảng giá</span>
    <h2 style="font-size:32px;margin:12px 0 10px">Bảng giá textlink theo chỉ số site</h2>
    <p style="color:var(--ink-2);font-size:16.5px">Giá tính theo từng link, phụ thuộc DR/traffic và loại tên miền. Bạn xem chỉ số trước, chọn site rồi mới đặt — không phí ẩn.</p>
  </div>
  <div class="pt-wrap">
    <div class="pt-bar">
      <input type="text" placeholder="Tìm theo tên site, chủ đề...">
      <span class="pchip on">Tất cả</span>
      <span class="pchip">Theo chủ đề</span>
      <span class="pchip">Edu / Gov</span>
      <span class="pchip">Bất động sản</span>
      <span class="pchip">Combo</span>
    </div>
    <div class="pt-scroll"><table class="pt">
      <thead><tr><th>Vị trí đặt link</th><th>Chỉ số</th><th>Yêu cầu</th><th>Giá / link</th><th></th></tr></thead>
      <tbody>
        <tr><td><span class="nm">Textlink site DR 40–50</span><div class="sub">Blog, tin tổng hợp</div></td><td><span class="dr">DR 45</span><div class="sub">30–80K traffic</div></td><td class="sub">Chèn bài có sẵn</td><td><span class="now">300.000đ</span></td><td><button class="pick">Đặt</button></td></tr>
        <tr><td><span class="nm">Textlink site DR 50–60</span><div class="sub">Site cùng chủ đề</div></td><td><span class="dr">DR 55</span><div class="sub">80–150K traffic</div></td><td class="sub">Chèn bài có sẵn</td><td><span class="now">400.000đ</span></td><td><button class="pick">Đặt</button></td></tr>
        <tr class="hot"><td><span class="nm">Textlink site DR 60–70</span><span class="tag edu">Phổ biến</span><div class="sub">Site uy tín, traffic tốt</div></td><td><span class="dr">DR 65</span><div class="sub">150–300K traffic</div></td><td class="sub">Chèn bài có sẵn</td><td><span class="old">650.000đ</span><span class="now">550.000đ</span></td><td><button class="pick">Đặt</button></td></tr>
        <tr><td><span class="nm">Textlink site DR 70+</span><div class="sub">Site đầu ngành</div></td><td><span class="dr">DR 75</span><div class="sub">300K+ traffic</div></td><td class="sub">Chèn bài có sẵn</td><td><span class="now">800.000đ</span></td><td><button class="pick">Đặt</button></td></tr>
        <tr><td><span class="nm">Textlink chuyên ngành</span><div class="sub">Sức khoẻ, tài chính, công nghệ...</div></td><td><span class="dr">DR 55–70</span><div class="sub">đúng lĩnh vực</div></td><td class="sub">Đúng chủ đề</td><td><span class="now">600.000đ</span></td><td><button class="pick">Đặt</button></td></tr>
        <tr><td><span class="nm">Textlink bất động sản</span><div class="sub">Site &amp; báo ngành BĐS</div></td><td><span class="dr">DR 55–70</span><div class="sub">chuyên BĐS</div></td><td class="sub">Anchor theo khu vực</td><td><span class="now">650.000đ</span></td><td><button class="pick">Đặt</button></td></tr>
        <tr><td><span class="nm">Textlink Edu</span><span class="tag edu">EDU</span><div class="sub">Tên miền .edu.vn</div></td><td><span class="dr">DR 50+</span><div class="sub">trang giáo dục</div></td><td class="sub">Theo quy định site</td><td><span class="now">900.000đ</span></td><td><button class="pick">Đặt</button></td></tr>
        <tr><td><span class="nm">Textlink Gov</span><span class="tag gov">GOV</span><div class="sub">Tên miền .gov.vn</div></td><td><span class="dr">DR 55+</span><div class="sub">trang chính phủ</div></td><td class="sub">Theo quy định site</td><td><span class="now">1.500.000đ</span></td><td><button class="pick">Đặt</button></td></tr>
        <tr><td><span class="nm">Textlink báo điện tử</span><div class="sub">VnExpress, Dân Trí, CafeF...</div></td><td><span class="dr">DR 80+</span><div class="sub">1M+ traffic</div></td><td class="sub">Chèn trong bài báo</td><td><span class="now">Liên hệ</span></td><td><button class="pick">Tư vấn</button></td></tr>
        <tr><td><span class="nm">Combo 10 textlink DR 50–60</span><div class="sub">Tiết kiệm 15%</div></td><td><span class="dr">DR 55</span><div class="sub">đa dạng chủ đề</div></td><td class="sub">Chèn bài có sẵn</td><td><span class="old">4.000.000đ</span><span class="now">3.400.000đ</span></td><td><button class="pick">Đặt</button></td></tr>
      </tbody>
    </table></div>
  </div>
  <p class="pt-note">Giá tham khảo, chưa gồm VAT. Xem toàn bộ danh sách site cập nhật &amp; đặt nhanh tại trang <a>Bảng giá</a>.</p>
</div></section>

<!-- 7. TESTIMONIALS (pha cach) -->
<section class="sec tmx"><div class="wrap">
  <div class="tmx-top">
    <div class="tmx-lead">
      <span class="kicker">Khách hàng nói gì</span>
      <h2>Người thật, kết quả thật</h2>
      <p class="tmx-quote">"Được <b>tự chọn site theo DR và traffic</b> nên tôi kiểm soát được chất lượng, không mua mù như trước. Giá từng link rõ ràng, đặt xong có báo cáo vị trí đầy đủ."</p>
      <div class="tmx-by"><span class="av">TP</span><div><b>Trưởng phòng Marketing</b><span>Đã dùng dịch vụ Mua Textlink</span></div></div>
    </div>
    <div class="tmx-photo">
      <img src="<?php echo esc_url( content_url( "/uploads/" ) ); ?>team/team-bg.png" alt="Đội ngũ Digicom">
      <div class="tmx-badge"><span class="s">★ 4.9/5</span><b></b><span style="color:var(--ink-2)">100+ khách hàng</span></div>
    </div>
  </div>
  <div class="tmx-mini">
    <div class="mini"><div class="st">★★★★★</div><p>"Cần đẩy nhanh vài từ khoá, textlink hợp ngân sách. Link vào bài có traffic thật nên lên top khá nhanh."</p><div class="who"><span class="av">CD</span><div><b>Chủ doanh nghiệp SME</b><span>Mua Textlink</span></div></div></div>
    <div class="mini"><div class="st">★★★★★</div><p>"Digicom tư vấn thẳng: từ khoá của tôi nên đi textlink trước, khi nào cần mạnh hơn mới lên hệ thống."</p><div class="who"><span class="av">GD</span><div><b>Giám đốc sàn BĐS</b><span>Textlink → Backlink</span></div></div></div>
    <div class="mini"><div class="st">★★★★★</div><p>"Danh sách site gửi trước kèm đủ chỉ số, duyệt xong mới tính tiền. Minh bạch nên yên tâm hợp tác tiếp."</p><div class="who"><span class="av">QT</span><div><b>Quản lý thương hiệu</b><span>Mua Textlink</span></div></div></div>
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
    <details open><summary>Textlink khác backlink thế nào?</summary><div class="a">Textlink là một dạng backlink cụ thể: chèn link vào bài viết đã có sẵn trên site khác. "Dịch vụ Backlink" rộng hơn — là xây cả hệ thống link đa nguồn, đa tầng. Cần đẩy nhanh vài từ khoá thì dùng textlink; cần sức mạnh bền vững thì lên hệ thống backlink.</div></details>
    <details><summary>Mua textlink có an toàn không?</summary><div class="a">An toàn khi link đặt trên site thật, đúng chủ đề, anchor tự nhiên. Digicom chỉ chọn site có DR/traffic thật, tránh site dựng lên để bán link — nên không dính rủi ro với Google.</div></details>
    <details><summary>Textlink edu/gov là gì, có nên mua không?</summary><div class="a">Là textlink đặt trên tên miền giáo dục (.edu) hoặc chính phủ (.gov) — độ tin cậy (trust) rất cao nên giá trị SEO lớn. Phù hợp khi cần tăng uy tín tổng thể cho website. Digicom có sẵn nguồn edu/gov chọn lọc.</div></details>
    <details><summary>Link đặt bao lâu, có bị gỡ không?</summary><div class="a">Link được giữ theo cam kết trong hợp đồng (thường tối thiểu 6–12 tháng, hoặc vĩnh viễn tuỳ site). Digicom báo cáo vị trí từng link để bạn kiểm tra bất cứ lúc nào.</div></details>
    <details><summary>Giá textlink bao nhiêu một link?</summary><div class="a">Từ khoảng 300.000đ/link tuỳ chỉ số site (DR, traffic) và loại tên miền (thường/edu/gov). Bạn xem giá từng site trong danh sách trước khi chọn — không có phí ẩn.</div></details>
  </div>
</div></section>

<!-- 9. CTA -->
<section class="sec" style="padding-top:0"><div class="wrap"><div class="cta">
  <div><h2>Cần danh sách site đặt textlink?</h2><p>Gửi URL và từ khoá, Digicom gửi bạn danh sách site kèm chỉ số &amp; giá trong 24 giờ.</p></div>
  <div class="acts"><a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>" class="btn btn-cta">Gọi 0988 769 317</a><a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>" class="btn btn-white">Chat Zalo</a></div>
</div></div></section>

<!-- related (chuyen len truoc phan khach hang) -->
<section class="sec"><div class="wrap">
  <div style="max-width:620px;margin-bottom:26px"><span class="kicker">Tìm hiểu thêm</span><h2 style="font-size:30px;margin-top:12px">Kiến thức textlink liên quan</h2></div>
  <div class="rel-grid">
    <div class="rel"><span class="k">Kiến thức</span><a>Textlink là gì? Phân biệt textlink và backlink →</a></div>
    <div class="rel"><span class="k">Kỹ thuật</span><a>Anchor text: cách chọn anchor an toàn, tự nhiên →</a></div>
    <div class="rel"><span class="k">Uy tín</span><a>Textlink edu/gov: vì sao link edu/gov giá trị cao →</a></div>
    <div class="rel"><span class="k">Chọn site</span><a>Đánh giá site đặt textlink qua DR, traffic, chủ đề →</a></div>
    <div class="rel"><span class="k">Nâng cấp</span><a>Dịch vụ Backlink: hệ thống đa tầng cho từ khoá khó →</a></div>
    <div class="rel"><span class="k">Dịch vụ khác</span><a>Guest Post · Booking báo &amp; PR →</a></div>
  </div>
</div></section>

<footer><div class="wrap ft-grid">
  <div><div class="logo">Digi<b style="color:var(--teal)">com</b></div><p style="max-width:26em">Chuyên Textlink, Backlink, Guest Post &amp; Booking báo PR cho doanh nghiệp và agency SEO.</p></div>
  <div><h4>Dịch vụ</h4><ul><li><a href="<?php echo esc_url( home_url( "/dich-vu/mua-textlink/" ) ); ?>">Mua Textlink</a></li><li><a href="<?php echo esc_url( home_url( "/dich-vu/dich-vu-backlink/" ) ); ?>">Dịch vụ Backlink</a></li><li><a href="<?php echo esc_url( home_url( "/dich-vu/guest-post/" ) ); ?>">Guest Post</a></li><li><a href="<?php echo esc_url( home_url( "/dich-vu/booking-bao-pr/" ) ); ?>">Booking báo &amp; PR</a></li></ul></div>
  <div><h4>Hỗ trợ</h4><ul><li><a href="<?php echo esc_url( home_url( "/bang-gia/" ) ); ?>">Bảng giá</a></li><li><a href="<?php echo esc_url( home_url( "/blog/" ) ); ?>">Blog</a></li><li><a href="<?php echo esc_url( home_url( "/lien-he/" ) ); ?>">Liên hệ</a></li></ul></div>
  <div><h4>Liên hệ</h4><ul><li>Hotline 0988 769 317</li><li>info@digicomvn.com</li><li>Gamuda Garden, Hà Nội</li></ul></div>
</div></footer>

</body>
</html>
