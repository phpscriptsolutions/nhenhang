<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'import-song-file-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'file_name'); ?>
			<?php echo $form->textField($model,'file_name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'file_name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'importer'); ?>
			<?php echo $form->textField($model,'importer',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'importer'); ?>
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