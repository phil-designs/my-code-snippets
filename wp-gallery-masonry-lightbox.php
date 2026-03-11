<?php
/*---------------------------------
	Masonry Gallery with Lightbox
	Uses: Isotope, imagesLoaded, Fancybox
------------------------------------*/
function aa_enqueue_gallery_scripts() {
	global $post;
	if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'gallery' ) ) {
		wp_enqueue_script( 'imagesloaded', 'https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js', array(), '5.0.0', true );
		wp_enqueue_script( 'isotope', 'https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js', array( 'imagesloaded' ), '3.0.6', true );
		wp_enqueue_style( 'fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.css', array(), '5.0.0' );
		wp_enqueue_script( 'fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.umd.js', array(), '5.0.0', true );
	}
}
add_action( 'wp_enqueue_scripts', 'aa_enqueue_gallery_scripts' );

function aa_masonry_gallery_shortcode( $output, $attr ) {
	global $post;

	$atts = shortcode_atts( array(
		'order'   => 'ASC',
		'orderby' => 'menu_order ID',
		'id'      => $post ? $post->ID : 0,
		'size'    => 'large',
		'include' => '',
		'exclude' => '',
	), $attr, 'gallery' );

	$id = intval( $atts['id'] );

	if ( ! empty( $atts['include'] ) ) {
		$include     = preg_replace( '/[^0-9,]+/', '', $atts['include'] );
		$attachments = get_posts( array(
			'include'        => $include,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => $atts['order'],
			'orderby'        => $atts['orderby'],
		) );
	} else {
		$attachments = get_children( array(
			'post_parent'    => $id,
			'post_status'    => 'inherit',
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'order'          => $atts['order'],
			'orderby'        => $atts['orderby'],
			'exclude'        => ! empty( $atts['exclude'] ) ? preg_replace( '/[^0-9,]+/', '', $atts['exclude'] ) : '',
		) );
	}

	if ( empty( $attachments ) ) {
		return '';
	}

	$gallery_id = 'aa-gallery-' . $id;

	$html  = '<style>';
	$html .= '#' . $gallery_id . ' { display: block; }';
	$html .= '.aa-masonry-item { width: calc(50% - 8px); margin-bottom: 16px; box-sizing: border-box; }';
	$html .= '.aa-masonry-item img { display: block; width: 100%; height: auto; }';
	$html .= '</style>';

	$html .= '<div id="' . esc_attr( $gallery_id ) . '" class="aa-masonry-gallery">';

	foreach ( $attachments as $attachment ) {
		$full_src  = wp_get_attachment_image_src( $attachment->ID, 'full' );
		$thumb_src = wp_get_attachment_image_src( $attachment->ID, $atts['size'] );
		$alt       = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
		$caption   = $attachment->post_excerpt;

		$html .= '<div class="aa-masonry-item">';
		$html .= '<a href="' . esc_url( $full_src[0] ) . '" data-fancybox="' . esc_attr( $gallery_id ) . '" data-caption="' . esc_attr( $caption ) . '">';
		$html .= '<img src="' . esc_url( $thumb_src[0] ) . '" alt="' . esc_attr( $alt ) . '" width="' . esc_attr( $thumb_src[1] ) . '" height="' . esc_attr( $thumb_src[2] ) . '" />';
		$html .= '</a>';
		$html .= '</div>';
	}

	$html .= '</div>';

	$html .= '<script>
(function() {
	var galleryEl = document.getElementById("' . esc_js( $gallery_id ) . '");
	if ( ! galleryEl ) return;

	imagesLoaded( galleryEl, function() {
		new Isotope( galleryEl, {
			itemSelector: ".aa-masonry-item",
			layoutMode: "masonry",
			masonry: {
				columnWidth: ".aa-masonry-item",
				gutter: 16
			}
		});
	});

	Fancybox.bind("[data-fancybox=\"' . esc_js( $gallery_id ) . '\"]");
})();
</script>';

	return $html;
}
add_filter( 'post_gallery', 'aa_masonry_gallery_shortcode', 10, 2 );
?>