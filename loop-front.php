<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<section id="latest" class="twelvecol">
<h2 class="section-header">Latest</h2>
<div class="slider">
<?php /* 'Lastet' section of index */

$args = array( 'posts_per_page' => '5' , 'meta_key' => '_sr_featured-post' , 'post_type' => array( 'post', 'show', 'artist', 'release' ) );

$the_query = new WP_Query($args);
$dont_copy = array();
while ( $the_query->have_posts() ) : $the_query->the_post();?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class('nested'); ?> role="article">		
		
		<?php
		if('post' == get_post_type()){
			array_push($dont_copy, $post->ID);
		}?>
		<div class="sixcol left vert-cent box-pack">
			<div>
				<header class="entry-header">
				
					<time class="entry-date"><?php echo get_the_date(); ?></time>
					<?php _sr_post_header(); ?>
				
				</header><!-- .entry-header -->
				
				<div class="entry-summary">
					<?php 
						$excerpt = get_the_excerpt();
						//$excerpt = sr_truncate($excerpt, 250, ' ');
						echo '<p class="big-center">' . $excerpt . '</p>' ;
						echo '<a href="'. get_permalink($post->ID) . '" class="read-more button button-large">read more</a>';
					?>
				</div><!-- .entry-summary -->
			</div>
		</div>
		<div class="sixcol right">
			<?php sr_post_thumbnail('sr-sixcol' , true, 'parent');?>
		</div>

	</article><!-- #post-<?php the_ID(); ?> -->

<?php endwhile;?>
</div>
</section><!--#slider-->

<section id="news-feed" class="eightcol shim-right nested">
	<h2 class="section-header">News</h2>
	<div id="news-long">
	
	<?php /* Index 'News' section 3 posts with image */
	
		$args = array('posts_per_page' => '4' , 'post__not_in' => $dont_copy);
		$the_query = new WP_Query($args);
		while ( $the_query->have_posts() ) : $the_query->the_post();?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">		
			
			<div class="twocol">
				<?php sr_post_thumbnail('thumbnail' , false, 'parent');
				array_push($dont_copy, $post->ID); ?>
			</div>
			<div class="sixcol">
				<header class="entry-header">
				
					<time class="entry-date"><?php echo get_the_date(); ?></time>
					
					<?php _sr_post_header('h2'); ?>
				
				</header><!-- .entry-header -->
				
				<div class="entry-summary">
					<?php the_excerpt(); ?>
				</div><!-- .entry-summary -->
			</div>
		</article><!-- #post-<?php the_ID(); ?> -->
		<?php endwhile;?>
	
	</div><!--#news-long-->
	<div id="news-trunc">
	
	<?php /* 3 posts without image */
	
		$args = array('posts_per_page' => '3' , 'post__not_in' => $dont_copy);
		$the_query = new WP_Query( $args );
		while ( $the_query->have_posts() ) : $the_query->the_post();?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<header class="entry-header">
				
				<time class="entry-date twocol"><?php echo get_the_date(); ?></time>
				
				<?php _sr_post_header('h2' , 'sixcol'); ?>
				
			</header><!-- .entry-header -->
		
		</article><!-- #post-<?php the_ID(); ?> -->
		
		<?php endwhile; ?>
	</div><!--#news-trunc-->
</section><!--#news-feed-->