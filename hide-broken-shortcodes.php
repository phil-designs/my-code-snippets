<?php
/*---------------------------------
	Hide unregistered shortcodes on frontend
------------------------------------*/
function aa_hide_broken_shortcodes( $content ) {
	if ( false === strpos( $content, '[' ) ) {
		return $content;
	}
	// Runs after do_shortcode (priority 11). Any remaining [shortcode] patterns
	// are unregistered and would display as raw text — strip them instead.
	return preg_replace( '/\[\/?[a-zA-Z_][a-zA-Z0-9_-]*[^\]]*\]/', '', $content );
}
add_filter( 'the_content', 'aa_hide_broken_shortcodes', 12 );
?>