<?php
/**
 * Muc luc (TOC) bai viet - tu dong quet H2/H3, chen id, hien hop muc luc dau bai
 * + nut noi theo khi cuon xuong (mobile-first, jump nhanh giua cac phan).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$GLOBALS['dgc_toc_items'] = array();

function dgc_toc_slugify( $text, &$used ) {
	$slug = sanitize_title( wp_strip_all_tags( $text ) );
	if ( '' === $slug ) $slug = 'muc';
	$base = $slug;
	$i = 2;
	while ( isset( $used[ $slug ] ) ) {
		$slug = $base . '-' . $i;
		$i++;
	}
	$used[ $slug ] = true;
	return $slug;
}

function dgc_toc_process( $content ) {
	if ( is_admin() || ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	if ( false === strpos( $content, '<h2' ) && false === strpos( $content, '<h3' ) ) {
		return $content;
	}

	// Xoa muc luc cu viet cung trong content (neu bai da co san TOC thu cong) - tranh trung 2 muc luc.
	$content = preg_replace( '/<!--\s*Table of Contents\s*-->\s*<div\b[^>]*>.*?<\/div>\s*/is', '', $content, 1 );

	$used  = array();
	$items = array();

	$content = preg_replace_callback(
		'/<h([23])([^>]*)>(.*?)<\/h\1>/is',
		function ( $m ) use ( &$used, &$items ) {
			$level = (int) $m[1];
			$attrs = $m[2];
			$inner = $m[3];
			$label = trim( wp_strip_all_tags( $inner ) );
			if ( '' === $label ) {
				return $m[0];
			}
			if ( preg_match( '/\bid=("|\')(.*?)\1/i', $attrs, $idm ) ) {
				$slug = $idm[2];
				$used[ $slug ] = true;
			} else {
				$slug   = dgc_toc_slugify( $label, $used );
				$attrs .= ' id="' . esc_attr( $slug ) . '"';
			}
			$items[] = array( 'level' => $level, 'label' => $label, 'id' => $slug );
			return '<h' . $level . $attrs . '>' . $inner . '</h' . $level . '>';
		},
		$content
	);

	if ( count( $items ) < 3 ) {
		return $content;
	}

	$GLOBALS['dgc_toc_items'] = $items;

	$toc_html      = dgc_toc_render_inline( $items );
	// Tam an "So do bai viet" toan site theo yeu cau Hieu 2026-08-07 - giu ham
	// dgc_toc_render_mindmap() nguyen ven de bat lai sau, chi khong goi no o day.
	$entity_html   = dgc_entity_render( get_the_ID(), $content );
	$toc_html     .= $entity_html;

	// Uu tien chen sau khoi "Tom tat noi dung chinh" (div class co "summary") neu bai co khoi nay,
	// vi khoi nay luon dat truoc H2 dau tien. Khong co thi chen ngay sau H1 (fallback).
	$insert_at = null;
	if ( preg_match( '/<div\b[^>]*\bclass="[^"]*\bsummary\b[^"]*"[^>]*>/i', $content, $sm, PREG_OFFSET_CAPTURE ) ) {
		// Khoi summary co the co div long ben trong (vd wp-block-group__inner-container) - phai
		// dem cap div de tim dung div dong NGOAI CUNG, khong dung ".*?<\/div>" (chi bat div con dau tien).
		$pos   = $sm[0][1] + strlen( $sm[0][0] );
		$depth = 1;
		while ( $depth > 0 && preg_match( '/<div\b[^>]*>|<\/div>/i', $content, $tm, PREG_OFFSET_CAPTURE, $pos ) ) {
			$pos = $tm[0][1] + strlen( $tm[0][0] );
			$depth += ( stripos( $tm[0][0], '</div>' ) === 0 ) ? -1 : 1;
		}
		if ( 0 === $depth ) {
			$insert_at = $pos;
		}
	}
	if ( null === $insert_at && preg_match( '/<h1\b[^>]*>.*?<\/h1>/is', $content, $h1m, PREG_OFFSET_CAPTURE ) ) {
		$insert_at = $h1m[0][1] + strlen( $h1m[0][0] );
	}

	if ( null !== $insert_at ) {
		$content = substr( $content, 0, $insert_at ) . $toc_html . substr( $content, $insert_at );
	} else {
		$content = $toc_html . $content;
	}

	return $content;
}
add_filter( 'the_content', 'dgc_toc_process', 9 );

