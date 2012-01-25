<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<?php /* Start the Loop */?>

<div id="images"></div>
<?php
$art_args = array('post_type' => 'artist');
$vid_arr = array();
//global $wp_embed;
//print_r($wp_embed);

//$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$art_query = new WP_Query($art_args);

while ( $art_query->have_posts() ) : $art_query->the_post();
	
	_sr_post_header();
	global $video_mb;
	$meta = $video_mb->the_meta();
	
	foreach ($meta['videos'] as $videos)
	{	
		$video = $videos['video-link'];
		if(!in_array($video , $vid_arr)){
			array_push($vid_arr , $video);
			//echo wp_oembed_get($video);
			//print_r($embed_code);
			?><p><a href="<?php echo $video;?>" class="video"><?php echo $video; ?></a></p><?php
		}
	}
	
	//Release sub query
	$artist_tax = get_the_title();
	$rel_args = array('post_type' => 'release' , 'artist' => $artist_tax);
	$rel_query = new WP_query($rel_args);
	
	while ( $rel_query->have_posts() ) : $rel_query->the_post();
		_sr_post_header();
		global $video_mb;
		$meta = $video_mb->the_meta();
		
		foreach ($meta['videos'] as $videos)
		{	
			$video = $videos['video-link'];
			if(!in_array($video , $vid_arr)){
				array_push($vid_arr , $video);
				//echo wp_oembed_get($video);
				//print_r($embed_code);
				?><p><a href="<?php echo $video;?>" class="video"><?php echo $video; ?></a></p><?php
			}
		}
	endwhile;
echo'</br></br>';
endwhile;?>