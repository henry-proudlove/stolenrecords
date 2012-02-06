<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

<div id="content">
	<?php get_template_part('loop' , 'index');?>
	<div id="sidedbar">
		<?php sr_aside_shows('', true) ?>
		<?php  sr_index_fb(); ?>
		<?php _sr_latest_videos(); ?>
		<?php sr_latest_tweets(); ?>
	</div><!--#sidebar-->
</div><!-- #content -->
		
<?php get_footer(); ?>