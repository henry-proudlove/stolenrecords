<?php
/**
 * Template Name: About Page
 * Description: Shows Artist page style layout, with contact form below
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

	<div id="content">

		<?php the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('twelvecol'); ?> role="article">
			<header class="entry-header">
				<h1 class="entry-title big-h">Stolen Recordings</h1>
			</header><!-- .entry-header -->
			<div class="entry-gallery">
					<?php //sr_artist_gallery('null'); ?>
					<?php the_post_thumbnail($post->ID , 'sr-twelvecol'); ?>
				</div><!-- .entry-gallery -->
			<div id="content-holder">
					<div class="entry-content big-center expander">
						<?php the_content(); ?>
					</div><!-- .entry-content -->
					<?php sr_social_links(false, false); ?>
				</div>
		</article><!-- #post-<?php the_ID(); ?> -->
		
		<?php 
			global $review_mb;
			$meta = $review_mb->the_meta();
			$reviews = $meta['reviews'];
			if($reviews): ?>
			<section id="reviews" class="twelvecol">
				<div class="slider">
					<?php sr_get_reivews($reviews); ?>
				</div>
			</section><!--#reviews-->
			<?php endif; ?>
			
		<section id="contact" class="clearfix">
		<div class="releases-divider"></div>
			<div id="general-contact" class="fourcol">
				<?php echo do_shortcode('[contact-form-7 id="1263" title="Contact"]'); ?>
			</div><!--#general-contact-->
			<div id="press-contact" class="fourcol">
				<?php echo do_shortcode('[contact-form-7 id="1264" title="Press request"]'); ?>
			</div><!--#general-contact-->
				<!--<div id="general-contact" class="fourcol">
					<h2 class="aside-header">Contact</h2>
					<p>Send us a message using the form below</p>
					<div id="general-form"></div>
				</div>
				<div id="press-request" class="fourcol">
					<h2 class="aside-header">Press Login</h2>
					<p>Please enter your name and email below to get access to press assets</p>
					<div id="press-form"></div>
				</div>-->
			<div id="demo-submissions" class="fourcol">
				<?php echo do_shortcode('[contact-form-7 id="1706" title="Demo submissions"]'); ?>	
			</div>
		<div class="releases-divider"></div>
		</section><!-- #contact -->
		<footer id="about-links" class="twelvecol clearfix">
			<span id="henry-link">site by <a href="http://www.henryproudlove.com" rel="bookmark" target="_blank">Henry Proudlove</a></span>
			<div id="dist-aim-links">
			<?php echo get_post_meta($post->ID, '_sr_footer_html', true); ?>
			</div>
		</footer>
	</div><!-- #content -->
	
<?php get_footer(); ?>