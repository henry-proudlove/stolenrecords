<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<?php /* Start the Loop */?>

<div id="images"></div>

<?php //Getting data vid URLs from database
function sr_get_videos($videos){
	$i=0;
	$videos_count = count($videos);
	
	for($i = 0; $i < $videos_count; $i++)
	{	
		$video_link = $videos[$i]['video_link'];
		if(strpos($video_link , 'vimeo.com'))
		{
			$video_id = substr($video_link , 17);
			$videos[$i]['id'] = $video_id;
			$videos[$i]['endpoint'] = 'http://vimeo.com/api/v2/video/' . $video_id  . '/videos.xml';
			$videos[$i]['vendor'] = 'vimeo';
			
		}elseif (strpos($video_link , 'youtu.be'))
		{	
			$video_id = substr($video_link , 16);
			$videos[$i]['id'] = $video_id;
			$videos[$i]['endpoint'] = 'http://gdata.youtube.com/feeds/api/videos/' . $video_id ;
			$videos[$i]['vendor'] = 'youtube';
		}
	}
	
	//Fetching the data
	
	$curl_arr = array();
	$master = curl_multi_init();
	
	for($i = 0; $i < $videos_count; $i++)
	{
		$url = $videos[$i]['endpoint'];
		$curl_arr[$i] = curl_init($url);
		curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
		curl_multi_add_handle($master, $curl_arr[$i]);
	}
	
	do {
		curl_multi_exec($master,$running);
	} while($running > 0);
	
	//Poplulating results
	
	for($i = 0; $i < $videos_count; $i++)
	{	
		$vid_data = simplexml_load_string(curl_multi_getcontent  ( $curl_arr[$i]  ));
		//$videos[$i]['data'] = simplexml_load_string(curl_multi_getcontent  ( $curl_arr[$i]  ));
		if($videos[$i]['vendor'] == 'vimeo'){
			$vid_data = $vid_data->video;
			$videos[$i]['title'] = (string) $vid_data->title;
			$videos[$i]['thumbnail'] = (string) $vid_data->thumbnail_large;
			$videos[$i]['description'] = (string) strip_tags($vid_data->description);
		}elseif($videos[$i]['vendor'] == 'youtube'){
			$videos[$i]['title'] = (string) $vid_data->title;
			$videos[$i]['thumbnail'] = (string) 'http://img.youtube.com/vi/'. $videos[$i]['id'] .'/0.jpg';
			$videos[$i]['description'] = (string) strip_tags($vid_data->content);
		}
	}
	
	print_r($videos);
}

global $video_mb;

$videos = array();
$dont_copy = array();
$art_args = array('post_type' => 'artist' , 'posts_per_page' => '-1');
$art_query = new WP_Query($art_args);

while ( $art_query->have_posts() ) : $art_query->the_post();

	$meta = $video_mb->the_meta();
	$post_id = $post->ID;
	
	foreach ($meta['videos'] as $video_meta)
	{	
		$video_link = $video_meta['video-link'];
		if(!in_array($video_link , $dont_copy)){
			array_push($dont_copy , $video_link);
			$video = array('artist' => $artist , 'video_link' => $video_link);
			array_push($videos, $video);
		}
	}
	
	//Release sub query
	$artist_tax = get_the_title();
	$rel_args = array('post_type' => 'release' , 'artist' => $artist_tax , 'posts_per_page' => '-1');
	
	$rel_query = new WP_query($rel_args);
	while ( $rel_query->have_posts() ) : $rel_query->the_post();
	
		$meta = $video_mb->the_meta();
		foreach ($meta['videos'] as $video_meta)
		{	
			$video_link = $video_meta['video-link'];
			if(!in_array($video_link , $dont_copy)){
				array_push($dont_copy , $video_link);
				$video = array('artist' => $artist , 'video_link' => $video_link);
				array_push($videos, $video);
			}
		}
		
	endwhile;
	
endwhile;
$result = sr_get_videos($videos);

print_r($result);