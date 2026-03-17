<?php $terms = get_the_terms( $post->ID , 'yourtaxonomyhere' ); 
    foreach ( $terms as $term ) {
    $term_link = get_term_link( $term, 'yourtaxonomyhere' );
    if( is_wp_error( $term_link ) )
        continue;
        echo '<a href="' . $term_link . '">' . $term->name . '</a>';
    } 
?>