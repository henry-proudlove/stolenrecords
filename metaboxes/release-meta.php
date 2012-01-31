<div class="my_meta_control">

	<label>Release Date</label>
	
	<input id="date-field" type="text" name="<?php $metabox->the_name('release-date'); ?>" value="<?php $metabox->the_value('release-date'); ?>"/>
	
	<label>Buy now link</label>
	
	<input type="text" name="<?php $metabox->the_name('release-buy-link'); ?>" value="<?php $metabox->the_value('release-buy-link'); ?>"/>
	<span>Must be full URL http://www.example.com</span>

	<script>
		jQuery(document).ready(function($) {
			$( "#date-field" ).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			}); 
		});
	</script>
</div>