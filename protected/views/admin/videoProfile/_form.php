<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-video-profile-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'profile_id'); ?>
			<?php echo $form->textField($model,'profile_id',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'profile_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'format'); ?>
			<?php echo $form->textField($model,'format',array('size'=>4,'maxlength'=>4)); ?>
			<?php echo $form->error($model,'format'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'http_support'); ?>
			<?php echo $form->textField($model,'http_support'); ?>
			<?php echo $form->error($model,'http_support'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'rtsp_support'); ?>
			<?php echo $form->textField($model,'rtsp_support'); ?>
			<?php echo $form->error($model,'rtsp_support'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'rtmp_support'); ?>
			<?php echo $form->textField($model,'rtmp_support'); ?>
			<?php echo $form->error($model,'rtmp_support'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'sorder'); ?>
			<?php echo $form->textField($model,'sorder'); ?>
			<?php echo $form->error($model,'sorder'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>