<?php
/**
 * Luoi bang gia dang "Excel" (cuon ao) cho /bang-gia/ - thay bang HTML day (2168 <tr>,
 * 4,6MB) bang 1 goi JSON nhe + JS chi ve ~30 dong dang trong khung nhin (Hieu 2026-08-01:
 * "so luong du lieu qua lon hien thi kieu nay thi ko an thua, bi nang may va ko nhin duoc
 * tong quan"). Tai su dung TOAN BO helper du lieu/gia cu (dgc_gia_specs, dgc_gia_price_tiers,
 * dgc_gia_la_goi, dgc_gia_goi_chi_tiet, dgc_gia_intro_rows, dgc_line_mkgain...) trong
 * cpt-gia.php - file nay CHI la lop trinh bay moi, khong doi logic tinh gia/chiet khau.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Gom $items (da duoc dgc_get_gia() gom theo ten bao) thanh danh sach GON cho luoi:
 * moi phan tu la 1 "bao/site" - co the la 1 dong le (count=1, gia/nut chon co san luon,
 * khong can mo rong) hoac 1 nhom nhieu vi tri (count>1, phai bam mo rong moi thay gia/nut
 * chon tung vi tri - dung AJAX dgc_grid_detail de lay noi dung, xem duoi).
 */
function dgc_gia_grid_rows( $items, $args ) {
	$out = array();
	$n   = count( $items );
	$i   = 0;
	while ( $i < $n ) {
		$key = dgc_search_key( $items[ $i ]->post_title );
		$j   = $i + 1;
		while ( $j < $n && dgc_search_key( $items[ $j ]->post_title ) === $key ) $j++;
		$group_size = $j - $i;

		$first = $items[ $i ];
		$m     = $first->meta;
		$fc    = dgc_gia_facets( $m );
		$row   = array(
			'id'     => (int) $first->ID,
			'key'    => $key,
			'name'   => $first->post_title,
			'url'    => $m['url_bao'] ?: '',
			'nganh'  => dgc_gia_nganh_tags( $m['nganh'] ?? '' ),
			'noiBat' => ( '1' === ( $m['noi_bat'] ?? '' ) ),
			'link'   => $fc['link'],
			'anh'    => (int) $fc['anh'],
			'tu'     => (int) $fc['tu'],
			'vitri'  => $fc['vitri'],
			'count'  => $group_size,
		);

		if ( $group_size > 1 ) {
			$prices = array();
			$dr_max = 0;
			$ids    = array();
			for ( $k = $i; $k < $j; $k++ ) {
				$p = dgc_gia_to_number( $items[ $k ]->meta['gia_km'] ?? '' );
				if ( $p > 0 ) $prices[] = $p;
				$dr_max = max( $dr_max, (int) ( $items[ $k ]->meta['dr'] ?? 0 ) );
				$ids[]  = (int) $items[ $k ]->ID;
			}
			$row['dr']       = $dr_max;
			$row['priceMin'] = $prices ? min( $prices ) : 0;
			$row['priceMax'] = $prices ? max( $prices ) : 0;
			$row['childIds'] = $ids;
		} else {
			$gia_km    = $m['gia_km'] ?? '';
			$price_num = dgc_gia_to_number( $gia_km );
			$tiers     = dgc_gia_price_tiers( $gia_km );
			if ( $tiers ) {
				$all       = array_merge( ...array_column( $tiers, 'values' ) );
				$price_num = min( $all );
			}
			$row['dr']       = (int) ( $m['dr'] ?? 0 );
			$row['priceMin'] = $price_num;
			$row['priceMax'] = $price_num;
			$row['price']    = $price_num;
			$row['isTier']   = (bool) $tiers;
			$row['mkgain']   = (int) dgc_line_mkgain( $price_num, $m['ma_ncc'] ?? '' );
			$row['label']    = $first->post_title . ' (' . $args['ctx'] . ')';
			$row['isGoi']    = dgc_gia_la_goi( $first->post_title, $args['nhom_slug'] );
		}

		$out[] = $row;
		$i     = $j;
	}
	return $out;
}

/**
 * 1 khoi chi tiet (quy cach + gia + nut chon) cho DUNG 1 dong gia - dung trong panel "mo rong"
 * cua luoi (thay the noi dung <td> day du cua bang cu). $is_child: co dang hien ten vi tri
 * rieng khong (dong con trong 1 nhom nhieu vi tri) hay an (dong le, ten da hien o hang luoi).
 */
