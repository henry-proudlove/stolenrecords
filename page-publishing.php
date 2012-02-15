<?php
/**
 * Template Name: Publishing Page
 * Description: Shows publishing page content + thumbs of pubslihed artists below
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

	<div id="content">

		<?php the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('twelvecol'); ?> role="article">
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php the_content(); ?>
				<?php sr_post_thumbnail('medium' , false); ?>
			</div><!-- .entry-content -->
		</article><!-- #post-<?php the_ID(); ?> -->
		
		<section id=artists">
		<h2 class="section-header twelvecol">Published by stolen</h2>
		<?php /* Start the Loop */
	
			$args = array('post_type' => 'artist' , 'posts_per_page' => '-1' , 'orderby' => 'title' , 'order' => 'ASC' , 'meta_key' => '_sr_publishing', 'meta_value' => 'publishing');
			$the_query = new WP_Query($args);
			while ( $the_query->have_posts() ) : $the_query->the_post();
				sr_relart_loop_markup(); 
			endwhile; wp_reset_query();?>

	</div><!-- #content -->

<?php get_footer(); ?>