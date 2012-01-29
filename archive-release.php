<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>

<?php /* Start the Loop */

$args = array('post_type' => 'release' , 'orderby' => 'meta_value_num', 'meta_key' => '_sr_release-date' , 'paged' => $paged	);

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$wp_query = new WP_Query($args);

while ( $wp_query->have_posts() ) : $wp_query->the_post();

	_sr_relart_loop_markup();
	
endwhile; ?>

<?php sr_posts_navigation() ?>
