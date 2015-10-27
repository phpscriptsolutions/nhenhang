<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-ads-source-model-form',
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
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php 
			echo $form->dropDownList($model, 'status', array(1=>"Active", 0=>"Not Active", 2=>"Delete"));
			?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
			<input type="button" aria-disabled="false" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button"  onclick="location.href='<?php echo Yii::app()->createUrl('ads/adsSource/index')?>'" value="Close" />
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>