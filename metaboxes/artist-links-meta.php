<div class="my_meta_control">
 	
	<?php while($mb->have_fields_and_multi('art-social-lnks')): ?>
	<?php $mb->the_group_open(); ?>
	
 		<label>Link URL </label>
		<?php $mb->the_field('art-social-URL'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
 		<span>Enter link. Must be full URL http://www.example.com</span>
 		
 		<label>Link Title </label>
 		<?php $mb->the_field('art-social-title'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
 		<span>Title of the link will appear on rollover</span>
 		
 		<a href="#" class="dodelete">Remove Link</a>
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
	<a href="#" class="docopy-art-social-lnks button">Add Link</a>

</div>

