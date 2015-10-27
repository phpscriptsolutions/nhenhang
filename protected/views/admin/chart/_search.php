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
		<?php echo $form->label($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20)); ?>
	</div>
	
    <div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
            <?php
            $types = array(
            		''  => Yii::t('admin', 'Tất cả'),
            		'song'  => Yii::t('admin', 'Song'),
            		'video' => Yii::t('admin', "Video"),
            		'album' => Yii::t('admin', "Album"),
            );
            	echo $form->dropDownList($model,'type', $types);
            ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'Tuần'); ?>
		<?php echo $form->textField($model,'cc_week_num',array('size'=>20,'maxlength'=>20,'onkeypress'=>'validate(event)')); ?>
	</div>
		

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
<script type="text/javascript">
//<!--
function validate(evt) {
	  var theEvent = evt || window.event;
	  var key = theEvent.keyCode || theEvent.which;
	  key = String.fromCharCode( key );
	  var regex = /[0-9]|\./;
	  if( !regex.test(key) ) {
	    theEvent.returnValue = false;
	    if(theEvent.preventDefault) theEvent.preventDefault();
	  }
	}
//-->
</script>