<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'search-logs-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'keyword'); ?>
			<?php echo $form->textField($model,'keyword',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'keyword'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'total_search'); ?>
			<?php echo $form->textField($model,'total_search'); ?>
			<?php echo $form->error($model,'total_search'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'user_phone'); ?>
			<?php echo $form->textField($model,'user_phone',array('size'=>50,'maxlength'=>50)); ?>
			<?php echo $form->error($model,'user_phone'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php echo $form->textField($model,'type',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'search_datetime'); ?>
			<?php echo $form->textField($model,'search_datetime'); ?>
			<?php echo $form->error($model,'search_datetime'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'source'); ?>
			<?php echo $form->textField($model,'source',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'source'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>