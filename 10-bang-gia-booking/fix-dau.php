<?php
/**
 * Sua tieng Viet KHONG DAU thanh CO DAU cho cac ban ghi dgc_gia moi import.
 * Chay: wp eval-file fix-dau.php [dry]
 *
 * Ly do: du lieu boc tu nhieu nguon duoc chuan hoa ve ASCII khi xu ly -> chu hien thi
 * cho khach bi mat dau. Day la be mat thuong hieu, phai dung chinh ta.
 */
$args = $args ?? array();
$dry  = in_array( 'dry', $args, true );

/* Cum dai sua truoc, cum ngan sua sau (thu tu quan trong) */
$map = array(
	// Vi tri / tang san pham
	'Vi tri noi bat trang chu'      => 'Vị trí nổi bật trang chủ',
	'Bai PR chuyen muc'             => 'Bài PR chuyên mục',
	'Bai PR nofollow'               => 'Bài PR (link nofollow)',
	'Bai PR dofollow'               => 'Bài PR (link dofollow)',
	'Bai PR gia re'                 => 'Bài PR (nhóm tiết kiệm)',
	'Bai PR link dofollow'          => 'Bài PR (link dofollow)',
	'Bai dang tren site nuoc ngoai' => 'Bài đăng trên site quốc tế',
	'Bai dang tren site'            => 'Bài đăng trên site',
	'Chuyen muc phu hop'            => 'Chuyên mục phù hợp',
	'Tieu muc phu hop'              => 'Tiểu mục phù hợp',
	'Muc phu hop'                   => 'Mục phù hợp',
	'Chuyen muc Doanh nghiep'       => 'Chuyên mục Doanh nghiệp',
	'Thong tin doanh nghiep'        => 'Thông tin doanh nghiệp',
	'Tin doanh nghiep'              => 'Tin doanh nghiệp',
	'Muc tieu dung'                 => 'Mục tiêu dùng',
	'Muc can biet'                  => 'Mục cần biết',
	'PR can biet'                   => 'PR cần biết',
	'Trang chuyen muc'              => 'Trang chuyên mục',
	'Bai trong chuyen muc'          => 'Bài trong chuyên mục',
	'Bai tren trang chu'            => 'Bài trên trang chủ',
	'Bai trang chu 1 ngay'          => 'Bài trang chủ 1 ngày',
	'Bai loai'                      => 'Bài loại',
	'Trang chu'                     => 'Trang chủ',
	'Tieu muc'                      => 'Tiểu mục',
	'Chuyen muc'                    => 'Chuyên mục',
	'Bai dac biet'                  => 'Bài đặc biệt',
	'Dac biet'                      => 'Đặc biệt',
	'Noi bat'                       => 'Nổi bật',
	'noi bat'                       => 'nổi bật',
	'Tieu diem'                     => 'Tiêu điểm',
	'Bai hot'                       => 'Bài hot',
	'ton tai'                       => 'tồn tại',
	'theo domain'                   => 'theo domain',
	// Toplist
	'Toplist - thue vi tri'         => 'Toplist - thuê vị trí',
	'Toplist - dang bai'            => 'Toplist - đăng bài',
	'Goi Dia phuong'                => 'Gói Địa phương',
	'Goi Toan quoc'                 => 'Gói Toàn quốc',
	'Goi Cao cap'                   => 'Gói Cao cấp',
	'nganh suc khoe'                => 'ngành sức khỏe',
	'nganh khac'                    => 'ngành khác',
	'Toplist tinh / quan huyen'     => 'Toplist tỉnh / quận huyện',
	'He thong site toplist'         => 'Hệ thống site toplist',
	'Site toplist doi tac'          => 'Site toplist đối tác',
	'Blog/website traffic trung binh' => 'Blog / website traffic trung bình',
	'Website authority cao'         => 'Website authority cao',
	'Bai moi (khach gui content)'   => 'Bài mới (khách gửi nội dung)',
	'Bai moi (nganh thuong)'        => 'Bài mới (ngành thường)',
	'Chen vao bai toplist co san'   => 'Chèn vào bài toplist có sẵn',
	'goi Nang cao'                  => 'gói Nâng cao',
	'goi Co ban'                    => 'gói Cơ bản',
	'theo thang'                    => 'theo tháng',
	'theo nam'                      => 'theo năm',
	'12 thang'                      => '12 tháng',
	'site local'                    => 'site địa phương',
	// Textlink
	'Textlink home'                 => 'Textlink trang chủ',
	'Textlink bai'                  => 'Textlink trong bài',
	'Link trang chu'                => 'Link trang chủ',
	'Link chuyen muc'               => 'Link chuyên mục',
	'Trang chu/chuyen muc'          => 'Trang chủ / chuyên mục',
	'Trong bai viet'                => 'Trong bài viết',
	'Top menu'                      => 'Top menu',
	'Footer all page'               => 'Footer all-page',
	'Sidebar bai viet'              => 'Sidebar bài viết',
	'3 thang'                       => '3 tháng',
	'6 thang'                       => '6 tháng',
	'thang'                         => 'tháng',
	// Quy cach / so link
	'link dofollow'                 => 'link dofollow',
	'khong chen link'               => 'không chèn link',
	'Khong chen link'               => 'Không chèn link',
	'them link'                     => 'thêm link',
	'toi da'                        => 'tối đa',
	'Toi da'                        => 'Tối đa',
	'duoi'                          => 'dưới',
	'tu, '                          => 'từ, ',
	'Gia/thang'                     => 'Giá theo tháng',
	'Gia/nam'                       => 'Giá theo năm',
	'Vinh vien'                     => 'Vĩnh viễn',
	'vinh vien'                     => 'vĩnh viễn',
	'Giu vinh vien'                 => 'Giữ vĩnh viễn',
	'Gia tron goi'                  => 'Giá trọn gói',
	'Bai PR'                        => 'Bài PR',
	'Goi'                           => 'Gói',
	'anh'                           => 'ảnh',
	'tu '                           => 'từ ',
);

$fields = array( 'vi_tri', 'so_link', 'yeu_cau' );
$n = 0; $samples = array();

foreach ( get_posts( array( 'post_type' => 'dgc_gia', 'numberposts' => -1, 'post_status' => 'any' ) ) as $p ) {
	$changed = false;
	foreach ( $fields as $f ) {
		$v = (string) get_post_meta( $p->ID, $f, true );
		if ( $v === '' ) continue;
		/* Chi sua dong KHONG DAU (dong da co dau la du lieu goc, khong dung toi) */
		if ( preg_match( '/[àáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ]/u', $v ) ) continue;
		$new = strtr( $v, $map );
		if ( $new !== $v ) {
			if ( ! $dry ) update_post_meta( $p->ID, $f, $new );
			if ( count( $samples ) < 12 && $f === 'vi_tri' ) $samples[] = "$v  ->  $new";
			$changed = true;
		}
	}
	if ( $changed ) $n++;
}

WP_CLI::log( sprintf( '%s Da sua %d ban ghi', $dry ? '[DRY RUN]' : '[DA GHI]', $n ) );
foreach ( $samples as $s ) WP_CLI::log( '  ' . $s );
