<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-metadata-model-form',
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
			<?php echo $form->labelEx($model,'meta_key'); ?>
			<?php echo $form->textField($model,'meta_key',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'meta_key'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'meta_value'); ?>
			<?php echo $form->textField($model,'meta_value',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'meta_value'); 
                        echo "<p>".yii::t('chachawap','Dùng ## giữa các câu khi muốn chúng hiển thị ở các dòng khác nhau.')."</p>";
                        ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>