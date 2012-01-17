<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>
<div id="news-long">

<?php /* Start the Loop */
	$the_query = new WP_Query( 'posts_per_page=3' );
	$dont_copy = array();
	while ( $the_query->have_posts() ) : $the_query->the_post();
	array_push($dont_copy, $post->ID);?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">		
		<?php 
			global $thumb_mb;
			$meta = $thumb_mb->the_meta();
			if(has_post_thumbnail()|| $meta["thumb-URL"]):?>
			<div class="post-img">
			<?php if($meta["thumb-URL"]):
				echo $meta["thumb-URL"];
			else:
				the_post_thumbnail();
			endif;?>
			</div><!--.post-img-->
		<?php endif; ?>
			
		<header class="entry-header">
		
			<time class="entry-date"><?php echo get_the_date(); ?></time>
			
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		
		</header><!-- .entry-header -->
		
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	</article><!-- #post-<?php the_ID(); ?> -->
	
	<?php endwhile;?>
	
</div><!--#news-long-->
<div id="news-trunc">
	
	<?php $the_query = new WP_Query( 'posts_per_page=6' );
	while ( $the_query->have_posts() ) : $the_query->the_post();
	if(!in_array($post->ID , $dont_copy )): ?>
	
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
		<header class="entry-header">
			
			<time class="entry-date"><?php echo get_the_date(); ?></time>
			
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			
		</header><!-- .entry-header -->

	</article><!-- #post-<?php the_ID(); ?> -->
	
	<?php endif; ?>

	<?php endwhile; ?>
</div><!--#news-trunc-->