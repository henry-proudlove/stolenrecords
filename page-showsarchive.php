<?php
/**
 * Template Name: Stolen Shows Archive
 * Description: Holder for stolen shows archive
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

	<div id="content">
		<header class="results-header twelvecol"><a href="<?php echo get_post_type_archive_link( 'show' ); ?>" class="content-close">Back to Shows</a></header>
		
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
				<?php while ( $the_query->have_posts() ) : $the_query->the_post();
				if(has_post_thumbnail()):
					$show_meta = sr_shows_meta($post->ID);
					$thumb_id = get_post_thumbnail_id();
					$thumb_src = wp_get_attachment_image_src( $thumb_id, large);?>
					<a href="<?php echo $thumb_src[0]; ?>" class="fancy-roll fourcol lightbox fancybox.image" title="Click to zoom" rel="bookmark">
						<?php sr_post_thumbnail('sr-show-fourcol' , false, 'null'); ?>
						<div class="info">
							<div class="wrap">
								<header class="entry-header">
									<time class="show-date"><?php echo $show_meta['date']; ?></time>
									<h1 class="entry-title">
									<?php if($show_meta['buy_tix']): ?>
										<?php the_title(); ?>
									<?php else: ?>
										<?php the_title(); ?>
									<?php endif; ?>
									</h1>
									<h3>
									<?php foreach($show_meta['artists'] as $artist):?>
										<span class="entry-artist">
											<?php echo $artist['title']; ?>
										</span>
									<?php endforeach; ?>
									</h3>
									<div class="entry-meta">
										<?php if($show_meta['venue_link'] && $show_meta['venue']):?>
											<span class="venue"><?php echo $show_meta['venue']; ?></span>
										<?php elseif($show_meta['venue']): ?>
											<span class="venue"><?php echo $show_meta['venue']; ?></span>
										<?php elseif($show_meta['venue_link']):?>
											<span class="venue"><?php echo $show_meta['venue_link']; ?></span>
										<?php endif; ?>
									</div>
								</header><!-- .entry-header -->
								<div class="entry-summary">
									<?php no_more_excerpt($post->ID); ?>
								</div><!-- .entry-summary -->
								<div class="read-more button button-large">Click to zoom</div>
							</div><!--.wrap-->
						</div><!--.info-->
					</a><!--.fancy-roll--> <?php
					endif;	
				endwhile;
			endif; ?>
	</div><!--#content-->

<?php get_footer(); ?>