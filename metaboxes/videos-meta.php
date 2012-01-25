<div class="my_meta_control">
	
	<?php while($mb->have_fields_and_multi('videos')): ?>
	<?php $mb->the_group_open(); ?>
 
		<?php $mb->the_field('video-link'); ?>
		<label>Video link</label>
			<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
 		<span>Youtube or vimeo only.</span>
		<a href="#" class="dodelete">Delete Video</a>
        
        <?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
		
		<a href="#" class="docopy-videos button">Add Video</a>
</div>