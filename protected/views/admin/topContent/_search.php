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
                <?php echo $form->label($model,'group'); ?>
                <?php
                        $groupType = array('home'=>'home','video'=>'video','album'=>'album');
                        echo $form->dropDownList($model, 'group', $groupType, array('prompt'=>'Tất cả'));
                ?>
        </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->