function dgc_gia_detail_block_html( $it, $args, $is_child ) {
	$m         = $it->meta;
	$slug      = $args['nhom_slug'];
	$gia_km    = $m['gia_km'] ?? '';
	$vi_tri    = trim( (string) ( $m['vi_tri'] ?? '' ) );
	$show_pos  = ( 'mua-textlink' !== $slug && $vi_tri !== '' );
	$specs     = dgc_gia_specs( $m );
	$tiers     = dgc_gia_price_tiers( $gia_km );
	$tier_terms = $tiers ? dgc_gia_tier_terms( $vi_tri, count( $tiers[0]['values'] ) ) : array();
	$price_num = dgc_gia_to_number( $gia_km );
	if ( $tiers ) {
		$all       = array_merge( ...array_column( $tiers, 'values' ) );
		$price_num = min( $all );
	}
	$mkgain = dgc_line_mkgain( $price_num, $m['ma_ncc'] ?? '' );
	$label  = $it->post_title . ' (' . $args['ctx'] . ')';
	$is_goi = dgc_gia_la_goi( $it->post_title, $slug );
	$st     = dgc_gia_search_terms( $it->post_title, $vi_tri );

	ob_start(); ?>
	<div class="gd-item">
		<div class="gd-item-top">
			<?php if ( $is_child ) : ?><span class="gd-item-name"><?php echo esc_html( $vi_tri !== '' ? $vi_tri : $it->post_title ); ?></span><?php endif; ?>
			<div class="gd-specs">
				<?php if ( $show_pos ) : ?><span class="spec-chip spec-chip-pos"><?php echo esc_html( $vi_tri ); ?><?php echo dgc_gia_vitri_button_html( $it ); ?></span><?php echo dgc_gia_vitri_detail_html( $it ); ?><?php endif; ?>
				<?php foreach ( $specs as $sp ) : ?><span class="spec-chip"><?php echo esc_html( $sp ); ?></span><?php endforeach; ?>
				<?php if ( ! $show_pos && ! $specs && ! $tiers ) : ?><span class="spec-empty">Liên hệ để nhận quy cách chi tiết</span><?php endif; ?>
			</div>
		</div>
		<?php if ( $is_goi ) : $ct = dgc_gia_goi_chi_tiet( $m ); if ( $ct ) : ?>
		<div class="gd-pkg"><ul>
			<?php foreach ( $ct as $row ) : ?><li><span class="pkg-k"><?php echo esc_html( $row[0] ); ?></span><span class="pkg-v"><?php echo esc_html( $row[1] ); ?></span></li><?php endforeach; ?>
		</ul></div>
		<?php $sites = dgc_gia_goi_sites( $m ); if ( $sites ) : ?>
		<div class="pkg-sites">
			<div class="pkg-sites-head"><span>Site trong gói</span><span>DR/DA</span></div>
			<?php foreach ( $sites as $ps ) : ?>
			<div class="pkg-site-row"><span class="pkg-site-name"><?php echo esc_html( $ps['name'] ); ?><?php if ( $ps['note'] !== '' ) : ?> <em class="pkg-site-note"><?php echo esc_html( $ps['note'] ); ?></em><?php endif; ?></span><span class="pkg-site-dr"><?php echo $ps['dr'] !== '' ? esc_html( $ps['dr'] ) : '-'; ?></span></div>
			<?php endforeach; ?>
		</div>
		<?php endif; endif; endif; ?>
		<?php if ( $tiers ) : ?>
		<table class="tier-table">
			<?php if ( $tier_terms ) : ?><thead><tr><th>Vị trí</th><?php foreach ( $tier_terms as $t ) : ?><th><?php echo esc_html( $t ); ?></th><?php endforeach; ?></tr></thead><?php endif; ?>
			<tbody>
			<?php foreach ( $tiers as $row ) : ?>
				<tr><th><?php echo esc_html( $row['label'] ); ?></th><?php foreach ( $row['values'] as $vi => $v ) : ?><td data-term="<?php echo esc_attr( $tier_terms[ $vi ] ?? '' ); ?>"><?php echo esc_html( number_format( $v, 0, ',', '.' ) . 'đ' ); ?></td><?php endforeach; ?></tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php endif; ?>
		<div class="gd-item-bot">
			<span class="gd-price"><?php echo $tiers ? 'Từ ' . esc_html( number_format( $price_num, 0, ',', '.' ) . 'đ' ) : esc_html( dgc_format_price( $gia_km ) ); ?></span>
			<button type="button" class="btn btn-ghost btn-sm grid-pick" data-key="<?php echo esc_attr( $st['key'] ); ?>" data-price="<?php echo esc_attr( $price_num ); ?>" data-mkgain="<?php echo (int) $mkgain; ?>" data-label="<?php echo esc_attr( $label ); ?>">
				<span class="pick-add">+ Chọn <?php echo esc_html( dgc_nhom_don_vi( $slug ) ); ?> này</span>
				<span class="pick-on">Đã chọn</span>
			</button>
		</div>
	</div>
	<?php
	return ob_get_clean();
}

