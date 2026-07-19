<?php
/**
 * Shortcode [thuatngu hien="..."]Định nghĩa...[/thuatngu]
 * Icon "i" ngay sau thuật ngữ, bấm mở popup giải thích (tái dùng modal .intro-pop có sẵn ở bảng giá).
 * Xem .claude/rules/external-link-eeat.md - dùng cho thuật ngữ KHÔNG có nguồn ngoài xứng đáng để link.
 */
function dgc_glossary_shortcode( $atts, $content = '' ) {
	$atts = shortcode_atts( [ 'hien' => '' ], $atts, 'thuatngu' );
	$term = $atts['hien'] !== '' ? $atts['hien'] : wp_strip_all_tags( $content );
	if ( $term === '' || trim( $content ) === '' ) {
		return $term;
	}
	static $i = 0;
	$i++;
	$id  = 'gloss-' . $i . '-' . substr( md5( $term . $i ), 0, 6 );
	$def = wpautop( wp_kses_post( trim( $content ) ) );

	return sprintf(
		'<span class="gloss-term">%1$s<button type="button" class="intro-toggle gloss-toggle" aria-controls="%2$s" aria-label="%3$s" title="%4$s"></button><span class="gloss-def" id="%2$s" hidden>%5$s</span></span>',
		esc_html( $term ),
		esc_attr( $id ),
		esc_attr( 'Giải thích thuật ngữ: ' . $term ),
		esc_attr( 'Giải thích: ' . $term ),
		$def
	);
}
add_shortcode( 'thuatngu', 'dgc_glossary_shortcode' );
