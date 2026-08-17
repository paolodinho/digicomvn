# Khach dang ky -> tu dong vao Google Sheet (chot 2026-08-17)

> File nguon: `wp-theme/digicom-host/inc/leads-sheet-sync.php`. Backfill:
> `wp-theme/digicom-host/tools/leads-sheet-backfill.php`.

## Co che

Moi khach dien form lien he/bao gia (`dgc_handle_lead()` trong `functions.php`) van luu CPT
`dgc_lead` + gui email nhu cu, **THEM 1 buoc**: sau 2 giay, ghi 1 dong vao Google Sheet qua
`wp_schedule_single_event` (khong chan redirect ve trang cam on).

Dung LAI service account + JWT helper (`dgc_gsc_access_token()`) cua muc Google Search Console
(`inc/gsc-sitemap-submit.php`) - chi doi `scope` sang `https://www.googleapis.com/auth/spreadsheets`.
KHONG can them file key/credential moi, chi can:
1. Bat **Google Sheets API** tren cung Google Cloud project (`digicom-price-sync`).
2. Share Sheet muon dung cho quyen **Editor** toi dung email service account
   (`search-console@digicom-price-sync.iam.gserviceaccount.com`).
3. Dien Sheet ID + bat toggle o WP Admin > DigicomVN > muc 10 (option `leads_sheet_id`, `leads_sheet_on`).

## Ly do khong dung Google Apps Script (webhook)

Thu truoc: Apps Script Web App bi Google chan luc authorize ("This app is blocked" - tai khoan
co Enhanced Safe Browsing chan app chua verify). Chuyen sang service account (da co san ha tang
tu GSC) - khong qua buoc authorize app nao, chi can share quyen file.

## Backfill du lieu cu

Chay 1 lan sau khi bat cau hinh (qua SSH, `wp eval-file`):
```bash
wp eval-file wp-content/themes/digicom-host/tools/leads-sheet-backfill.php --allow-root
```
Doc toan bo CPT `dgc_lead` (moi trang thai, ke ca private), parse lai tu `post_content`
(dinh dang co dinh: "Ho ten:\nDien thoai:\nEmail:\nDich vu:\nNoi dung:\n..."), ghi theo thu tu
thoi gian cu -> moi. Idempotent-KHONG: chay lai se ghi TRUNG - chi chay 1 lan, hoac xoa het
dong trong Sheet (giu header) truoc khi chay lai.

## QA sau khi bat

1. Dien thu 1 form that tren site -> kiem dong moi xuat hien trong Sheet (co the mat vai giay
   do do tre 2s + WP-Cron).
2. Neu khong thay dong nao: kiem `error_log` host (loi hay gap: chua bat Sheets API, chua share
   dung email, sai Sheet ID, quota Google API).

## Lien quan
- `gsc-sitemap-submit.md` - service account + JWT helper dung chung, cac cam bay ky thuat da gap
  (PUT thieu Content-Length, quyen Owner...) co the lap lai o Sheets API neu doi endpoint.
- `deploy.md` - quy trinh deploy file PHP moi len live (khong can bump DGC_VER vi khong dung
  CSS/JS).
