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

			<?php /* Start the Loop */?>
	
			<?php
			
			//Array to rule out dulplicate vids
			$dont_copy_vid = array();
			
			//Array of artist names and css class name
			$artists = array();
			
			//Index for artists 
			$j=0;
			
			//Get all vids attached to artist + all releases in artist tax
			$art_args = array('post_type' => 'artist' , 'posts_per_page' => '-1' );
			$art_query = new WP_Query($art_args);
			
			while ( $art_query->have_posts() ) : $art_query->the_post();
				//
				//Reset index of postIDs
				$i=0;
				$post_ids = array();
				
				//Adding this post to post index
				$this_post = get_the_ID();
				$post_nums[$i] = $this_post;
				
				$artist_title = get_the_title();
				$artist_class = sr_make_class($artist_title);
				$artists[$j] = array('title' => $artist_title , 'class' => $artist_class); 
				
				//get the videos
				sr_media_videos($dont_copy_vid , $artist_class);
				
				//increment post index
				$i++;
				//increment artist index
				$j++;
				
				//Release sub query
				//$artist_tax = get_the_title();
				$rel_args = array('post_type' => 'release' , 'artist' => $artist_title , 'posts_per_page' => '-1');
				$rel_query = new WP_query($rel_args);
				
				if(have_posts()): while ( $rel_query->have_posts() ) : $rel_query->the_post();
					
					//Adding this post to post index
					$this_post = get_the_ID();
					$post_nums[$i] = $this_post;
					
					//get the videos		
					sr_media_videos($dont_copy_vid , $artist_class);
					
					//increment post index
					$i++;
					
				endwhile; endif;
				
				foreach($post_nums as $post_num)
				{	
					$a_class = $artist_class . ' fancy-roll lightbox photo';
					$options = array('size' => 'sr-media-fourcol', 'post_id' => $post_num, 'wrapper' => false, 'a_class' => $a_class, 'a_rel' => 'gallery-media' );
					sr_get_images($options);
				}
			endwhile;
			
			//Flickr
			
			$flickrrequest = 'http://api.flickr.com/services/feeds/photos_public.gne?id=8546357@N03&format=json';
			$flickrci = curl_init($flickrrequest);
			curl_setopt($flickrci,CURLOPT_RETURNTRANSFER, TRUE);
			$flickrinput = curl_exec($flickrci);
			curl_close($flickrci);
						
			$flickrinput = str_replace('jsonFlickrFeed(','',$flickrinput);
			$flickrinput = str_replace('})','}',$flickrinput);
						
			$flickrvalue = json_decode($flickrinput,true);
			$flickritems =  $flickrvalue['items'];
			
			foreach ($flickritems as $flickritem){
			
				$img_m = $flickritem['media']['m'];
				$img = str_replace('_m.jpg' , '' , $img_m); ?>
				<a class="fancy-roll lightbox flickr" href="<?php echo $img; ?>_b.jpg" rel="fuckface">
					<img src="<?php echo $img; ?>_n.jpg" />
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
	$filter_string .= '<li class="filter-item artist"><a href="#" data-filter=".' . $artist['class'] . '">' . $artist['title'] . '</a></li>';
}
$filter_string .= '</ul><ul class="media-list filter-list"><li class="filter-item media"><a href="#" data-filter="*" class="selected">All media</a></li><li class="filter-item media"><a href="#" data-filter=".video">Videos</a></li><li class="filter-item media"><a href="#" data-filter=".photo">Photos</a></li><li class="filter-item media flickr"><a href="#" data-filter=".flickr" class="flickr-filter">Flickr</a><a class="flickr-link" href="http://www.flickr.com/photos/stolenrecordings" target="_blank" title="Go to Stolen Recordings Flickr" >Stolenrecs on Flickr</a></li></ul>';
?>
<script type="text/javascript"> 
	var filterString = '<?php echo $filter_string; ?>';
</script> 
		</ul>
	</div>
	
<?php get_footer(); ?>