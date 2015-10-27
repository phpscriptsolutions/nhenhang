<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<!-- 
	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'started_datetime'); ?>
		<?php echo $form->textField($model,'started_datetime'); ?>
	</div>
 -->
 
	<div class="row">
		<?php echo $form->label($model,'user_phone'); ?>
		<?php echo $form->textField($model,'user_phone',array('size'=>60,'maxlength'=>100)); ?>
	</div>	
	<div class="row" style="width: 27%">
            <?php echo $form->label($model,'started_datetime'); ?>
            <?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'GameEventUserLogModel[started_datetime]',
                    'value'=>isset($_GET['GameEventUserLogModel']['started_datetime'])?$_GET['GameEventUserLogModel']['started_datetime']:"",
		        ));
		     ?>
		     		     
	</div>
<!--
	<div class="row">
		<?php echo $form->label($model,'ask_id'); ?>
		<?php echo $form->textField($model,'ask_id'); ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'answer_id'); ?>
		<?php echo $form->textField($model,'answer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'point'); ?>
		<?php echo $form->textField($model,'point'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'thread_id'); ?>
		<?php echo $form->textField($model,'thread_id'); ?>
	</div>

	

	<div class="row">
		<?php echo $form->label($model,'completed_datetime'); ?>
		<?php echo $form->textField($model,'completed_datetime'); ?>
	</div>

-->
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->