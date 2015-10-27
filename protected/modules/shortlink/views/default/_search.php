<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'prefix'); ?>
		<?php echo $form->textField($model,'prefix',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'url_key'); ?>
		<?php echo $form->textField($model,'url_key',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'domain'); ?>
		<?php echo $form->textField($model,'domain',array('size'=>60,'maxlength'=>100)); ?>
	</div>

<!--
	<div class="row">
		<?php echo $form->label($model,'dest_link'); ?>
		<?php echo $form->textField($model,'dest_link',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_datetime'); ?>
		<?php echo $form->textField($model,'created_datetime'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

-->
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->