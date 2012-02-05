<?php
/**
 * @package WordPress
 * @subpackage themename
 */
get_header(); ?>
<div id="content">
<?php /* Start the Loop */

$args = array('post_type' => 'release' , 'orderby' => 'meta_value_num', 'meta_key' => '_sr_release-date' , 'posts_per_page' => '-1');

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$wp_query = new WP_Query($args);

while ( $wp_query->have_posts() ) : $wp_query->the_post();

	sr_relart_loop_markup();
	
endwhile;

//sr_posts_navigation();?>

</div><!-- #content -->

<?php get_footer(); ?>
