<?php

//get the taxonomy terms of custom post type
$customTaxonomyTerms = wp_get_object_terms( $post->ID, 'your_taxonomy', array('fields' => 'ids') );

//query arguments
$args = array(
    'post_type' => 'your_custom_post_type',
    'post_status' => 'publish',
    'posts_per_page' => 5,
    'orderby' => 'rand',
    'tax_query' => array(
        array(
            'taxonomy' => 'your_custom_taxonomy',
            'field' => 'id',
            'terms' => $customTaxonomyTerms
        )
    ),
    'post__not_in' => array ($post->ID),
);

//the query
$relatedPosts = new WP_Query( $args );

//loop through query
if($relatedPosts->have_posts()){
    echo '<ul>';
    while($relatedPosts->have_posts()){ 
        $relatedPosts->the_post();
?>
        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
    }
    echo '</ul>';
}else{
    //no posts found
}

//restore original post data
wp_reset_postdata();

?>