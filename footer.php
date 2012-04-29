<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?>

	</div><!-- #main  -->
</div><!-- #page -->

<script>
	var templateDir = "<?php bloginfo('template_directory') ?>";
</script>
<script src="<?php echo get_template_directory_uri();?>/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/sc-player.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/soundcloud.player.api.js"></script>
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