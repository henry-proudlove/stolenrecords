<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<?php /* Shows aside */

$current_datetime = date('Y-m-d H:i');

$meta_query_str = array(
	array(
		'key' => '_sr_show-date', 
		'compare' => '>=' ,
		'value' => $current_datetime
	)
);

$args = array(
	'posts_per_page' => '5' ,
	'post_type' => 'show' ,
	'orderby' => 'meta_value',
	'meta_key' => '_sr_show-date' ,
	'order' => 'ASC' , 
	'meta_query' => $meta_query_str
);

$dont_copy = array();
$the_query = new WP_query($args);

?>
<aside id="shows">
	<?php if ( $the_query->have_posts() ) : ?>
	<?php while ( $the_query->have_posts() ) : $the_query->the_post();
	
		_sr_shows_markup();

	endwhile; else:
	
		_sr_noshows_markup();
		
	endif; ?>
</aside><!--#stolen-shows-->