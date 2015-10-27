<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_phone')); ?>:</b>
	<?php echo CHtml::encode($data->user_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ask_id')); ?>:</b>
	<?php echo CHtml::encode($data->ask_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('answer_id')); ?>:</b>
	<?php echo CHtml::encode($data->answer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('point')); ?>:</b>
	<?php echo CHtml::encode($data->point); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('thread_id')); ?>:</b>
	<?php echo CHtml::encode($data->thread_id); ?>
	<br />

	
	<b><?php echo CHtml::encode($data->getAttributeLabel('started_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->started_datetime); ?>
	<br />
	
	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('completed_datetime')); ?>:</b>
	<?php echo CHtml::encode($data->completed_datetime); ?>
	<br />

	*/ ?>

</div>