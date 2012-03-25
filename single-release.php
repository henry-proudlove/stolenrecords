<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>
	<div id="content">
		<section id="single-release" class="twelvecol">
		<header class="results-header"><a href="<?php echo get_post_type_archive_link( 'release' ); ?>" class="content-close">All Releases</a></header>
		<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix nested'); ?> role="article">
			<div id="release-info" class="sixcol left">
					<header class="entry-header">
						<?php 
						// Release title ?>
						<h1 class="entry-title medium-h"><?php the_title(); ?></h1>
						
						<?php // Artists name
						$artists = sr_get_rels_artist($post->ID);
						?>
				</header><!-- .entry-header -->
					<div id="entry-content">
						<div class="slider">
							<div>
								<?php 
									$excerpt = get_the_excerpt();
									echo '<p class="big-center">' . $excerpt . '</p>';
								?> 
							</div>
							<?php
							global $review_mb;
							$meta = $review_mb->the_meta();
							$reviews = $meta['reviews'];
							if($reviews):
								sr_get_reivews($reviews);
							endif;
							?>
						</div><!--#slider-->
					</div><!--#entry-content-->
					<?php
						$buy_link = get_post_meta( $post->ID , '_sr_release-buy-link', true);
						if ($buy_link):
							echo '<a class="button buy-now button-large" href="' . $buy_link . '" title="Buy ' . get_the_title() . '" rel="bookmark">Buy Now</a>';
						endif;
					?>
			</div><!--#release-info-->
			<div class="entry-gallery sixcol right">
				<?php sr_post_thumbnail('sr-sixcol' , false, 'null') ?>
			</div><!-- .entry-gallery -->
		</article><!-- #post-<?php the_ID(); ?> -->
		</section><!--#release-->
		
		<footer id="release-asides" class="clearfix">
			<?php sr_release_tracks(); ?>
				<?php sr_release_videos(); ?>
				<?php
				$args = array('artist' => $artists, 'exclude' => $post->ID, 'limit' => '4', 'buy_now' => false , 'aside' => true );
				sr_rels_by_artist($args);
			?>
		</footer>
		<?php // sr_single_post_navigation(); ?>
	</div><!-- #content -->
<?php get_footer(); ?>