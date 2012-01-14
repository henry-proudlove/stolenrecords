<div class="my_meta_control">

	<label>Release Date</label>
	
	<input id="date-field" type="text" name="<?php $metabox->the_name('release-date'); ?>" value="<?php $metabox->the_value('release-date'); ?>"/>
	
	<label>Buy now link</label>
	
	<input type="text" name="<?php $metabox->the_name('release-buy-link'); ?>" value="<?php $metabox->the_value('release-buy-link'); ?>"/>
	
	<label>Buy now text</label>
 
	<input type="text" name="<?php $metabox->the_name('release-buy-text'); ?>" value="<?php $metabox->the_value('release-buy-text'); ?>"/>
	
	<script> 
		jQuery(document).ready(function() { 
				jQuery( "#date-field" ).datepicker(); 
		}); 
	</script>
</div>