<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-reports-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'subject'); ?>
			<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'subject'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'content'); ?>
			<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'content'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'content_id'); ?>
			<?php echo $form->textField($model,'content_id'); ?>
			<?php echo $form->error($model,'content_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'content_type'); ?>
			<?php echo $form->textField($model,'content_type',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'content_type'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'user_id'); ?>
			<?php echo $form->textField($model,'user_id'); ?>
			<?php echo $form->error($model,'user_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'user_phone'); ?>
			<?php echo $form->textField($model,'user_phone',array('size'=>20,'maxlength'=>20)); ?>
			<?php echo $form->error($model,'user_phone'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'ip'); ?>
			<?php echo $form->textField($model,'ip',array('size'=>25,'maxlength'=>25)); ?>
			<?php echo $form->error($model,'ip'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'user_agent'); ?>
			<?php echo $form->textField($model,'user_agent',array('size'=>60,'maxlength'=>500)); ?>
			<?php echo $form->error($model,'user_agent'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'ref'); ?>
			<?php echo $form->textField($model,'ref',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'ref'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'platform'); ?>
			<?php echo $form->textField($model,'platform',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'platform'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'os'); ?>
			<?php echo $form->textField($model,'os',array('size'=>20,'maxlength'=>20)); ?>
			<?php echo $form->error($model,'os'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'os_version'); ?>
			<?php echo $form->textField($model,'os_version',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'os_version'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'browse'); ?>
			<?php echo $form->textField($model,'browse',array('size'=>20,'maxlength'=>20)); ?>
			<?php echo $form->error($model,'browse'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'browse_version'); ?>
			<?php echo $form->textField($model,'browse_version',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'browse_version'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_time'); ?>
			<?php echo $form->textField($model,'created_time'); ?>
			<?php echo $form->error($model,'created_time'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'updated_time'); ?>
			<?php echo $form->textField($model,'updated_time'); ?>
			<?php echo $form->error($model,'updated_time'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'note'); ?>
			<?php echo $form->textField($model,'note',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'note'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'error_code'); ?>
			<?php echo $form->textField($model,'error_code',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'error_code'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'error_message'); ?>
			<?php echo $form->textField($model,'error_message',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'error_message'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'error_type'); ?>
			<?php echo $form->textField($model,'error_type',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'error_type'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>