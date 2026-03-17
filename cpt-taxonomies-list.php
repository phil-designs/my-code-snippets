<?php
$taxonomy_objects = get_object_taxonomies( 'cpt', 'objects' ); // <--- change cpt with the custom post type
$out = array();
foreach ( $taxonomy_objects as $taxonomy_slug => $taxonomy ){
$terms = get_terms( $taxonomy_slug, 'hide_empty=0' );
if ( !empty( $terms ) ) {
$out[] = "<strong>" . $taxonomy->label . "</strong>\n<ul>";
foreach ( $terms as $term ) {
$out[] =
"  <li>"
.    $term->name
. "  </li>\n";
}
$out[] = "</ul>\n";
}
}
echo implode('', $out );
?>