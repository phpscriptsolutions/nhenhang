<div class="content-body">
	<div class="form">
	<?php if(isset($error)): ?>
            <p class="note"><?php echo 'Thời gian gửi phải lớn hơn thời gian hiện tại 1h'; ?></p>
        <?php endif; ?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-spam-sms-group-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
                <p class="note"><?php echo $message; ?></p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'total_phone'); ?>
			<?php echo $form->textField($model,'total_phone'); ?>
			<?php echo $form->error($model,'total_phone'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>