<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vina_service_code')); ?>:</b>
	<?php echo CHtml::encode($data->vina_service_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fee')); ?>:</b>
	<?php echo CHtml::encode($data->fee); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('duration')); ?>:</b>
	<?php echo CHtml::encode($data->duration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_song_streaming')); ?>:</b>
	<?php echo CHtml::encode($data->price_song_streaming); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('price_video_streaming')); ?>:</b>
	<?php echo CHtml::encode($data->price_video_streaming); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_song_download')); ?>:</b>
	<?php echo CHtml::encode($data->price_song_download); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_video_download')); ?>:</b>
	<?php echo CHtml::encode($data->price_video_download); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sorder')); ?>:</b>
	<?php echo CHtml::encode($data->sorder); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sms_short_code')); ?>:</b>
	<?php echo CHtml::encode($data->sms_short_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sms_command_code')); ?>:</b>
	<?php echo CHtml::encode($data->sms_command_code); ?>
	<br />

	*/ ?>

</div>