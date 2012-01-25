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
			array_push($vid_arr , $video);?>
			<p><a href="<?php echo $video;?>" class="video"><?php echo $video; ?></a></p>
		<?php }
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
				array_push($vid_arr , $video);?>
				<p><a href="<?php echo $video;?>" class="video"><?php echo $video; ?></a></p>
			<?php }
		}
	endwhile;
endwhile;
print_r($vid_arr);
$endpoint_arr = array();
foreach ($vid_arr as $video)
{	
	if(strpos($video , 'vimeo.com'))
	{
		$video = substr($video , 17);
		$api_endpoint = 'http://vimeo.com/api/v2/video/' . $video . '/videos.xml';
		array_push($endpoint_arr, $api_endpoint);
		
	}elseif (strpos($video , 'youtu.be'))
	{
		$video = substr($video , 16);
		$api_endpoint = 'http://gdata.youtube.com/feeds/api/videos/' . $video;
		array_push($endpoint_arr, $api_endpoint);
	}
}
print_r($endpoint_arr);
//Fetching the data

$nodes = $endpoint_arr;
$node_count = count($nodes);

$curl_arr = array();
$master = curl_multi_init();

for($i = 0; $i < $node_count; $i++)
{
	$url =$nodes[$i];
	$curl_arr[$i] = curl_init($url);
	curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
	curl_multi_add_handle($master, $curl_arr[$i]);
}

do {
	curl_multi_exec($master,$running);
} while($running > 0);

//Poplulating results

for($i = 0; $i < $node_count; $i++)
{
	$vid_data[$i] = simplexml_load_string(curl_multi_getcontent  ( $curl_arr[$i]  ));
}

print_r($vid_data);
$vid_data_count = count($vid_data);
echo '</br>Video count: '.$vid_data_count.'</br>'

?>