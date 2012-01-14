<div class="my_meta_control">
	
	<h4>Social Links</h4>
 
	<?php while($mb->have_fields_and_multi('art-social-lnks')): ?>
	<?php $mb->the_group_open(); ?>
 
		<?php $mb->the_field('art-social-URL'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
 		<span>Enter link. Must be full URL http://www.example.com</span>
 		<a href="#" class="dodelete button">Remove Link</a>
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
	<p style="margin-bottom:15px; padding-top:15px;"><a href="#" class="docopy-art-social-lnks button">Add Link</a></p>
	
	<label>Past artist</label>
	
	<?php $mb->the_field('present-past'); ?>
	<input type="checkbox" name="<?php $mb->the_name(); ?>" value="present-past"<?php $mb->the_checkbox_state('present-past'); ?>/> Check if past artist<br/>


</div>

