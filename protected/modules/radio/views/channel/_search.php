<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<label>Channel Name</label>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<label>Parent Channel</label>
		<?php echo $form->textField($model,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php 
		$data = array(
				'channel'=>'Channel',
				'artist'=>'Artist',
				'genre'=>'Genre',
				'playlist'=>'Playlist',
				'album'=>'Album',
		);
			echo $form->dropDownList($model, 'type', $data, array('prompt'=>'--Tất cả--'));
		?>
		<?php //echo $form->textField($model,'type',array('size'=>7,'maxlength'=>7)); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php 
				$data = array(
						'1'=>'Actived',
						'0'=>'Not Actived',
				);
				echo $form->dropDownList($model,'status',$data, array('prompt'=>'All'));
			?>
	</div>

<!--
	<div class="row">
		<?php echo $form->label($model,'time_point'); ?>
		<?php echo $form->textField($model,'time_point',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'day_week'); ?>
		<?php echo $form->textField($model,'day_week',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'object_ids'); ?>
		<?php echo $form->textField($model,'object_ids',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ordering'); ?>
		<?php echo $form->textField($model,'ordering'); ?>
	</div>

-->
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->