<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<section id="latest">

<?php /* Start the Loop */

$args = array( 'posts_per_page' => '5' , 'meta_key' => '_sr_featured-post' , 'post_type' => array( 'post', 'show', 'artist', 'release' ) );

$the_query = new WP_Query($args);
$dont_copy = array();
while ( $the_query->have_posts() ) : $the_query->the_post();?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">		
		
		<?php
		if('post' == get_post_type()){
			array_push($dont_copy, $post->ID);
		}
		sr_post_thumbnail(); 
		?>
			
		<header class="entry-header">
		
			<time class="entry-date"><?php echo get_the_date(); ?></time>
			<?php echo get_post_type(); ?>
			<?php _sr_post_header(); ?>
		
		</header><!-- .entry-header -->
		
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	</article><!-- #post-<?php the_ID(); ?> -->

<?php endwhile;?>

</section><!--#latest-->
</br>
<div id="news-long">

<?php /* Start the Loop */
	$args = array('posts_per_page' => '3' , 'post__not_in' => $dont_copy);
	$the_query = new WP_Query($args);
	while ( $the_query->have_posts() ) : $the_query->the_post();?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">		
		
		<?php sr_post_thumbnail(); 
		array_push($dont_copy, $post->ID); ?>
			
		<header class="entry-header">
		
			<time class="entry-date"><?php echo get_the_date(); ?></time>
			
			<?php _sr_post_header(); ?>
		
		</header><!-- .entry-header -->
		
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	</article><!-- #post-<?php the_ID(); ?> -->
<?php endwhile;?>

</div><!--#news-long-->
</br>

<div id="news-trunc">

<?php $args = array('posts_per_page' => '3' , 'post__not_in' => $dont_copy);
	$the_query = new WP_Query( $args );
	while ( $the_query->have_posts() ) : $the_query->the_post();?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
		<header class="entry-header">
			
			<time class="entry-date"><?php echo get_the_date(); ?></time>
			
			<?php _sr_post_header(); ?>
			
		</header><!-- .entry-header -->

	</article><!-- #post-<?php the_ID(); ?> -->

	<?php endwhile; ?>
</div><!--#news-trunc-->

