<div class="my_meta_control">

<?php

$mb->the_field('present-past');

if(is_null($mb->get_the_value()))

	$mb->meta[$mb->name] = 'current';

?>

<input type="radio" name="<?php $mb->the_name(); ?>" value="current"<?php echo $mb->is_value('current')?' checked="checked"':''; ?>/> Current Artist

<input type="radio" name="<?php $mb->the_name(); ?>" value="past"<?php echo $mb->is_value('past')?' checked="checked"':''; ?>/> Past Artist

<?php $mb->the_field('publishing'); ?>
	<p><input type="checkbox" name="<?php $mb->the_name(); ?>" value="publishing"<?php $mb->the_checkbox_state('publishing'); ?>/> Check if artist is published by stolen <br/></p>

</div>

