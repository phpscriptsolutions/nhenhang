<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<!-- 
	<div class="row">
		<?php echo $form->label($model,'content_id'); ?>
		<?php echo $form->textField($model,'content_id'); ?>
	</div>
-->
	<div class="row">
		<?php echo $form->label($model,'content_type'); ?>
		<?php
			echo $form->dropDownList($model,'content_type', array("song"=>"song", "video"=>"video"), array('prompt'=>'Tất cả'))
		?>
	</div>
	<div class="row">
		<label>Tài khoản sửa</label>
		<?php 
		$data = CHtml::listData($userBeReport, 'userid', 'username');
		//echo '<pre>';print_r($data);
		echo $form->dropDownList($model,'admin_id', $data, array('prompt'=>'Tất cả'));
		//echo $form->textField($model,'admin_id'); 
		?>
	</div>
<!--
	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'admin_id'); ?>
		<?php echo $form->textField($model,'admin_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'admin_name'); ?>
		<?php echo $form->textField($model,'admin_name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approved_id'); ?>
		<?php echo $form->textField($model,'approved_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data_change'); ?>
		<?php echo $form->textArea($model,'data_change',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_time'); ?>
		<?php echo $form->textField($model,'created_time'); ?>
	</div>

-->
	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php 
		echo $form->dropDownList($model,'status', array(0=>"Chưa duyệt", 1=>"Đã duyệt", 2=>"Bỏ qua"), array('prompt'=>'Tất cả'))
		?>
	</div>
	<div class="row" style="width: 334px">
		<label style="width: 100px;">Thời gian sửa</label>
		<?php 
			$this->widget('ext.daterangepicker.input',array(
		            'name'=>'datetime',
                    'value'=>isset($_GET['datetime'])?trim($_GET['datetime']):"",
		        ));
		?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->