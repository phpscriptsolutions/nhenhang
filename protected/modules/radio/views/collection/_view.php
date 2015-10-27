<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('radio_id')); ?>:</b>
	<?php echo CHtml::encode($data->radio_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('collection_id')); ?>:</b>
	<?php echo CHtml::encode($data->collection_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordering')); ?>:</b>
	<?php echo CHtml::encode($data->ordering); ?>
	<br />


</div>