/** Toan bo panel "mo rong" cua 1 bao/site: gioi thieu (neu khong phai goi) + 1 hoac nhieu khoi chi tiet. */
function dgc_gia_grid_detail_html( $head_it, $child_items, $args ) {
	$slug = $args['nhom_slug'];
	ob_start();
	if ( ! dgc_gia_la_goi( $head_it->post_title, $slug ) ) {
		$intro = dgc_gia_intro_rows( $head_it, $slug );
		if ( $intro ) : ?>
		<div class="gd-intro"><ul>
		<?php foreach ( $intro as $ir ) : ?><li><span class="intro-k"><?php echo esc_html( $ir[0] ); ?></span><span class="intro-v"><?php echo esc_html( $ir[1] ); ?></span></li><?php endforeach; ?>
		</ul></div>
		<?php endif;
	}
	if ( count( $child_items ) > 1 ) {
		foreach ( $child_items as $ci ) echo dgc_gia_detail_block_html( $ci, $args, true );
	} else {
		echo dgc_gia_detail_block_html( $child_items[0], $args, false );
	}
	return ob_get_clean();
}

/**
 * AJAX: tra ve HTML panel chi tiet cho 1 bao/site cu the (bam mo rong tren luoi).
 * Nhe (chi tinh khi nguoi dung THAT SU can xem, khong tinh san cho ca 850 dong).
 */
function dgc_grid_detail_ajax() {
	check_ajax_referer( 'dgc_grid', 'nonce' );

	$nhom     = isset( $_POST['nhom'] ) ? sanitize_title( wp_unslash( $_POST['nhom'] ) ) : '';
	$ids_raw  = isset( $_POST['ids'] ) ? sanitize_text_field( wp_unslash( $_POST['ids'] ) ) : '';
	$ctx      = isset( $_POST['ctx'] ) ? sanitize_text_field( wp_unslash( $_POST['ctx'] ) ) : '';
	$col_name = isset( $_POST['col_name'] ) ? sanitize_text_field( wp_unslash( $_POST['col_name'] ) ) : 'Tên báo / site';
	$ids      = array_filter( array_map( 'intval', explode( ',', $ids_raw ) ) );

	if ( ! $nhom || ! $ids ) wp_send_json_error( array( 'msg' => 'missing_params' ) );

	$items = array();
	foreach ( $ids as $id ) {
		$p = get_post( $id );
		if ( ! $p || 'dgc_gia' !== $p->post_type || 'publish' !== $p->post_status ) continue;
		$meta = array();
		foreach ( array_keys( dgc_gia_meta_fields() ) as $key ) { $meta[ $key ] = get_post_meta( $id, $key, true ); }
		$p->meta = $meta;
		$items[] = $p;
	}
	if ( ! $items ) wp_send_json_error( array( 'msg' => 'not_found' ) );

	$args = array( 'nhom_slug' => $nhom, 'ctx' => $ctx, 'col_name' => $col_name );
	wp_send_json_success( array( 'html' => dgc_gia_grid_detail_html( $items[0], $items, $args ) ) );
}
add_action( 'wp_ajax_dgc_grid_detail', 'dgc_grid_detail_ajax' );
add_action( 'wp_ajax_nopriv_dgc_grid_detail', 'dgc_grid_detail_ajax' );
