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
		<header class="results-header twelvecol">
		<?php 
			$link =  get_post_type_archive_link( 'show' );
			sr_content_close($link , 'Shows');
		?>
		</header>
		
		<?php /* Shows loop */
		$current_datetime = (string) date('U');
		
		$args = array(
			'posts_per_page' => '-1',
			'post_type' => 'show' ,
			'orderby' => 'meta_value_num',
			'meta_key' => '_sr_show-stamp' ,
			'order' => 'DESC' ,
			'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => '_sr_show-stamp',
						'value' => $current_datetime,
						'type' => 'numeric',
						'compare' => '<='
						
					),
					array(
						'key' => '_sr_stolen-show',
						'value' => 'stolen-show',
						'compare' => '='
					),
				)
			);
			$the_query = new WP_query($args);
		
			if ( $the_query->have_posts() ) : ?>
				<?php while ( $the_query->have_posts() ) : $the_query->the_post();
				if(has_post_thumbnail()):
					$show_meta = sr_shows_meta($post->ID);
					$thumb_id = get_post_thumbnail_id();
					$thumb_src = wp_get_attachment_image_src( $thumb_id, large);?>
					<a href="<?php echo $thumb_src[0]; ?>" class="fancy-roll fourcol lightbox photo"  rel="bookmark">
						<?php sr_post_thumbnail('sr-show-fourcol' , false, 'null'); ?>
						<div class="info">
							<div class="wrap">
								<header class="entry-header">
									<time class="show-date"><?php echo $show_meta['date']; ?></time>
									<h1 class="entry-title small-h">
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
			else: ?>
				<article id="no-posts" <?php post_class(); ?> role="article">
				<header class="entry-header">
					<h1 class="entry-title medium-h">Sorry, no shows!</h1>
				</header><!-- .entry-header -->
				
				<div class="entry-summary">
					<p>Past Stolen Shows will be added to this page as they slip into the past. There aren't any to show yet though</p>
				</div><!-- .entry-summary -->
			</article><!-- #post-<?php the_ID(); ?> -->
		<?php endif; ?>
	</div><!--#content-->

<?php get_footer(); ?>