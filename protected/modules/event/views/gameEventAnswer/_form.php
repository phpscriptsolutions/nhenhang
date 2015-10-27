<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'game-event-answer-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'ask_id'); ?>
			<?php echo $form->textField($model,'ask_id'); ?>
			<?php echo $form->error($model,'ask_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'is_true'); ?>
			<?php echo $form->textField($model,'is_true'); ?>
			<?php echo $form->error($model,'is_true'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'position'); ?>
			<?php echo $form->textField($model,'position',array('size'=>1,'maxlength'=>1)); ?>
			<?php echo $form->error($model,'position'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>