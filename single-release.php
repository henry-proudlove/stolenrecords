<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>
<?php 
	$artist_terms = get_the_terms( $post->ID, 'artist' );
	$artists = array();
	$artists_count = count($artist_terms);
	foreach ($artist_terms as $artist_term)
	{	
		array_push($artists, $artist_term->term_id);
	}
	$artists_titles = array();
	foreach ($artist_terms as $artist_term)
	{	
		$artist_title = get_page_by_title($artist_term->name , OBJECT, 'artist');
		$artist_title = array('title' => $artist_title->post_title, 'guid' => $artist_title->guid);
		array_push($artists_titles, $artist_title);
	}
?>
	<div id="content">
		<a href="<?php echo get_post_type_archive_link( 'release' ); ?>">All Releases</a>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<div class="entry-gallery">
				<?php sr_post_thumbnail('medium' , false, 'null') ?>
			</div><!-- .entry-gallery -->
			
			<div id="release-info">
				<header class="entry-header">
				
					<?php // Release title ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					
					<?php // Artists name
					$artists_titles_count = count($artists_titles);
					if($artists_titles_count < 2):
						foreach($artists_titles as $artist_title): ?>
							<span class"entry-artist">
								<a href="<?php echo $artist_title['guid'];?>" title= "More about <?php echo $artist_title['title']; ?>"><?php echo $artist_title['title']; ?></a>
							</span> <?php
						endforeach;
					else: ?>
						<span class"entry-artist">Various Artists</span>
					<?php endif; wp_reset_query();
					
					//Release date
					$release_date = get_post_meta( $post->ID , '_sr_release-date', true);
					if ($release_date):
						$release_date = date_create($release_date);
						$release_date = date_format($release_date, 'Y');
						echo '<time class="entry-date">' . $release_date . '</time>';
					endif;
					?>
				</header><!-- .entry-header -->
				<div id="content-reviews">
					<div id="slider">
						<div id="entry-content">
							<?php the_content(); ?> 
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
						echo '<a class="button buy-now" href="' . $buy_link . '" title="Buy ' . get_the_title() . '" rel="bookmark">Buy Now</a>';
					endif;
				?>
			</div><!--#release-info-->
			<?php sr_release_tracks(); ?>
			<?php sr_release_videos(); ?>
			<?php
			$args = array('artist' => $artists, 'exclude' => $post->ID, 'limit' => '4', 'buy_now' => false , 'aside' => 'true' );
			sr_rels_by_artist($args);
			?>
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php sr_single_post_navigation(); ?>
	</div><!-- #content -->
<?php get_footer(); ?>