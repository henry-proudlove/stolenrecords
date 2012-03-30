<?php
/**
 * @package WordPress
 * @subpackage themename
 */
get_header(); ?>
<div id="content">
	<div id="isotope-wrap">
	<?php /* Start the Loop */
	
	$args = array('post_type' => 'release' , 'orderby' => 'meta_value_num', 'meta_key' => '_sr_release-date' , 'posts_per_page' => '-1');
	
	//Array of artists
	$artists = array();
	$wp_query = new WP_Query($args);
	
	while ( $wp_query->have_posts() ) : $wp_query->the_post();
		
		sr_relart_loop_markup($artists);
		
	endwhile; ?>
	</div><!--#isotope-wrap-->
</div><!-- #content -->
<?php 
	$filter_string = '';
	foreach($artists as $artist){
		$filter_string .= '<li class="filter-item artist"><a href="#" data-filter=".' . $artist['class'] . '">' . $artist['title'] . '</a></li>';
	}
?>
<script type="text/javascript">
	var filterString = '<?php echo $filter_string; ?>';
</script> 
<?php get_footer(); ?>
