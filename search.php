<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

	<div id="content" class="offset">
	<div id="primary" class="eightcol shim-right">
	<header class="results-header">
			<h1 class="results-title"><?php printf( __( 'Search Results for: %s', 'themename' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			<?php sr_get_news_page_link(); ?>
		</header>
	<?php if ( have_posts() ) : ?>
		<?php get_template_part( 'loop', 'search' ); ?>

	<?php else : ?>

		<article id="post-0" class="post no-results not-found" role="article">
			<header class="entry-header">
				<h1 class="entry-title medium-h"><?php _e( 'Sorry, no Posts', 'themename' ); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<p><?php _e( 'Sorry, but nothing matched your search. Please try again.', 'themename' ); ?></p>
			</div><!-- .entry-content -->
		</article><!-- #post-0 -->

	<?php endif; ?>
	</div><!--#primary-->

<?php get_sidebar(); ?>
</div><!-- #content -->
<?php get_footer(); ?>