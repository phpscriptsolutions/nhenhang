<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'radio-collection-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
		<!-- <div class="row">
			<?php echo $form->labelEx($model,'radio_id'); ?>
			<?php echo $form->textField($model,'radio_id'); ?>
			<?php echo $form->error($model,'radio_id'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'collection_id'); ?>
			<?php echo $form->textField($model,'collection_id'); ?>
			<?php echo $form->error($model,'collection_id'); ?>
		</div>
		-->
			<div class="row">
			<label>Thứ tự</label>
			<?php echo $form->textField($model,'ordering'); ?>
			<?php echo $form->error($model,'ordering'); ?>
		</div>
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>