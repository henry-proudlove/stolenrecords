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
		<aside id="stolen-listen" class="listen">
			<h2 class="aside-header">Listen</h2>
			<div class="sc-player">
				<a href="http://soundcloud.com/cityshantyband">Stolen on Soundcloud</a>
		</aside><!--#stolen-listen-->
			
		<?php sr_aside_shows('', true) ?>
		<div id="social-tabs">
			<ul>
				<li><a href="#twitter">Twitter</a></li>
				<li><a href="#latest-videos">Videos</a></li>
				<li><a href="#facebook">Facebook</a></li>
			</ul>
			<?php sr_index_fb(); ?>
			<?php sr_latest_videos(); ?>
			<?php sr_latest_tweets(); ?>
		</div><!--#social-tabs-->
	</div><!--#sidebar-->
</div><!-- #content -->
<?php get_footer(); ?>