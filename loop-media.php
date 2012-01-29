<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<?php /* Start the Loop */?>

<?php

//Arrray to rule out dulplicate vids
$dont_copy_vid = array();

//Get all vids attached to artist + all releases in artist tax
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$art_args = array('post_type' => 'artist' , 'posts_per_page' => '2' , 'paged' => $paged);
$art_query = new WP_Query($art_args);

while ( $art_query->have_posts() ) : $art_query->the_post();
	
	_sr_post_header();
	//Reset index of postIDs
	$i=0;
	$post_ids = array();
	
	//Adding this post to post index
	$this_post = get_the_ID();
	$post_nums[$i] = $this_post;
	
	//get the videos
	sr_media_videos($dont_copy_vid);
	
	//increment post index
	$i++;
	
	//Release sub query
	$artist_tax = get_the_title();
	$rel_args = array('post_type' => 'release' , 'artist' => $artist_tax , 'posts_per_page' => '-1');
	$rel_query = new WP_query($rel_args);
	
	if(have_posts()): while ( $rel_query->have_posts() ) : $rel_query->the_post();
		
		//Adding this post to post index
		$this_post = get_the_ID();
		$post_nums[$i] = $this_post;
		
		//get the videos		
		sr_media_videos($dont_copy_vid);
		
		//increment post index
		$i++;
		
	endwhile; endif;
	
	foreach($post_nums as $post_num)
	{
		wpo_get_images('medium', '0', '0', 'large', $post_num, '1', 'media-thumb photo attachment-image', '0', '0');
	}
endwhile;?>

<?php sr_posts_navigation() ?>