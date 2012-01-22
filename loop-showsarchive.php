<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<div id="shows">
<?php /* Shows loop */

$current_datetime = date('Y-m-d H:i');
echo '<p style="margin-bottom: 10px;">' . $current_datetime . '</p>';

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

$dont_copy = array();
$the_query = new WP_query($args);

?>
	<section id="stolen-shows" style="margin-bottom: 10px;">
	<?php if ( $the_query->have_posts() ) : ?>
	<p>Stolen Shows Archive</p>
	<?php while ( $the_query->have_posts() ) : $the_query->the_post();
	array_push($dont_copy, $post->ID);
		_sr_shows_markup();
	
	endwhile; else:
	
		_sr_noshows_markup();
		
	endif; ?>
	</section><!--#stolen-shows-->
	
</div><!--#shows-->