<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'game-event-activity-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'user_phone'); ?>
			<?php echo $form->textField($model,'user_phone',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'user_phone'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'activity'); ?>
			<?php echo $form->textField($model,'activity',array('size'=>50,'maxlength'=>50)); ?>
			<?php echo $form->error($model,'activity'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'point'); ?>
			<?php echo $form->textField($model,'point'); ?>
			<?php echo $form->error($model,'point'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'updated_time'); ?>
			<?php echo $form->textField($model,'updated_time'); ?>
			<?php echo $form->error($model,'updated_time'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>