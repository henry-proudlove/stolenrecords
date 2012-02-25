<?php
/**
 * @package WordPress
 * @subpackage themename
 */
get_header(); ?>

<div id="content">
	<section id="shows" class="twelvecol">
	<?php $showsarchive = get_page_by_title( 'Stolen Shows Archive' ); ?>
	<a href="<?php echo get_page_link($showsarchive->ID); ?>" title="See Stolen Shows from days gone by" rel="bookmark">Stolen Shows Archive</a>
	<?php
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
		<?php if ( $the_query->have_posts() ) : ?>
		<?php while ( $the_query->have_posts() ) : $the_query->the_post();
		array_push($dont_copy, $post->ID);
			sr_shows_markup(false);
		
		endwhile; ?>
			
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
		<?php if ( $the_query->have_posts() ) : ?>
		<?php while ( $the_query->have_posts() ) : $the_query->the_post();
		
			sr_shows_markup(false);
		
		endwhile; else: ?>
		
			<article id="no-shows" role="article">
				<header class="entry-header"><h2 class="entry-title">Sorry, no gigs coming up</h2></header>
				<span class="no-shows-msg">Check back soon or <?php get_twitter_link(); ?> for incessant updates </span>
			</article><!-- #no-shows -->
			
		<?php endif; ?>
	</section><!-- #shows -->
</div><!-- #content -->
<?php get_footer(); ?>