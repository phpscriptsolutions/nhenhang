<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table width="80%" border="0">
	<tr>
		<td valign="middle" align="right" style="vertical-align: middle;"><?php echo $form->label($model,'name'); ?></td>
		<td valign="middle" style="vertical-align: middle;"><?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?></td>
		<td valign="middle" align="left"  style="vertical-align: middle;">
				<?php echo CHtml::submitButton('Search'); ?>
		</td>
	</tr>
</table>

<?php $this->endWidget(); ?>

</div><!-- search-form -->