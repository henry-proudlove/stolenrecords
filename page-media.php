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
				$a_class = $artist . ' fourcol fancy-roll lightbox photo';
				$options = array('size' => 'sr-media-fourcol', 'post_id' => $post_num, 'wrapper' => false, 'a_class' => $a_class, 'a_rel' => 'gallery-media' );
				sr_get_images($options);
			}
		endwhile;?>
	
	</div><!-- #content -->
	<div class="filter">
		<header class="filter-header"><h1 class="filter-title">Filter<h1></header>
			<ul class="filter-list">
				<li>
					<ul class="artist-list">
						<?php 
							foreach($artists as $artist){
								echo '<li class="filter-item artist"><a href="#" data-filter=".' . $artist['class'] . '">' . $artist['title'] . '</a></li>';
							}
						?>
					</ul>
				</li>
				<li>
					<ul class="media-list">
						<li class="filter-item media"><a href="#" data-filter=".video">Videos</a></li>
						<li class="filter-item media"><a href="#" data-filter=".photo">Photos</a></li>
						<li class="filter-item media"><a href="#" data-filter=".flickr">Flickr</a></li>
					</ul>
				</li>
			</ul><!--.filter-list-->
	</div>
	
<?php get_footer(); ?>