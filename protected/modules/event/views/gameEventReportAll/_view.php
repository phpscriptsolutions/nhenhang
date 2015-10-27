<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->date), array('view', 'id'=>$data->date)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_sub')); ?>:</b>
	<?php echo CHtml::encode($data->total_sub); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_unsub')); ?>:</b>
	<?php echo CHtml::encode($data->total_unsub); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('access_event')); ?>:</b>
	<?php echo CHtml::encode($data->access_event); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('access_play')); ?>:</b>
	<?php echo CHtml::encode($data->access_play); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_play_all')); ?>:</b>
	<?php echo CHtml::encode($data->total_play_all); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total_msisdn_valid')); ?>:</b>
	<?php echo CHtml::encode($data->total_msisdn_valid); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('listen_music')); ?>:</b>
	<?php echo CHtml::encode($data->listen_music); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('download_music')); ?>:</b>
	<?php echo CHtml::encode($data->download_music); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('play_video')); ?>:</b>
	<?php echo CHtml::encode($data->play_video); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('download_video')); ?>:</b>
	<?php echo CHtml::encode($data->download_video); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('have_transaction')); ?>:</b>
	<?php echo CHtml::encode($data->have_transaction); ?>
	<br />

	*/ ?>

</div>