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
<div id="primary">
	<div id="content">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<div class="entry-gallery">
				<?php sr_post_thumbnail('medium' , false) ?>
			</div><!-- .entry-gallery -->
			<div id="release-info">
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<?php
					$artists_titles_count = count($artists_titles);
					if($artists_titles_count < 2)
					{
					foreach($artists_titles as $artist_title)
					{?>
						<cite class"entry-artist">
							<a href="<?php echo $artist_title['guid'];?>" title= "More about <?php echo $artist_title['title']; ?>"><?php echo $artist_title['title']; ?></a>
						</cite>
					<?php } 
					} else { ?>
						<cite class"entry-artist">Various Artists</cite>
					<?php } wp_reset_query();	
					?>
				</header><!-- .entry-header -->
				<div id="content-reviews">
					<div id="entry-content">
						<?php the_content(); ?> 
					</div>
					<?php
					global $review_mb;
					$meta = $review_mb->the_meta();
					$reviews = $meta['reviews'];
					if($reviews){
						sr_get_reivews($reviews);
					}
					?>
				</div><!--#entry-content-->
			</div><!--#release-info-->
			<?php sr_release_tracks(); ?>
			<?php sr_release_videos(); ?>
			<?php
			$this_rel = get_the_ID();
			$args = array('artist' => $artists, 'exclude' => $this_rel, 'limit' => '4', 'buy_now' => false , 'aside' => 'true' );
			sr_rels_by_artist($args);
			?>
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php sr_single_post_navigation(); ?>
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>