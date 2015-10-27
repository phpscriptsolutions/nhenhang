<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php 
			//echo $form->textField($model,'type',array('size'=>10,'maxlength'=>10));
			$data = array(
					''=>'Tất cả',
					'news'=>'news',
					'song'=>'song',
					'video'=>'video',
					'album'=>'album',
					'custom'=>'custom'
			);
			echo $form->dropDownList($model, 'type', $data)
		 ?>
	</div>


	<div class="row">
		<?php echo $form->label($model,'Status'); ?>
		<?php
			$data = array(''=>'Tất cả',0=>"Un-Active",1=>'Active') ;
			echo $form->dropDownList($model,'status',$data); 
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->