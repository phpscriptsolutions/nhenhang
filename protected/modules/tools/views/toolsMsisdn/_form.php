<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-tools-msisdn-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'msisdn'); ?>
			<?php echo $form->textField($model,'msisdn',array('size'=>15,'maxlength'=>15)); ?>
			<?php echo $form->error($model,'msisdn'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'setting_id'); ?>
			<?php echo $form->textField($model,'setting_id'); ?>
			<?php echo $form->error($model,'setting_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php echo $form->textField($model,'code',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'code'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_datetime'); ?>
			<?php echo $form->textField($model,'created_datetime'); ?>
			<?php echo $form->error($model,'created_datetime'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>