<?php
/**
 * Template Name: Videos and Photo Page
 * Description: Holder for media loop
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

	<div id="content" class="clearfix">
		<div id="isotope-wrap">
			<?php
			
			//Array to rule out dulplicate vids
			$videos = array();
			
			//Array of artist names and css class name
			$artists = array();
			
			//Index for artists 
			$i=0;
			
			/* Start the Loop */
			$art_args = array('post_type' => 'artist' , 'posts_per_page' => '-1' );
			$art_query = new WP_Query($art_args);
			
			while ( $art_query->have_posts() ) : $art_query->the_post();
								
				$artist_title = get_the_title();
				$artist_class = sr_make_class($artist_title);
				$artists[$i] = array('title' => $artist_title , 'class' => $artist_class); 
				
				//get the videos
				//sr_media_videos($dont_copy_vid , $artist_class);
				
				global $video_mb;
				$meta = $video_mb->the_meta();
				if($meta['videos']){
					$videos_meta = $meta['videos'];
					foreach ($videos_meta as $video)
					{	
						$video_link = $video['video-link'];
						array_push($videos , $video_link);
					}
				}
				
				/* Release sub query */
				
				$rel_args = array('post_type' => 'release' , 'artist' => $artist_title , 'posts_per_page' => '-1');
				$rel_query = new WP_query($rel_args);
				
				if(have_posts()): while ( $rel_query->have_posts() ) : $rel_query->the_post();
										
						//sr_media_videos($dont_copy_vid , $artist_class);
						
						global $video_mb;
						$meta = $video_mb->the_meta();
						if($meta['videos']){
							$videos_meta = $meta['videos'];
							foreach ($videos_meta as $video)
							{	
								$video_link = $video['video-link'];
								array_push($videos , $video_link);
							}
						}
					
				endwhile; endif;
				
				//increment artist index
				$i++;
				
			endwhile;
			
			$videos_return = sr_get_videos($videos);
			
			foreach($videos_return as $video)
			{
			if($video['is_valid'] == 'true')
			{?>
					<a href="<?php echo $video['embed'] ?>" class="fancy-roll lightbox fancybox.iframe video <?php echo $video['vendor'] . ' ' . $artist; ?>" rel="gallery-media">
							<img src="<?php echo $video['thumbnail_large']?>" class="<?php echo $video['vendor'] ?>" />	
						<div class="info">
							<div class="wrap">
								<header class="entry-header">
									<h1 class="entry-title small-h"><?php echo $video['title'] ?></h1>
								</header>
								<?php if($video['description'] != '_empty_'):?>
									<div class="entry-summary">
										<p><?php echo $video['description'] ?></p>
									</div>
								<?php endif; ?>
								<div class="read-more button button-large">Click to watch</div>
							</div>
						</div>
					</a>
			<?php }
			}
			
			require_once("library/phpFlickr.php");
			$phpFlickrObj = new phpFlickr('5513c9832db6522b7b01155508526edb');
			$user_url = $phpFlickrObj->urls_getUserPhotos('8546357@N03');
			$photos = $phpFlickrObj->people_getPublicPhotos('8546357@N03', NULL, NULL, 20);
			//print_r($photos);
			foreach ($photos['photos']['photo'] as $photo)
			{
			  $photo = $phpFlickrObj->photos_getSizes($photo['id']);
			  ?>
				<a class="fancy-roll lightbox flickr" href="<?php echo $photo[6]['source']; ?>" rel="bookmark">
					<img src="<?php echo $photo[4]['source']; ?>" width="<?php echo $photo[4]['width']; ?>" height="<?php echo $photo[4]['height']; ?>" />
					<div class="info"><div class="wrap">
						<span class="click-prompt zoom">Click to zoom</span>
					</div></div>
				</a> <?php
			}
			?>
		</div><!--#isotope-wrap-->
	</div><!-- #content -->
<?php

//Filtering

$filter_string = '';
foreach($artists as $artist){
	$filter_string .= '<li class="filter-item artist"><a href="#" data-filter=".' . $artist['class'] . '">' . esc_html($artist['title']) . '</a></li>';
}
$filter_string .= '<li class="filter-item media flickr"><a href="#" data-filter=".flickr" class="flickr-filter">Flickr</a><a class="flickr-link" href="http://www.flickr.com/photos/stolenrecordings" target="_blank" title="Go to Stolen Recordings Flickr" >Stolenrecs on Flickr</a></li></ul>';
?>
<script type="text/javascript"> 
	var filterString = '<?php echo $filter_string; ?>';
</script> 
		</ul>
	</div>
	
<?php get_footer(); ?>