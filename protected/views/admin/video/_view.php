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

	<b><?php echo CHtml::encode($data->getAttributeLabel('url_key')); ?>:</b>
	<?php echo CHtml::encode($data->url_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('duration')); ?>:</b>
	<?php echo CHtml::encode($data->duration); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('song_id')); ?>:</b>
	<?php echo CHtml::encode($data->song_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('genre_id')); ?>:</b>
	<?php echo CHtml::encode($data->genre_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('composer_id')); ?>:</b>
	<?php echo CHtml::encode($data->composer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('artist_id')); ?>:</b>
	<?php echo CHtml::encode($data->artist_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('artist_name')); ?>:</b>
	<?php echo CHtml::encode($data->artist_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approved_by')); ?>:</b>
	<?php echo CHtml::encode($data->approved_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_by')); ?>:</b>
	<?php echo CHtml::encode($data->updated_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cp_id')); ?>:</b>
	<?php echo CHtml::encode($data->cp_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_path')); ?>:</b>
	<?php echo CHtml::encode($data->source_path); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('download_price')); ?>:</b>
	<?php echo CHtml::encode($data->download_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('listen_price')); ?>:</b>
	<?php echo CHtml::encode($data->listen_price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('max_bitrate')); ?>:</b>
	<?php echo CHtml::encode($data->max_bitrate); ?>
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