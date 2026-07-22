/**
 * Digicom - Tao bao gia Google Sheet tu xa.
 * Dan file nay vao script.google.com > Deploy > Web app (Execute as: Me, Access: Anyone).
 * Sau do copy URL /exec vao tools/bao-gia/config.json (khoa "webapp_url").
 *
 * Bao mat: URL /exec la cong khai -> BAT BUOC dat TOKEN rieng ben duoi va giu bi mat.
 */

// ==== SUA 2 DONG NAY ====
var TOKEN     = 'doi-chuoi-nay-thanh-mat-khau-rieng-cua-ban';
var FOLDER_ID = '1bfsrfmfed9bTPq2iuEyo9qBrRI1Fdenx'; // Thu muc Drive goc luu bao gia.
// ========================

function doPost(e) {
  try {
    var d = JSON.parse(e.postData.contents);
    if (d.token !== TOKEN) return out({ ok: false, error: 'Sai token' });

    var ss    = SpreadsheetApp.create(d.ten_file || 'Bao gia Digicom');
    var sheet = ss.getSheets()[0].setName('Bao gia');
    var file  = DriveApp.getFileById(ss.getId());

    // ---- Xep vao thu muc Drive theo cay: <goc>/<PIC>/<loai san pham> ----
    var root   = FOLDER_ID ? DriveApp.getFolderById(FOLDER_ID) : DriveApp.getRootFolder();
    var folder = root;
    if (d.pic)  folder = ensureFolder(folder, String(d.pic));
    if (d.loai) folder = ensureFolder(folder, String(d.loai));
    if (folder.getId() !== DriveApp.getRootFolder().getId()) {
      folder.addFile(file);
      DriveApp.getRootFolder().removeFile(file); // go khoi My Drive goc (create() mac dinh de o day)
    }
    file.setSharing(DriveApp.Access.ANYONE_WITH_LINK, DriveApp.Permission.VIEW);

    var brand = d.brand || {};
    var cols  = d.cols  || [];
    var rows  = d.rows  || [];
    var nCol  = cols.length;

    // ---- Header thuong hieu ----
    var head = [
      [brand.cong_ty || 'DIGICOM'],
      [d.tieu_de || 'BAO GIA DICH VU TRUYEN THONG'],
      [brand.dong_lien_he || ''],
      [d.dong_hieu_luc || '']
    ];
    head.forEach(function (r, i) {
      sheet.getRange(i + 1, 1, 1, nCol).merge().setValue(r[0]);
    });
    sheet.getRange('A1').setFontSize(18).setFontWeight('bold').setFontColor('#0B5FD6');
    sheet.getRange('A2').setFontSize(13).setFontWeight('bold').setFontColor('#1C2035');
    sheet.getRange('A3:A4').setFontSize(10).setFontColor('#5A6472');
    sheet.getRange(1, 1, 4, nCol).setHorizontalAlignment('center')
         .setVerticalAlignment('middle').setBackground('#F4F8FF');
    sheet.setRowHeights(1, 4, 26);

    // ---- Bang du lieu ----
    var r0 = 6;
    sheet.getRange(r0, 1, 1, nCol).setValues([cols])
         .setBackground('#0B5FD6').setFontColor('#FFFFFF')
         .setFontWeight('bold').setVerticalAlignment('middle')
         .setWrap(true).setHorizontalAlignment('center');
    sheet.setRowHeight(r0, 34);

    if (rows.length) {
      sheet.getRange(r0 + 1, 1, rows.length, nCol).setValues(rows).setVerticalAlignment('middle');
    }

    var giaCol = cols.indexOf('Giá (VNĐ)') + 1;
    var last   = r0 + rows.length;

    if (giaCol > 0 && rows.length) {
      sheet.getRange(r0 + 1, giaCol, rows.length, 1)
           .setNumberFormat('#,##0').setHorizontalAlignment('right');
      // Dong tong
      var t = last + 1;
      sheet.getRange(t, 1, 1, Math.max(1, giaCol - 1)).merge()
           .setValue('TỔNG CỘNG (chưa gồm VAT 8%)')
           .setHorizontalAlignment('right').setFontWeight('bold');
      sheet.getRange(t, giaCol)
           .setFormula('=SUM(' + colLetter(giaCol) + (r0 + 1) + ':' + colLetter(giaCol) + last + ')')
           .setNumberFormat('#,##0').setFontWeight('bold');
      sheet.getRange(t, 1, 1, nCol).setBackground('#FFF3E6');
      last = t;
    }

    sheet.getRange(r0, 1, last - r0 + 1, nCol)
         .setBorder(true, true, true, true, true, true, '#D9DEE6', SpreadsheetApp.BorderStyle.SOLID);

    // Ghi chu cuoi
    if (d.ghi_chu) {
      var g = last + 2;
      sheet.getRange(g, 1, 1, nCol).merge().setValue(d.ghi_chu)
           .setWrap(true).setFontSize(10).setFontColor('#5A6472')
           .setVerticalAlignment('top');
      sheet.setRowHeight(g, 60);
    }

    (d.widths || []).forEach(function (w, i) { sheet.setColumnWidth(i + 1, w); });
    sheet.setFrozenRows(r0);
    if (rows.length) sheet.getRange(r0, 1, rows.length + 1, nCol).createFilter();

    return out({ ok: true, url: ss.getUrl(), id: ss.getId() });
  } catch (err) {
    return out({ ok: false, error: String(err) });
  }
}

function ensureFolder(parent, name) {
  var it = parent.getFoldersByName(name);
  return it.hasNext() ? it.next() : parent.createFolder(name);
}

function colLetter(n) {
  var s = '';
  while (n > 0) { var m = (n - 1) % 26; s = String.fromCharCode(65 + m) + s; n = (n - m - 1) / 26; }
  return s;
}

function out(obj) {
  return ContentService.createTextOutput(JSON.stringify(obj))
                       .setMimeType(ContentService.MimeType.JSON);
}
