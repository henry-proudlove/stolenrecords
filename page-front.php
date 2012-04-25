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
	<?php get_template_part('loop' , 'front');?>
	<?php 
		$args = array('thumb_size' => 'sr-twocol', 'limit' => '4' , 'title' => true );
		sr_rels_by_artist($args);
	?>
	</div><!--#wrapper-->
	<div id="sidebar" class="fourcol shim-left">
		<aside id="stolen-listen" class="listen">
			<h2 class="aside-header">Listen</h2>
			<div class="sc-player">
				<a href="http://soundcloud.com/cityshantyband">Stolen on Soundcloud</a>
		</aside><!--#stolen-listen-->
			
		<?php sr_aside_shows('', true) ?>
		<aside id="follow">
			<h2 class="aside-header">Follow</h2>
			<div id="social-tabs">
				<ul>
					<li><a id="twitter-tab" href="#twitter">Twitter</a></li>
					<li><a id="vimeo-tab" href="#latest-videos">Videos</a></li>
					<li><a id="facebook-tab" href="#facebook">Facebook</a></li>
				</ul>
				<?php sr_index_fb(); ?>
				<?php sr_latest_tweets(); ?>
				<div id="latest-videos">
					<div id="thumbs">
						<ul class="img-list clearfix"></ul>
					</div>
				</div><!--#latest-videos-->
			</div><!--#social-tabs-->
		</aside><!--#follow-->
	</div><!--#sidebar-->
</div><!-- #content -->
<?php get_footer(); ?>