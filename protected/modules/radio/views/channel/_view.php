<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent_id')); ?>:</b>
	<?php echo CHtml::encode($data->parent_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_point')); ?>:</b>
	<?php echo CHtml::encode($data->time_point); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('day_week')); ?>:</b>
	<?php echo CHtml::encode($data->day_week); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('object_ids')); ?>:</b>
	<?php echo CHtml::encode($data->object_ids); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo CHtml::encode($data->ordering); ?>
	<br />

	*/ ?>

</div>