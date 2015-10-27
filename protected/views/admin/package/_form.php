<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-package-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20)); ?>
			<?php echo $form->error($model,'code'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>160)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'vina_service_code'); ?>
			<?php echo $form->textField($model,'vina_service_code',array('size'=>30,'maxlength'=>30)); ?>
			<?php echo $form->error($model,'vina_service_code'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'fee'); ?>
			<?php echo $form->textField($model,'fee'); ?>
			<?php echo $form->error($model,'fee'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'duration'); ?>
			<?php echo $form->textField($model,'duration'); ?>
			<?php echo $form->error($model,'duration'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'price_song_streaming'); ?>
			<?php echo $form->textField($model,'price_song_streaming'); ?>
			<?php echo $form->error($model,'price_song_streaming'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'price_video_streaming'); ?>
			<?php echo $form->textField($model,'price_video_streaming'); ?>
			<?php echo $form->error($model,'price_video_streaming'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'price_song_download'); ?>
			<?php echo $form->textField($model,'price_song_download'); ?>
			<?php echo $form->error($model,'price_song_download'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'price_video_download'); ?>
			<?php echo $form->textField($model,'price_video_download'); ?>
			<?php echo $form->error($model,'price_video_download'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'sorder'); ?>
			<?php echo $form->textField($model,'sorder'); ?>
			<?php echo $form->error($model,'sorder'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'sms_short_code'); ?>
			<?php echo $form->textField($model,'sms_short_code',array('size'=>12,'maxlength'=>12)); ?>
			<?php echo $form->error($model,'sms_short_code'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'sms_command_code'); ?>
			<?php echo $form->textField($model,'sms_command_code',array('size'=>45,'maxlength'=>45)); ?>
			<?php echo $form->error($model,'sms_command_code'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>