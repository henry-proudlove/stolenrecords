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
			
			<? _sr_post_header(); ?>
			
		</header><!-- .entry-header -->
			
		<?php sr_post_thumbnail() ?>
		
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->

	</article><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; ?>

<?php sr_posts_navigation(); ?>
