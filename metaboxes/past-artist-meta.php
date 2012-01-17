<div class="my_meta_control">

<?php

$mb->the_field('present-past');

if(is_null($mb->get_the_value()))

	$mb->meta[$mb->name] = 'current';

?>

<input type="radio" name="<?php $mb->the_name(); ?>" value="current"<?php echo $mb->is_value('current')?' checked="checked"':''; ?>/> Current Artist



<input type="radio" name="<?php $mb->the_name(); ?>" value="past"<?php echo $mb->is_value('past')?' checked="checked"':''; ?>/> Past Artist

</div>

