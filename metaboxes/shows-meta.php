<div class="my_meta_control">

	<label>Show Date</label>
	
		<input id="date-field" type="text" name="<?php $metabox->the_name('show-date'); ?>" value="<?php $metabox->the_value('show-date'); ?>"/>
	
	<label>Venue</label>
 
		<input type="text" name="<?php $metabox->the_name('show-venue'); ?>" value="<?php $metabox->the_value('show-venue'); ?>"/>
		<span>Name of the venue</span>
	
	<label>Venue link</label>

		<input type="text" name="<?php $metabox->the_name('show-venue-link'); ?>" value="<?php $metabox->the_value('show-venue-link'); ?>"/>
		<span>URL of venue/map to it. Must be full URL http://www.example.com</span>
		
	<label>Buy Tickets Link</label>

		<input type="text" name="<?php $metabox->the_name('buy-tickets-link'); ?>" value="<?php $metabox->the_value('buy-tickets-link'); ?>"/>
		<span>Link to buy tickets. Must be full URL http://www.example.com</span>
	<label>Buy Tickets Text</label>
 
		<input type="text" name="<?php $metabox->the_name('buy-tickets-text'); ?>" value="<?php $metabox->the_value('buy-tickets-text'); ?>"/>
		<span>Text of the buy tickets link. Defaults to buy tickets</span>
		
	<?php $mb->the_field('stolen-show'); ?>
	<p><input type="checkbox" name="<?php $mb->the_name(); ?>" value="stolen-show"<?php $mb->the_checkbox_state('stolen-show'); ?>/> Check this box if this is a <strong>stolen show</strong?><br/></p>
	
	<script> 
		jQuery(document).ready(function() { 
				jQuery( "#date-field" ).datetimepicker({
					dateFormat: 'yy-mm-dd',
					stepMinute: 10,
				});
		});
	</script>
</div>