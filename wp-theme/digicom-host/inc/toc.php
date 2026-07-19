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

	return dgc_toc_render_inline( $items ) . $content;
}
add_filter( 'the_content', 'dgc_toc_process', 9 );

function dgc_toc_render_inline( $items ) {
	ob_start();
	?>
	<nav class="post-toc" id="postToc" aria-label="Mục lục bài viết">
		<details open>
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
