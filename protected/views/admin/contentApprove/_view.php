<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_type')); ?>:</b>
	<?php echo CHtml::encode($data->content_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content_id')); ?>:</b>
	<?php echo CHtml::encode($data->content_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_id')); ?>:</b>
	<?php echo CHtml::encode($data->admin_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('admin_name')); ?>:</b>
	<?php echo CHtml::encode($data->admin_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_id')); ?>:</b>
	<?php echo CHtml::encode($data->approved_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data_change')); ?>:</b>
	<?php echo CHtml::encode($data->data_change); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
	<?php echo CHtml::encode($data->created_time); ?>
	<br />

	*/ ?>

</div>