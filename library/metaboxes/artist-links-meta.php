<div class="my_meta_control">
 	
 	<?php $options = array('length' => 1); ?>
	<?php while($mb->have_fields_and_multi('artist_soc_links', $options)): ?>
	<?php $mb->the_group_open(); ?>
	
 		<label>Social Link </label>
		<?php $mb->the_field('art_social_a'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
 		<span>Must be full URL http://www.example.com</span>
 		
 		<a href="#" class="dodelete">Remove Link</a>
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
	<a href="#" class="docopy-artist_soc_links button">Add Link</a>

</div>

