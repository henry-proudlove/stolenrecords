<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

	<div id="content">

		<?php the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content clearfix">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->

	</div><!-- #content -->

<?php get_footer(); ?>