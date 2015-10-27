<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>160)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'vina_service_code'); ?>
		<?php echo $form->textField($model,'vina_service_code',array('size'=>30,'maxlength'=>30)); ?>
	</div>

<!--
	<div class="row">
		<?php echo $form->label($model,'fee'); ?>
		<?php echo $form->textField($model,'fee'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'duration'); ?>
		<?php echo $form->textField($model,'duration'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_song_streaming'); ?>
		<?php echo $form->textField($model,'price_song_streaming'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_video_streaming'); ?>
		<?php echo $form->textField($model,'price_video_streaming'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_song_download'); ?>
		<?php echo $form->textField($model,'price_song_download'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price_video_download'); ?>
		<?php echo $form->textField($model,'price_video_download'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sorder'); ?>
		<?php echo $form->textField($model,'sorder'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sms_short_code'); ?>
		<?php echo $form->textField($model,'sms_short_code',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sms_command_code'); ?>
		<?php echo $form->textField($model,'sms_command_code',array('size'=>45,'maxlength'=>45)); ?>
	</div>

-->
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->