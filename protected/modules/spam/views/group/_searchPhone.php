<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->controller->createUrl("Group/view"),
	'method'=>'get',
)); ?>
	<div class="row">
		<label>Số điện thoại</label>
        <?php echo CHtml::hiddenField('id', $group_id); ?>
		<?php echo CHtml::textField('phone', $_GET['phone']); ?>
            
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->