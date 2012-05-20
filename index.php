<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

<div id="content" class="offset clearfix">
	<div id="primary" class="eightcol shim-right">
		<?php get_template_part( 'loop', 'news' ); ?>
		<?php sr_posts_navigation(); ?>
	</div><!--#primary-->
		<?php get_sidebar(); ?>
</div><!--#content-->
<?php get_footer(); ?>