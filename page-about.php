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
				<h1 class="entry-title">Stolen Recordings</h1>
			</header><!-- .entry-header -->
			<div class="entry-gallery">
					<?php sr_artist_gallery(); ?>
				</div><!-- .entry-gallery -->
			<div class="entry-content">
				<?php the_content(); ?>
				<?php sr_social_links(true, false); ?>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->
		
		<?php 
			global $review_mb;
			$meta = $review_mb->the_meta();
			$reviews = $meta['reviews'];
			if($reviews): ?>
			<section id="reviews" class="twelvecol">
				<?php sr_get_reivews($reviews); ?>
			</section><!--#reviews-->
			<?php endif; ?>
			
		<section id="contact">
				<div id="general-contact" class="fourcol">
					<h2 class="aside-header">Contact</h2>
					<p>Send us a message using the form below</p>
					<div id="general-form"></div>
				</div>
				<div id="press-request" class="fourcol">
					<h2 class="aside-header">Press Login</h2>
					<p>Please enter your name and email below to get access to press assets</p>
					<div id="press-form"></div>
				</div>
				<div id="demo-submissions" class="fourcol">
					<h2 class="aside-header">Demo Submissions</h2>
					<p>Please Upload your demo to our Soundcloud dropbox</p>
					<a href="http://soundcloud.com/stolen-recordings/dropbox/profile">Our Dropbox</a>
				</div>
		</section><!-- #contact -->
	</div><!-- #content -->
	
<?php get_footer(); ?>