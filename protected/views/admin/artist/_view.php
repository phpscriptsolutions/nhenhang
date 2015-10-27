<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url_key')); ?>:</b>
	<?php echo CHtml::encode($data->url_key); ?>
	<br />
        <b><?php echo CHtml::encode($data->getAttributeLabel('artist_key')); ?>:</b>
	<?php echo CHtml::encode($data->artist_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('song_count')); ?>:</b>
	<?php echo CHtml::encode($data->song_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('video_count')); ?>:</b>
	<?php echo CHtml::encode($data->video_count); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('album_count')); ?>:</b>
	<?php echo CHtml::encode($data->album_count); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('artist_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->artist_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updated_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_time')); ?>:</b>
	<?php echo CHtml::encode($data->created_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_time')); ?>:</b>
	<?php echo CHtml::encode($data->updated_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sorder')); ?>:</b>
	<?php echo CHtml::encode($data->sorder); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>