<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-cp-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
						<?php
				$data = array(
						1=>Yii::t('admin','Đang kích hoạt'), 
						0=>Yii::t('admin','Không kích hoạt'), 
						);
			echo CHtml::dropDownList("AdminAdminUserModel[status]", $model->status, $data ) ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>