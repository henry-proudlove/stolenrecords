<?php
/**
 * Template Name: Videos and Photo Page
 * Description: Holder for media loop
 *
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

	<div id="content">

		<?php get_template_part( 'loop' , 'news'); ?>

	</div><!-- #content -->

<?php get_footer(); ?>