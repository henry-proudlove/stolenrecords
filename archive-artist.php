<?php
/**
 * @package WordPress
 * @subpackage themename
 */
get_header(); ?>

<div id="content">

<?php /* Start the Loop */
	
	$args = array('post_type' => 'artist' , 'posts_per_page' => '-1' , 'orderby' => 'title' , 'order' => 'ASC' , 'meta_key' => '_sr_present-past', 'meta_value' => 'current');
	
	$the_query = new WP_Query($args);
	
	while ( $the_query->have_posts() ) : $the_query->the_post();
	
		sr_relart_loop_markup(); 
	
	endwhile;
	
	$args['meta_value'] = 'past';
	
	$the_query = new WP_Query($args);

	while ( $the_query->have_posts() ) : $the_query->the_post();
	
		sr_relart_loop_markup(); 
	
	endwhile; ?>
	 
</div><!-- #content -->

<?php get_footer(); ?>