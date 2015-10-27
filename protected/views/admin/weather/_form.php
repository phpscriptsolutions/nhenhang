<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-weather-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
			<?php if($model->isNewRecord):?>
			<div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php echo $form->textField($model,'code',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'code'); ?>
			</div>
			<?php else:?>
			<div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php echo $model->code;?>
			</div>
			<?php endif;?>
			<div class="row">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'description'); ?>
			</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'vi_vn'); ?>
			<?php echo $form->textField($model,'vi_vn',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'vi_vn'); ?>
			</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
			</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>