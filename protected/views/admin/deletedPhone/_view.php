<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->phone), array('view', 'id'=>$data->phone)); ?>
	<br />


</div>