<?php
/*------------------------------------------------
	Create ACF Post Types Select Box
---------------------------------------------------*/
function acf_load_post_types($field){
    foreach ( get_post_types( '', 'names' ) as $post_type ) {
       $field['choices'][$post_type] = $post_type;
    }
    // return the field
    return $field;
}
add_filter('acf/load_field/name=posttype', 'acf_load_post_types');

/*------------------------------------------------
	Create ACF Taxonomies Select Box
---------------------------------------------------*/
function acf_load_taxonomies($field){
    foreach ( get_taxonomies( '', 'names' ) as $taxonomy ) {
       $field['choices'][$taxonomy] = $taxonomy;
    }
    // return the field
    return $field;
}
add_filter('acf/load_field/name=select_cat', 'acf_load_taxonomies');
?>