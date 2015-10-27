<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row" style="width: 27%" >
            <?php echo $form->label($model,'date'); ?>
            <?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'GameEventReportAllModel[date]',
                    'value'=>isset($_GET['GameEventReportAllModel']['date'])?$_GET['GameEventReportAllModel']['date']:"",
		        ));
		     ?>
		     		     
	</div>	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->