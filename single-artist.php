<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

	<div id="content">
		<article id="post-<?php the_ID(); ?>" <?php post_class('twelvecol'); ?> role="article">
				<header class="entry-header">
					<h1 class="entry-title big-h"><?php the_title(); ?></h1>
					<?php 
					$artist = get_the_title();
					$artist_status = get_post_meta(get_the_ID(),'_sr_present-past',TRUE);
					if ($artist_status == 'past'){
						echo '<h2 class="artist-status">Past Artist</h2>'; 
					}?>
				</header><!-- .entry-header -->
				<div class="slider-wrap">
					<div id="artist-slider" class="entry-gallery">
						<?php sr_artist_gallery(); ?>
					</div><!-- .entry-gallery -->
				</div><!--.slider-wrap-->
				<div id="content-holder">
					<div class="entry-content big-center expander">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
					<?php sr_social_links(false, false); ?>
				</div>
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php
		$artist_term = get_term_by( 'name', $artist, 'artist');
		$args = array( 'artist' => $artist_term->term_id, 'thumb_size' => 'sr-twocol', );
		sr_rels_by_artist($args);
		?>
			<?php 
			global $review_mb;
			$meta = $review_mb->the_meta();
			$reviews = $meta['reviews'];
			if($reviews): ?>
				<section id="reviews" class="twelvecol">
					<div class="slider">
					<?php sr_get_reivews($reviews); ?>
					</div>
				</section><!--#reviews-->
			<?php endif; ?>
		<footer id="artist-asides" class="clearfix">
			<?php sr_artist_videos($artist); ?>
			<?php sr_aside_shows($artist, false);?>	
			<?php sr_artist_tracks($artist); ?>
		</footer><!--#artist-asides-->
		
		<?php sr_single_post_navigation(); ?>
		
	</div><!-- #content -->
<?php get_footer(); ?>