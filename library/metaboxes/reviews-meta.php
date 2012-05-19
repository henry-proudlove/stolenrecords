<div class="my_meta_control">
	
	<?php $options = array('length' => 1, 'limit' => 5); ?>
	<?php while($mb->have_fields_and_multi('reviews', $options)): ?>
	<?php $mb->the_group_open(); ?>
 
		<?php $mb->the_field('review-text'); ?>
		<label>Review text</label>
		<textarea name="<?php $metabox->the_name(); ?>" rows="3"><?php $metabox->the_value(); ?></textarea>
 
		<?php $mb->the_field('review-attr'); ?>
		<label>Review attribution</label>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Whoever wrote the above and/or ★ rating</span>
		
		<?php $mb->the_field('review-link'); ?>
		<label>Review link</label>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
 		<span>Url of the review. Makes attribution clickable. Must be full URL http://www.example.com</span>
 		
		<a href="#" class="dodelete">Delete review</a>
        
        <?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
		
		<a href="#" class="docopy-reviews button">Add review</a>
</div>

