<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<div id="news-long">
<?php /* Start the Loop */

	$args = array('post_type' => 'artist' , 'posts_per_page' => '-1' , 'orderby' => 'title' , 'order' => 'ASC' , 'meta_key' => '_sr_present-past', 'meta_value' => 'current');
	
	$the_query = new WP_Query($args);

	while ( $the_query->have_posts() ) : $the_query->the_post();?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class('current'); ?> role="article">		
		
		<?php echo get_post_meta(get_the_ID(),'_sr_present-past',TRUE);
		
		if ( has_post_thumbnail() ) {
		  the_post_thumbnail();
		} ?>
		
		<header class="entry-header">
			
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		
		</header><!-- .entry-header -->
		
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	</article><!-- #post-<?php the_ID(); ?> -->
	<?php endwhile;
	
	$args = array('post_type' => 'artist' , 'posts_per_page' => '-1' , 'orderby' => 'title' , 'order' => 'ASC' , 'meta_key' => '_sr_present-past', 'meta_value' => 'past');
	
	$the_query = new WP_Query($args);

	while ( $the_query->have_posts() ) : $the_query->the_post();?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class('past'); ?> role="article">		
		
		<?php echo get_post_meta(get_the_ID(),'_sr_present-past',TRUE);
		
		if ( has_post_thumbnail() ) {
		  the_post_thumbnail();
		} ?>
		
		<header class="entry-header">
			
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		
		</header><!-- .entry-header -->
		
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	</article><!-- #post-<?php the_ID(); ?> -->
	<?php endwhile;?>
	
</div><!--#news-long-->