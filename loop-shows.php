<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<div id="shows">
<?php /* Shows loop */

$current_datetime = date('Y-m-d H:i');
$meta_query_str = array(
	'relation' => 'AND', 
	array(
		'key' => '_sr_show-date', 
		'compare' => '>=' ,
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
	'order' => 'ASC' , 
	'meta_query' => $meta_query_str
);

$dont_copy = array();
$the_query = new WP_query($args);

?>
	<section id="stolen-shows" style="margin-bottom: 10px;">
	<?php if ( $the_query->have_posts() ) : ?>
	<h1 class="section-header">Stolen Shows</h1>
	<?php while ( $the_query->have_posts() ) : $the_query->the_post();
	array_push($dont_copy, $post->ID);
		sr_shows_markup(false);
	
	endwhile; ?>
	
		</section><!--#stolen-shows-->
		
	<?php endif; ?>
	
	
	<?php
	$meta_query_str = array(
		array(
			'key' => '_sr_show-date', 
			'compare' => '>=' ,
			'value' => $current_datetime
		)
	);

	$args['meta_query'] = $meta_query_str;
	$args['post__not_in'] = $dont_copy;
	$the_query = new WP_query($args);
	?>
	<section id="artist-shows">
	<?php if ( $the_query->have_posts() ) : ?>
	<h1 class="section-header">Artist Shows</h1>
	<?php while ( $the_query->have_posts() ) : $the_query->the_post();
	
		sr_shows_markup(false);
	
	endwhile; else: ?>
	
		<article id="no-shows" role="article">
			<header class="entry-header"><h2 class="entry-title">Sorry, no gigs coming up</h2></header>
			<span class="no-shows-msg">Check back soon or <?php get_twitter_link(); ?> for incessant updates </span>
		</article><!-- #no-shows -->
		
	<?php endif; ?>
	</section><!--#artists-shows-->

</div><!--#shows-->