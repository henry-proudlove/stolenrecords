<div class="my_meta_control">

	<h4>Sample Tracks</h4>

	<?php while($mb->have_fields_and_multi('tracks')): ?>
	<?php $mb->the_group_open(); ?>
 
		<?php $mb->the_field('track-title'); ?>
		<label>Track title</label>
			<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
 
		<?php $mb->the_field('track-link'); ?>
		<label>Track link</label>
			<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
 
		<a href="#" class="dodelete button">Delete track</a>
        
        <?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
		
		<p style="margin-bottom:15px; padding-top:15px;"><a href="#" class="docopy-tracks button">Add Video</a></p>
</div>

