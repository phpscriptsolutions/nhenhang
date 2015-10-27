<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'content-approve-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'content_type'); ?>
			<?php echo $form->textField($model,'content_type',array('size'=>30,'maxlength'=>30)); ?>
			<?php echo $form->error($model,'content_type'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'content_id'); ?>
			<?php echo $form->textField($model,'content_id'); ?>
			<?php echo $form->error($model,'content_id'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'action'); ?>
			<?php echo $form->textField($model,'action'); ?>
			<?php echo $form->error($model,'action'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'admin_id'); ?>
			<?php echo $form->textField($model,'admin_id'); ?>
			<?php echo $form->error($model,'admin_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'admin_name'); ?>
			<?php echo $form->textField($model,'admin_name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'admin_name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'approved_id'); ?>
			<?php echo $form->textField($model,'approved_id'); ?>
			<?php echo $form->error($model,'approved_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'data_change'); ?>
			<?php echo $form->textArea($model,'data_change',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'data_change'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_time'); ?>
			<?php echo $form->textField($model,'created_time'); ?>
			<?php echo $form->error($model,'created_time'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>