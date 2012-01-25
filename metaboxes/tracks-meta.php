<div class="my_meta_control">
	
	<?php while($mb->have_fields_and_multi('tracks', $options)): ?>
	<?php $mb->the_group_open(); ?>
 
		<?php $mb->the_field('track-link'); ?>
		<label>Track link</label>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
 		<span>Link to track on soundcloud</span>
 		
		<a href="#" class="dodelete">Delete track</a>
        
        <?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
		
		<a href="#" class="docopy-tracks button">Add Track</a>
</div>

