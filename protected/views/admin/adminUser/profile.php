<?php 
$this->pageLabel = Yii::t('admin','Cập nhật thông tin tài khoản');
$state = Yii::app()->request->getParam('_state');
if($state){
	$msg = "";
	if($this->expiredPass > 2){
		$msg = "Mật khẩu của bạn đã hết thời gian sử dụng cho phép (90 ngày). ";
	}
	$msg .= "Bạn cần thay đổi mật khẩu để tiếp tục sử dụng hệ thống CMS";
	echo '<div class="notify-change-pass"><p>'.$msg.'</p></div>';
}
?>


<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-admin-user-model-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array('autocomplete'=>'off')
	)); ?>
	
		<?php echo $form->errorSummary($model); ?>
	
	
		<div class="row">
			<?php echo $form->labelEx($model,'username'); ?>
			<?php
				if($model->id) 
					echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50,'disabled'=>'disabled'));
				else 
					echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50));
				 ?>
			<?php echo $form->error($model,'username'); ?>
		</div>
		<div class="row">
			<?php echo CHtml::label(Yii::t('admin','Password'),""); ?>
			<?php echo CHtml::passwordField("AdminAdminUserModel[password]","",array('size'=>50))?>
			<span class="i fz11">	
			<?php 
			if($this->expiredPass >= 2){
				echo  Yii::t('admin','(Mật khẩu phải ≥ 8 ký tự, bắt đầu bằng ký tự chữ, và phải bao gồm: chữ và số)');
			}else{
				echo  Yii::t('admin','(Mật khẩu phải ≥ 8 ký tự, bắt đầu bằng ký tự chữ, và phải bao gồm: chữ và số. Để trống nếu không đổi)');
			}
			?>
			</span>
			<?php echo $form->error($model,'password'); ?>
		</div>
		
		
		<div class="row">
			<?php echo CHtml::label(Yii::t('admin','Re-password'),""); ?>
			<?php echo CHtml::passwordField("AdminAdminUserModel[re-password]","",array('size'=>50))?>
			<?php echo $form->error($model,'re-password'); ?>
		</div>
		
		<div class="row">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>160)); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
			
		<div class="row">
			<?php echo $form->labelEx($model,'fullname'); ?>
			<?php echo $form->textField($model,'fullname',array('size'=>50,'maxlength'=>160)); ?>
			<?php echo $form->error($model,'fullname'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'phone'); ?>
			<?php echo $form->textField($model,'phone',array('size'=>50,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'phone'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'company'); ?>
			<?php echo $form->textField($model,'company',array('size'=>50,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'company'); ?>
		</div>
	
		<div class="row buttons">
			<?php echo CHtml::submitButton('Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>