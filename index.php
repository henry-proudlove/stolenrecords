<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

		<div id="primary">
			<div id="content">
				<?php //get_template_part('loop' , 'releases');?> 
				<?php //get_template_part('loop' , 'artists');?>
				<?php //get_template_part('loop' , 'index');?>
				<?php // get_template_part('loop' , 'news');?>
				<?php //get_template_part('loop' , 'shows');?>
				<?php //get_template_part('loop' , 'showsarchive');?>
				<?php //get_template_part('aside' , 'shows');?>
				<?php //get_template_part( 'loop' ); ?>
				<?php _sr_latest_videos(); ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>