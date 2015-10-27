<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-user-subscribe-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
		<?php 
			if($model->getError('return')){
				echo '
					<div class="errorSummary"><p> Xảy ra lỗi:</p>
						'.$model->getError('return').'
					</div>';
			}else{
				echo $form->errorSummary($model);			
			}
		?>
		
	
		<div class="row">
			<?php echo $form->labelEx($model,'user_phone'); ?>
			<?php echo $form->textField($model,'user_phone',array('size'=>16,'maxlength'=>16)); ?>
			<?php echo $form->error($model,'user_phone'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'package_id'); ?>
			<?php 
				$list = CHtml::listData($packageList, 'code', 'name');
				echo CHtml::dropDownList('AdminUserSubscribeModel[package_code]', '', $list);
			?>
			<?php echo $form->error($model,'package_id'); ?>
		</div>
	
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>