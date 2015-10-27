<div class="content-body">
    <style>
        #SmsConfigModel_status_0, #SmsConfigModel_status_1{
            float: left;
            margin: 0px 5px;
        }
    </style>
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'sms-config-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
	
		<?php echo $form->errorSummary($model); ?>
	
                <?php if (Yii::app()->controller->action->id == 'create') { ?>
			<div class="row">
			<?php echo $form->labelEx($model,'keyword'); ?>
			<?php echo $form->textField($model,'keyword',array('size'=>50,'maxlength'=>50)); ?>
			<?php echo $form->error($model,'keyword'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'group_key'); ?>
			<?php echo $form->textField($model,'group_key',array('size'=>20,'maxlength'=>20)); ?>
			<?php echo $form->error($model,'group_key'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'index_key'); ?>
			<?php echo $form->textField($model,'index_key',array('size'=>50,'maxlength'=>50)); ?>
			<?php echo $form->error($model,'index_key'); ?>
		</div>
                
                <?php } ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'content'); ?>
                        <?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>35)); ?>
			<?php echo $form->error($model,'content'); ?>
		</div>
	
			<div class="row labelradio">
			<?php echo $form->labelEx($model,'status'); ?>
                        <?php echo $form->radioButtonList($model,'status',array('1'=>'Bật','0'=>'Tắt'), array('separator' => ' '));?>
			<?php // echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>