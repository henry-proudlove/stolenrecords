<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

<div id="primary">
	<div id="content">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
				<?php $artist = get_the_title(); ?>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header><!-- .entry-header -->
				<div class="entry-gallery">
					<?php sr_artist_gallery(); ?>
				</div><!-- .entry-gallery -->
				<div id="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				<?php sr_social_links(); ?>
			
			<?php 
			
			$artist_term = get_term_by( 'name', $artist, 'artist');
			$args = array( 'artist' => $artist_term->term_id );
			sr_rels_by_artist($args);
			?>
			<?php 
			global $review_mb;
			$meta = $review_mb->the_meta();
			$reviews = $meta['reviews'];
			if($reviews): ?>
				<section id="reviews">
					<?php sr_get_reivews($reviews); ?>
				</section><!--#reviews-->
			<?php endif; ?>
			<?php sr_artist_videos($artist); ?>
			<?php sr_artist_shows($artist, true);?>	
			<?php sr_artist_tracks($artist); ?>
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php sr_single_post_navigation(); ?>
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>