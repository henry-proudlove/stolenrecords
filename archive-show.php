<?php
/**
 * @package WordPress
 * @subpackage themename
 */
get_header(); ?>

<div id="content">
	<section id="shows" class="twelvecol">
	<?php $showsarchive = get_page_by_title( 'Stolen Shows Archive' ); ?>
	<header class="results-header"><h1 class="results-title"><a href="<?php echo get_page_link($showsarchive->ID); ?>" rel="bookmark">Stolen Shows Archive</a></h1></header>
	<?php
		$current_datetime = (string) date('U');
		
		$args = array(
			'posts_per_page' => '-1',
			'post_type' => 'show' ,
			'orderby' => 'meta_value_num',
			'meta_key' => '_sr_show-stamp' ,
			'order' => 'ASC' ,
			'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => '_sr_show-stamp',
						'value' => $current_datetime,
						'type' => 'numeric',
						'compare' => '>='
						
					),
					array(
						'key' => '_sr_stolen-show',
						'value' => 'stolen-show',
						'compare' => '='
					),
			)
		);
		$stolen_shows = array();
		$the_query = new WP_query($args);
	?>
		<?php 
		if ( $the_query->have_posts() ) : ?>
		<?php while( $the_query->have_posts() ) : $the_query->the_post();
			array_push($stolen_shows , $post->ID);
			sr_shows_markup();
		
		endwhile;
		endif;
		
		$args['post__not_in'] = $stolen_shows;
		$args['meta_query'] = array(
			array(
				'key' => '_sr_show-stamp',
				'value' => $current_datetime,
				'type' => 'numeric',
				'compare' => '>='
				
			)
		);
		$the_query = new WP_query($args);
		if ( $the_query->have_posts() ) : ?>
		<?php while ( $the_query->have_posts() ) : $the_query->the_post();
			sr_shows_markup();
		
		endwhile; ?>
			
		<?php endif; ?>
		
	</section><!-- #shows -->
</div><!-- #content -->
<?php get_footer(); ?>