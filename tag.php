<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

	<div id="content" class="offset">
		<div id="primary" class="eightcol shim-right">
		<header class="results-header">
			<h1 class="results-title"><?php printf( __( 'Posts tagged: %s', 'themename' ), '<span>' . single_tag_title( '', false ) . '</span>' );?></h1>
		<?php sr_get_news_page_link(); ?>
		</header>
					<?php the_post(); ?>
					<?php rewind_posts(); ?>
					<?php get_template_part( 'loop', 'tag' ); ?>
		</div><!-- #primary -->

<?php get_sidebar(); ?>
</div><!-- #content -->
<?php get_footer(); ?>