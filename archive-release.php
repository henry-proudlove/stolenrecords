<?php
/**
 * @package WordPress
 * @subpackage themename
 */
get_header(); ?>
<div id="content">
<?php /* Start the Loop */

$args = array('post_type' => 'release' , 'orderby' => 'meta_value_num', 'meta_key' => '_sr_release-date' , 'posts_per_page' => '-1');

//Array of artists
$artists = array();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$wp_query = new WP_Query($args);

while ( $wp_query->have_posts() ) : $wp_query->the_post();

	sr_relart_loop_markup();
	
	$artist_tax = get_the_terms( $post->ID, 'artist' );
	foreach($artist_tax as $artist){
		$artist = array('title' => $artist->name , 'class' => $artist->slug);
		if(!in_array($artist , $artists)){
			array_push($artists, $artist);	
		}
	}
	
endwhile;

//sr_posts_navigation();?>

</div><!-- #content -->
<div class="filter">
		<header class="filter-header"><h1 class="filter-title">Filter<h1></header>
		<ul class="filter-list">
			<?php 
				foreach($artists as $artist){
					echo '<li class="filter-item artist"><a href="#" data-filter=".' . $artist['class'] . '">' . $artist['title'] . '</a></li>';
				}
			?>
		</ul><!--.filter-list-->
	</div>

<?php get_footer(); ?>
