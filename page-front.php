<?php
/**
 * Template Name: Index Page
 * Description: Holder for Main Page
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

<div id="content" class="clearfix offset">
	<?php get_template_part('loop' , 'index');?>
	<div id="sidebar" class="fourcol shim-left">
		<?php sr_aside_shows('', true) ?>
		<div id="social-tabs">
			<ul>
				<li><a href="#facebook">Facebook</a></li>
				<li><a href="#latest-videos">Videos</a></li>
				<li><a href="#twitter">Twitter</a></li>
			</ul>
			<?php sr_index_fb(); ?>
			<?php sr_latest_videos(); ?>
			<?php sr_latest_tweets(); ?>
		</div><!--#social-tabs-->
	</div><!--#sidebar-->
</div><!-- #content -->
		
<?php get_footer(); ?>