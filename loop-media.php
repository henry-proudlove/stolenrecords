<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<?php /* Start the Loop */?>

<div id="images"></div>

<?php //Getting data vid URLs from database

$art_args = array('post_type' => 'artist' , 'posts_per_page' => '-1');
$vid_arr = array;
$art_query = new WP_Query($art_args);

while ( $art_query->have_posts() ) : $art_query->the_post();

	global $video_mb;
	$meta = $video_mb->the_meta();
	
	foreach ($meta['videos'] as $videos)
	{	
		$video = $videos['video-link'];
		if(!in_array($video , $vid_arr)){
			array_push($vid_arr , $video);
		}
	}
	
	//Release sub query
	$artist_tax = get_the_title();
	$rel_args = array('post_type' => 'release' , 'artist' => $artist_tax , 'posts_per_page' => '-1');
	$rel_query = new WP_query($rel_args);
	while ( $rel_query->have_posts() ) : $rel_query->the_post();
		global $video_mb;
		$meta = $video_mb->the_meta();
		foreach ($meta['videos'] as $videos)
		{	
			$video = $videos['video-link'];
			if(!in_array($video , $vid_arr)){
				array_push($vid_arr , $video);
			}
		}
		
	endwhile;
	
endwhile;

//Constructing Endpoints from urls
$vendors = array();
$nodes = array();

foreach ($vid_arr as $video)
{	
	if(strpos($video , 'vimeo.com'))
	{
		$video = substr($video , 17);
		$api_endpoint = 'http://vimeo.com/api/v2/video/' . $video . '/videos.xml';
		array_push($nodes, $api_endpoint);
				
	}elseif (strpos($video , 'youtu.be'))
	{
		$video = substr($video , 16);
		$api_endpoint = 'http://gdata.youtube.com/feeds/api/videos/' . $video;
		array_push($nodes, $api_endpoint);
	}
}
//Fetching the data

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

print_r($vid_data[0]->video);

for($i = 0; $i < $vendors_count; $i++)
{	
	$video = $vid_data[$i]->video ?>
	<article class="media-thumb video">
		<a>
			<img src="<?php echo $video->thumbnail_large ?>" class="thumb-img" />
			<div class="thumb-desc">
				<h1 class="thumb-attr"><?php echo $video->title; ?> </h1>
				<cite class="thumb-title"><?php echo strip_tags($video->description); ?></cite>
			</div>
		</a>
	</article><!--.media-thumb-->
<?php
}?>
