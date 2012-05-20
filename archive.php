<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

<div id="content" class="offset">
	<?php the_post(); ?>
	<div id="primary" class="eightcol shim-right">
	<header class="results-header">
		<h1 class="results-title">
		<?php if ( is_day() ) : ?>
			<?php printf( __( 'Daily Archives: <span>%s</span>', 'themename' ), get_the_date() ); ?>
		<?php elseif ( is_month() ) : ?>
			<?php printf( __( 'Posts from <span>%s</span>', 'themename' ), get_the_date( 'F Y' ) ); ?>
		<?php elseif ( is_year() ) : ?>
			<?php printf( __( 'Yearly Archives: <span>%s</span>', 'themename' ), get_the_date( 'Y' ) ); ?>
		<?php else : ?>
			<?php _e( 'Blog Archives', 'themename' ); ?>
		<?php endif; ?>
		</h1>
		<?php sr_get_news_page_link(); ?>
	</header>

	<?php rewind_posts(); ?>

	<?php get_template_part( 'loop', 'archive' ); ?>

<?php get_sidebar(); ?>
</div><!-- #content -->
<?php get_footer(); ?>