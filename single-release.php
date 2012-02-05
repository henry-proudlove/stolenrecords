<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

<div id="primary">
	<div id="content">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<section id="intro">
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
			</section><!--#intro-->
			
			<?php 
			$args = array();
			$args['artist'] = $artist;
			sr_rels_by_artist($args);
			?>
			<?php sr_get_reivews(); ?>
			<?php sr_artist_videos($artist); ?>
			<?php sr_artist_shows($artist, true);?>	
			<?php sr_artist_tracks($artist); ?>
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php sr_single_post_navigation(); ?>
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>