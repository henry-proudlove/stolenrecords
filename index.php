<?php
/**
 * @package WordPress
 * @subpackage themename
 */

get_header(); ?>

<div id="content">
	<?php get_template_part('loop' , 'index');?>
</div><!-- #content -->
		
<?php get_footer(); ?>