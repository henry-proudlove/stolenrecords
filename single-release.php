<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>
	<div id="content">
		<section id="single-release" class="twelvecol">
		<header class="results-header">
		<?php 
			$link =  get_post_type_archive_link( 'release' );
			sr_content_close($link , 'Releases');
		?>
		</header>
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
								<?php no_more_excerpt($post->ID, 'big-center');?> 
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
								$curr_date = date('U');
								$release_date = strtotime($release_date);
								if ($curr_date <= $release_date)
								{
									echo '<a href="'.$buy_now_link .'" class="buy-link preorder button button-large">Preorder now</a>';
								}else
								{
									echo '<a href="'.$buy_now_link .'" class="buy-link buy-now button button-large">Buy Now</a>';
								}
						endif;
					?>
			</div><!--#release-info-->
			<div class="entry-gallery sixcol right">
				<?php if (has_post_thumbnail()):
					$post_thumb = get_post_thumbnail_id();
					$options = array(	
						'size' => 'sr-sixcol',
						'big' => 'full' ,
						'img_class' => 'post-thumb',
						'wrapper' => false ,
						'include' => $post_thumb,
						'link' => 'self',
						'a_class' => 'lightbox photo fancy-roll'
					);
					sr_get_images($options);
				else:
					$options = array(
						'size' => 'sr-sixcol',
						'big' => 'full' ,
						'img_class' => 'post-thumb',
						'wrapper' => false ,
						'limit' => '1',
						'link' => 'self',
						'a_class' => 'lightbox photo fancy-roll'
					);
					sr_get_images($options);
				endif; ?>
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