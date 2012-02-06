<?php
/**
 * Template Name: Stolen Shows Archive
 * Description: Holder for stolen shows archive
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

<?php /* Shows loop */

	$current_datetime = date('Y-m-d H:i');
	
	$meta_query_str = array(
		'relation' => 'AND', 
		array(
			'key' => '_sr_show-date', 
			'compare' => '<' ,
			'value' => $current_datetime
		) ,
		array(
			'key' => '_sr_stolen-show'
		)
	);
	
	$args = array(
		'posts_per_page' => '-1' ,
		'post_type' => 'show' ,
		'orderby' => 'meta_value',
		'meta_key' => '_sr_show-date' ,
		'meta_query' => $meta_query_str
	);
	
	$the_query = new WP_query($args);

	if ( $the_query->have_posts() ) : ?>
		<p>Stolen Shows Archive</p>
		<?php while ( $the_query->have_posts() ) : $the_query->the_post();
		
			sr_relart_loop_markup()
		
		endwhile;
			
	endif; ?>

<?php get_footer(); ?>