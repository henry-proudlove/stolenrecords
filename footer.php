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
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.isotope.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.cycle.all.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/jquery.colorbox-min.js"></script>
<script src="<?php echo get_template_directory_uri();?>/js/jquery.expander.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.tooltip.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.oembed.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/soundcloud.player.api.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/sc-player.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.quicksand.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.infinitescroll.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.imagesloaded.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.fitvids.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.validate.pack.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.contactable.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/scripts.js"></script>

<?php //Page conditional Scripts ?>

<?php if(is_page('videosphotos')): ?>
	<script type="text/javascript">
		/*
		GET FLICKR FOR MEDIA PAGE 
		
		$(document).ready(function(){
			$.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?id=8546357@N03&lang=en-us&format=json&jsoncallback=?", function(data){
			var newelems = '';
			$.each(data.items, function(i,item){
				newelems += '<a class="fancy-roll fourcol flickr" href="' + item.link + '">';
				newelems += '<img src="' +  item.media.m + '" />';
				newelems += '</a>';
				if ( i == 20 ) return false;
			});
			$newelems = $(newelems);
			$('.page-template-page-media-php #isotope-wrap').append( $newelems );
			$('#isotope-wrap').imagesLoaded(function(){
				var $container = $(this);
					$container.isotope({
						  itemSelector : '.fancy-roll',
					});
				});
			});
		
			$container = $('.post-type-archive-release #isotope-wrap');
			$container.isotope({
				itemSelector : '.fancy-roll',
			});
		});*/
		
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