function dgc_toc_render_inline( $items ) {
	ob_start();
	?>
	<nav class="post-toc" id="postToc" aria-label="Mục lục bài viết">
		<details>
			<summary class="post-toc__head">
				<span class="post-toc__icon" aria-hidden="true">
					<svg width="17" height="17" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
				</span>
				Mục lục
			</summary>
			<ol class="post-toc__list">
				<?php foreach ( $items as $it ) : ?>
					<li class="post-toc__item post-toc__item--h<?php echo (int) $it['level']; ?>">
						<a href="#<?php echo esc_attr( $it['id'] ); ?>" data-toc-link data-toc-id="<?php echo esc_attr( $it['id'] ); ?>"><?php echo esc_html( $it['label'] ); ?></a>
					</li>
				<?php endforeach; ?>
			</ol>
		</details>
	</nav>
	<?php
	return ob_get_clean();
}

/**
 * Ban render cho cot phai (desktop >=1240px) - luon mo san, khong boc trong <details>.
 * Dung lai cung class .post-toc__list/.post-toc__item de an theo CSS + scroll-spy da co.
 */
function dgc_toc_render_sidebar( $items ) {
	if ( empty( $items ) ) return;
	?>
	<div class="post-side-left">
		<div class="post-toc-side__head">
			<span class="post-toc__icon" aria-hidden="true">
				<svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
			</span>
			Mục lục
		</div>
		<ol class="post-toc__list post-toc-side__list">
			<?php foreach ( $items as $it ) : ?>
				<li class="post-toc__item post-toc__item--h<?php echo (int) $it['level']; ?>">
					<a href="#<?php echo esc_attr( $it['id'] ); ?>" data-toc-link data-toc-id="<?php echo esc_attr( $it['id'] ); ?>"><?php echo esc_html( $it['label'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
	<?php
}

/**
 * Lay toan bo doan van cua 1 muc (tu sau heading toi heading H2/H3 tiep theo), da bo
 * tag/shortcode, dung lam nguyen lieu cho dgc_toc_key_idea(). KHONG bia - chi la buoc
 * cat doan van that trong bai, chua xu ly chon cau.
 */
function dgc_toc_section_text( $content, $id, $cap = 900 ) {
	$pos = strpos( $content, 'id="' . $id . '"' );
	if ( false === $pos ) return '';
	$close = strpos( $content, '>', $pos );
	if ( false === $close ) return '';
	$after = substr( $content, $close + 1 );
	if ( preg_match( '/<\/h[23]>/i', $after, $hm, PREG_OFFSET_CAPTURE ) ) {
		$after = substr( $after, $hm[0][1] + strlen( $hm[0][0] ) );
	}
	$cut = preg_match( '/<h[23]\b/i', $after, $nm, PREG_OFFSET_CAPTURE ) ? $nm[0][1] : $cap;
	$text = trim( wp_strip_all_tags( substr( $after, 0, min( $cut, $cap ) ) ) );
	// Bo cu phap shortcode ([dgc_offpage_quiz], [dgc_budget_calc]...) - dgc_toc_process chay
	// TRUOC do_shortcode (priority 9 < 11), nen shortcode con nguyen dang text luc nay. Neu
	// khong bo, do_shortcode se bung no ca widget ngay trong the nhanh mindmap o lan quet sau.
	$text = preg_replace( '/\[[^\[\]]*\]/', '', $text );
	return trim( preg_replace( '/\s+/', ' ', $text ) );
}

/**
 * Rut Y CHINH cua 1 muc (KHONG lap lai chu trong tieu de H2 - Hieu phan hoi 2026-08-05:
 * nhanh cay bi trung thong tin voi Muc luc). Cach lam: tach doan van thanh cac cau, CHAM
 * DIEM tung cau that (khong bia cau moi):
 *  +3  co so lieu/con so cu the (de "rut ra y chinh" thay vi cau dan nhap chung chung)
 *  +2  do dai vua phai (40-150 ky tu) - qua ngan/qua dai kem tu nhien khi hien the nho
 *  -2 x ty le trung tu voi tieu de H2 - cang trung nhieu chu voi tieu de cang bi tru diem,
 *      buoc phai chon cau THEM THONG TIN thay vi cau nhac lai y tieu de.
 * Cau diem cao nhat thang. Khong cau nao du dieu kien -> fallback cau dau tien (van la that,
 * chi la khong toi uu). Chi xet 8 cau dau cua muc de bam sat dung chu de, khong troi xa.
 */
function dgc_toc_key_idea( $content, $id, $heading_label, $max = 90 ) {
	$text = dgc_toc_section_text( $content, $id );
	if ( '' === $text ) return '';

	$sentences = preg_split( '/(?<=[\.\!\?…])\s+(?=[A-ZÀ-Ỵ0-9])/u', $text );
	if ( ! is_array( $sentences ) || empty( $sentences ) ) $sentences = array( $text );
	$sentences = array_slice( $sentences, 0, 8 );

	$heading_words = array_filter( preg_split( '/\s+/u', mb_strtolower( wp_strip_all_tags( $heading_label ) ) ), function ( $w ) {
		return function_exists( 'mb_strlen' ) ? mb_strlen( $w ) >= 3 : strlen( $w ) >= 3;
	} );
	$heading_count = count( $heading_words );

	$best = '';
	$best_score = -PHP_INT_MAX;
	foreach ( $sentences as $s ) {
		$s = trim( $s );
		$len = function_exists( 'mb_strlen' ) ? mb_strlen( $s ) : strlen( $s );
		if ( $len < 15 ) continue;

		$score = 0;
		if ( preg_match( '/\d/', $s ) ) $score += 3;
		if ( $len >= 40 && $len <= 150 ) {
			$score += 2;
		} elseif ( $len > 220 ) {
			$score -= 1;
		}
		if ( $heading_count > 0 ) {
			$s_low   = mb_strtolower( $s );
			$overlap = 0;
			foreach ( $heading_words as $w ) {
				if ( false !== mb_strpos( $s_low, $w ) ) $overlap++;
			}
			$score -= 2 * ( $overlap / $heading_count );
		}

		if ( $score > $best_score ) {
			$best_score = $score;
			$best       = $s;
		}
	}
	if ( '' === $best ) $best = trim( $sentences[0] );
	if ( '' === $best ) return '';

	if ( function_exists( 'mb_strlen' ) && mb_strlen( $best ) > $max ) {
		$best = rtrim( mb_substr( $best, 0, $max ) ) . '...';
	}
	return $best;
}

/**
 * Mindmap dang LUOI THE GON (khong con xep doc thanh 1 cot dai - Hieu phan hoi 2026-08-05
 * lan 2: ban cay doc/ngang truoc do "ton dien tich, kho xem" vi moi nhanh la 1 the day du
 * cao ~100px, bai nhieu muc la keo dai vo han). Cach lam moi:
 *  - The H2 xep thanh LUOI nhieu cot (CSS grid tu dong xuong dong), khong con 1 cot doc.
 *  - Y chinh trong the GIOI HAN 3 DONG (line-clamp) - the luon cao co dinh du bai dai/ngan.
 *  - Nhanh con (H3) KHONG con la the rieng chiem 1 dong - don thanh CHIP nho nam ngang
 *    trong cung the H2 cha, chi hien TEN MUC (khong keo theo y chinh rieng) de giu gon.
 * Van khac ro voi Muc luc (danh sach link phang) nho: y chinh la chu chinh, mau accent
 * theo tung the, luoi nhieu cot thay vi 1 cot doc dai.
 */
function dgc_toc_render_mindmap( $items, $post_title, $content ) {
	$nodes = array();
	foreach ( $items as $it ) {
		if ( 2 === (int) $it['level'] ) {
			$nodes[] = array( 'h2' => $it, 'subs' => array() );
		} elseif ( 3 === (int) $it['level'] && ! empty( $nodes ) ) {
			$nodes[ count( $nodes ) - 1 ]['subs'][] = $it;
		}
	}
	if ( count( $nodes ) < 3 ) return '';
	ob_start();
	?>
	<details class="post-mindmap" id="postMindmap">
		<summary class="post-mindmap__head">
			<span class="post-toc__icon" aria-hidden="true">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="5" cy="12" r="2.4" stroke="currentColor" stroke-width="2"/><circle cx="19" cy="6" r="2.4" stroke="currentColor" stroke-width="2"/><circle cx="19" cy="18" r="2.4" stroke="currentColor" stroke-width="2"/><path d="M7.2 11l9.5-4M7.2 13l9.5 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
			</span>
			Sơ đồ bài viết
			<span class="post-mindmap__hint">Đọc lướt nắm trọn nội dung bài, không cần đọc hết</span>
			<span class="post-mindmap__chevron" aria-hidden="true"><svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
		</summary>
		<div class="dgc-mm">
			<div class="dgc-mm__center"><?php echo esc_html( $post_title ); ?></div>
			<div class="dgc-mm__grid">
				<?php foreach ( $nodes as $h2i => $node ) : $h2 = $node['h2']; $snip = dgc_toc_key_idea( $content, $h2['id'], $h2['label'], 140 ); ?>
					<div class="dgc-mm__card">
						<a class="dgc-mm__cardlink" href="#<?php echo esc_attr( $h2['id'] ); ?>" data-toc-link data-toc-id="<?php echo esc_attr( $h2['id'] ); ?>">
							<span class="dgc-mm__idea"><?php echo esc_html( $snip ?: $h2['label'] ); ?></span>
							<strong class="dgc-mm__tag"><?php echo esc_html( $h2['label'] ); ?></strong>
						</a>
						<?php if ( ! empty( $node['subs'] ) ) : ?>
							<div class="dgc-mm__chips">
								<?php foreach ( $node['subs'] as $h3 ) : ?>
									<a class="dgc-mm__chip" href="#<?php echo esc_attr( $h3['id'] ); ?>" data-toc-link data-toc-id="<?php echo esc_attr( $h3['id'] ); ?>" title="<?php echo esc_attr( $h3['label'] ); ?>"><?php echo esc_html( $h3['label'] ); ?></a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</details>
	<?php
	return ob_get_clean();
}

/**
 * Danh sach "thuc the / tu khoa muc tieu" (nhap tay o meta box "SEO & Schema" khi viet/audit
 * bai - lay tu buoc research SERP/entity, KHONG bia tu regex tu dong o day). Theme chi tu dong
 * hoa phan KIEM TRA: dem so lan tung thuc the xuat hien trong noi dung that, bao da-nhac/chua-nhac.
 * Rong -> an ca khoi (giong pattern FAQ). Cong khai duoi mindmap de vua QA vua tang tin hieu SEO/GEO.
 */
function dgc_entity_render( $post_id, $content ) {
	$ents = get_post_meta( $post_id, 'dgc_entities', true );
	if ( ! is_array( $ents ) || empty( $ents ) ) return '';

	$plain = wp_strip_all_tags( $content );
	$rows  = array();
	$found = 0;
	foreach ( $ents as $term ) {
		$term = trim( (string) $term );
		if ( '' === $term ) continue;
		$count = 0;
		if ( preg_match_all( '/' . preg_quote( $term, '/' ) . '/iu', $plain, $mm ) ) {
			$count = count( $mm[0] );
		}
		if ( $count > 0 ) $found++;
		$rows[] = array( 'term' => $term, 'count' => $count );
	}
	if ( empty( $rows ) ) return '';

	ob_start();
	?>
	<div class="post-entities" id="postEntities">
		<div class="post-entities__head">
			<span class="post-toc__icon" aria-hidden="true">
				<svg width="16" height="16" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M8.5 12.5l2.3 2.3L16 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</span>
			Thực thể / từ khoá đã quét trong bài
			<span class="post-entities__hint"><?php echo (int) $found; ?>/<?php echo count( $rows ); ?> đã được nhắc tới</span>
		</div>
		<ul class="ent-list">
			<?php foreach ( $rows as $r ) : ?>
				<li class="ent-item <?php echo $r['count'] > 0 ? 'ent-item--found' : 'ent-item--missing'; ?>">
					<span class="ent-check" aria-hidden="true"><?php echo $r['count'] > 0 ? '&#10003;' : '&#10005;'; ?></span>
					<span class="ent-term"><?php echo esc_html( $r['term'] ); ?></span>
					<?php if ( $r['count'] > 0 ) : ?>
						<span class="ent-count"><?php echo (int) $r['count']; ?> lần</span>
					<?php else : ?>
						<span class="ent-count ent-count--miss">chưa nhắc</span>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
	return ob_get_clean();
}

function dgc_toc_render_float() {
	$items = $GLOBALS['dgc_toc_items'];
	if ( empty( $items ) ) return;
	?>
	<button type="button" class="toc-fab" id="tocFab" aria-label="Mở mục lục" aria-expanded="false">
		<svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
		<span>Mục lục</span>
	</button>
	<div class="toc-sheet-ov" id="tocSheetOv"></div>
	<div class="toc-sheet" id="tocSheet" role="dialog" aria-modal="true" aria-label="Mục lục bài viết">
		<div class="toc-sheet__head">
			<span>Mục lục</span>
			<button type="button" class="toc-sheet__close" id="tocSheetClose" aria-label="Đóng mục lục">&times;</button>
		</div>
		<ol class="toc-sheet__list">
			<?php foreach ( $items as $it ) : ?>
				<li class="post-toc__item post-toc__item--h<?php echo (int) $it['level']; ?>">
					<a href="#<?php echo esc_attr( $it['id'] ); ?>" data-toc-link data-toc-id="<?php echo esc_attr( $it['id'] ); ?>"><?php echo esc_html( $it['label'] ); ?></a>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
	<?php
}
add_action( 'wp_footer', 'dgc_toc_render_float' );
