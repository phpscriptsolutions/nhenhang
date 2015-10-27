<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

 
	<div class="row">
		<?php echo $form->label($model,'user_phone'); ?>
		<?php echo $form->textField($model,'user_phone',array('size'=>60,'maxlength'=>100)); ?>
	</div>	
	<div class="row" style="width: 27%">
            <?php echo $form->label($model,'time_start'); ?>
            <?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'GameEventReportDayModel[time_start]',
                    'value'=>isset($_GET['GameEventReportDayModel']['time_start'])?$_GET['GameEventReportDayModel']['time_start']:"",
		        ));
		     ?>
		     		     
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->