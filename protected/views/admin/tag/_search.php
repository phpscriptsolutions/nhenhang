<div class="wide form" style="display: none;">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'htmlOptions'=>array("id"=>"tag_search_form")
)); ?>

	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top" style="width: 360px">
				<div class="row">
				<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50,'style'=>'width:95%')); ?>
				</div></td>
			<td valign="top" align="left">
				<div class="row buttons">
				<?php echo CHtml::submitButton('Search'); ?>
				</div></td>
		</tr>
	</table>
	<?php $this->endWidget(); ?>

</div>
<!-- search-form -->
