<?php
$this->pageLabel = "Thêm user";
?>
<style>
<!--
	.flash-success{
		background: #d1e172;
		margin: 10px 0;
 		padding: 10px 0;
 		text-align: center;
 		font-size: 13px;
 		color: #434343;
 		font-weight: bold;
	}
-->
</style>

<div class="content-body">
	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-user-subscribe-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	<?php
	echo $form->errorSummary($model);
		if(Yii::app()->user->hasFlash('addSuggest')){
	    echo '<div class="flash-success">'.Yii::app()->user->getFlash('addSuggest').'</div>';
	}	

	?>

		<div class="row">
		<?php echo $form->labelEx($model,'user_phone'); ?>
		<?php echo $form->textField($model,'user_phone',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'user_phone'); ?>
		</div>
		<div class="row">
		<?php echo CHtml::label("Free day", "") ?>
		<?php 
			for($i=7;$i<=30;$i++){$arr[$i] = $i;}
			echo CHtml::dropDownList("AdminUserSubscribeModel[freeday]", 7, $arr)
		?>
		</div>

		<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>

		<?php $this->endWidget(); ?>

	</div>
	<!-- form -->
</div>
