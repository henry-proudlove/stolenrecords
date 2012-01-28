<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<?php /* Start the Loop */?>

<div id="images"></div>

<?php

global $video_mb;

//$videos = array();
$dont_copy_vid = array();
$art_args = array('post_type' => 'artist' , 'posts_per_page' => '-1');
$art_query = new WP_Query($art_args);

while ( $art_query->have_posts() ) : $art_query->the_post();
	sr_media_videos($dont_copy_vid);
	
	//Release sub query
	$artist_tax = get_the_title();
	
	$rel_args = array('post_type' => 'release' , 'artist' => $artist_tax , 'posts_per_page' => '-1');
	$rel_query = new WP_query($rel_args);
	
	while ( $rel_query->have_posts() ) : $rel_query->the_post();
		sr_media_videos($dont_copy_vid);
	endwhile;
endwhile;