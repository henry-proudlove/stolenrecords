<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>


<?php /* Start the Loop */ ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
		<header class="entry-header">
			<time class="entry-date"><?php echo get_the_date(); ?></time>
			
			<? _sr_post_header(); ?>
			
		</header><!-- .entry-header -->
			
		<?php sr_post_thumbnail('medium' , true); ?>
		
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	</article><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; else:?>
	<article id="no-posts" <?php post_class(); ?> role="article">
		<header class="entry-header">
			<h1 class="entry-title">Sorry, no posts!</h1>
		</header><!-- .entry-header -->
		
		<div class="entry-summary">
			<p>Try the <a title="Home Page Link" rel="bookmark" href="<?php get_home_url(); ?>">home page</a></p>
		</div><!-- .entry-summary -->

	</article><!-- #post-<?php the_ID(); ?> -->
<?php endif; ?>

<?php sr_posts_navigation(); ?>