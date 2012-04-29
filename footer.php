<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>

	</div><!-- #main  -->
</div><!-- #page -->

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.isotope.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/jquery.colorbox-min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/jquery.expander.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/soundcloud.player.api.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/sc-player.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.infinitescroll.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.imagesloaded.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.fitvids.js"></script>
<script>
	var templateDir = "<?php bloginfo('template_directory') ?>";
</script>
<script src="<?php echo get_template_directory_uri(); ?>/js/scripts.js"></script>

<?php //Page conditional Scripts ?>

<?php if(is_page('videosphotos')): ?>
	<script type="text/javascript">	
		filtrationUnits(filterString);
	</script>
<?php endif;?>
<?php if(is_post_type_archive( 'release' )): ?>
	<script type="text/javascript">
		filtrationUnits(filterString);
	</script>
<?php endif;?>
<?php wp_footer(); ?>

</body>
</html>