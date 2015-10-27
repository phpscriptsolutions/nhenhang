<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'game-event-user-log-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'user_id'); ?>
			<?php echo $form->textField($model,'user_id'); ?>
			<?php echo $form->error($model,'user_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'user_phone'); ?>
			<?php echo $form->textField($model,'user_phone',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'user_phone'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'ask_id'); ?>
			<?php echo $form->textField($model,'ask_id'); ?>
			<?php echo $form->error($model,'ask_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'answer_id'); ?>
			<?php echo $form->textField($model,'answer_id'); ?>
			<?php echo $form->error($model,'answer_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'point'); ?>
			<?php echo $form->textField($model,'point'); ?>
			<?php echo $form->error($model,'point'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'thread_id'); ?>
			<?php echo $form->textField($model,'thread_id'); ?>
			<?php echo $form->error($model,'thread_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'started_datetime'); ?>
			<?php echo $form->textField($model,'started_datetime'); ?>
			<?php echo $form->error($model,'started_datetime'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'completed_datetime'); ?>
			<?php echo $form->textField($model,'completed_datetime'); ?>
			<?php echo $form->error($model,'completed_datetime'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>