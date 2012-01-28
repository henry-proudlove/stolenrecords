<?php /* Start the Loop */?>

<div id="images"></div>


<?php

function endpoint_gen($url){
		if(strpos($url , 'vimeo.com'))
		{
			$video_id = substr($url , 17);
			$video_endpoint = 'http://vimeo.com/api/v2/video/' . $video_id . '/videos.xml';
			$vendor = 'vimeo';  
			
		}elseif (strpos($url , 'youtu.be'))
		{
			$video_id = substr($url , 16);
			$video_endpoint = 'http://gdata.youtube.com/feeds/api/videos/' . $video_id;
			$vendor = 'youtube';
		} 
		return array('id' => $video_id , 'endpoint' => $video_endpoint , 'vendor' => $vendor);
}

function api_call($node){
	function curl_get($url) {
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			//curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			$return = curl_exec($curl);
			curl_close($curl);
			return $return;
		}
		
	$video_data = simplexml_load_string(curl_get($node));
	return $video_data;
}
/*function _sr_video($videoURL)
{
	 
	function endpoint_gen($url){
		if(strpos($url , 'vimeo.com'))
		{
			$video_id = substr($url , 17);
			$video_endpoint = 'http://vimeo.com/api/v2/video/' . $video_id . '/videos.xml';
			$vendor = 'vimeo';  
			
		}elseif (strpos($url , 'youtu.be'))
		{
			$video_id = substr($url , 16);
			$video_endpoint = 'http://gdata.youtube.com/feeds/api/videos/' . $video_id;
			$vendor = 'youtube';
		} 
		return array('id' => $video_id , 'endpoint' => $video_endpoint , 'vendor' => $vendor);
	}
	
	$node = endpoint_gen($videoURL);
	
	function curl_get($url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		$return = curl_exec($curl);
		curl_close($curl);
		return $return;
	}
	
	$video_data = simplexml_load_string(curl_get($node['endpoint']));
	
	function parse_info($vid_dat){
		if($vendor == 'vimeo'){
			$vid_dat = $vid_dat->video;
			$video_title = $vid_dat->title;
			$video_thumbnail = $vid_dat->thumbnail_large;
			$video_description = strip_tags($vid_dat->description);
		}elseif($vendor == 'youtube'){
			$video_title = $vid_dat->title;
			$video_thumbnail = 'http://img.youtube.com/vi/'. $node['id'] .'/0.jpg';
			$video_description = strip_tags($vid_dat->content);
		}
		return array('title' => $video_title , 'thumbnail' => $video_thumbnail , 'description' => $video_description);
	}
	
	$video_nodes = parse_info($video_data);
	return $video_nodes;
}*/



//Getting data vid URLs from database

$art_args = array('post_type' => 'artist' , 'posts_per_page' => '-1');
$dont_copy_vid = array();
$videos = array();
$i = 0;
$art_query = new WP_Query($art_args);

while ( $art_query->have_posts() ) : $art_query->the_post();
	
	$artist = get_the_title();
	global $video_mb;
	$meta = $video_mb->the_meta();
	
	foreach ($meta['videos'] as $videometa)
	{	
		$video = $videometa['video-link'];
		if(!in_array($dont_copy_vid, $video)){
			$dont_copy_vid[$i] = $video;
			$videos[$i] = endpoint_gen($video);
			$i++;
			echo $videos[$i];
		}
	}
	
endwhile;
print_r($videos);
$i=0;
foreach($videos as $video)
{
  echo $video['endpoint'] . '</br>';
  print_r($data[$i]);
}
?>