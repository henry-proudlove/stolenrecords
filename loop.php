<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>

<?php /* Start the Loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
		<header class="entry-header">
			
			<time class="entry-date"><?php echo get_the_date(); ?></time>
			
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			
		</header><!-- .entry-header -->
			
		<?php 
		global $thumb_mb;
		$meta = $thumb_mb->the_meta();
		if(has_post_thumbnail()|| $meta["thumb-URL"]):?>
			<div class="post-img">
			<?php if($meta["thumb-URL"])
				echo $meta["thumb-URL"];
			else
				the_post_thumbnail();?>
			</div><!--#post-img-->
		<?php endif; ?>
		
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	</article><!-- #post-<?php the_ID(); ?> -->

	<?php comments_template( '', true ); ?>

<?php endwhile; ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<nav id="nav-below" role="article">
		<h1 class="section-heading"><?php _e( 'Post navigation', 'themename' ); ?></h1>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'themename' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'themename' ) ); ?></div>
	</nav><!-- #nav-below -->
<?php endif; ?>
