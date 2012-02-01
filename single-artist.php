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
			
			<section id="releases">
				<?php 
				$args = array();
				$args['artist'] = get_the_title();
				sr_rels_by_artist($args);
				?>
			</section><!--#releases-->
			
			<section id="reivews">
				<?php sr_get_reivews(); ?>
			</section><!-- #reviews -->
			
			<aside id="videos">
				<?php sr_artist_videos(); ?>
			</aside><!--#videos-->
			
			
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php sr_single_post_navigation(); ?>
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>