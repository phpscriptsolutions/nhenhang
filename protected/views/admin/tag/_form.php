<div class="wide form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route."/create"),
	'method'=>'post',
	'htmlOptions'=>array('onsubmit = retrun false')
)); ?>
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td valign="top" style="width: 360px">
				<div class="row">
				<?php echo CHtml::textField("tag_name","",array('size'=>50,'maxlength'=>50,'autocomplete'=>'off' ,'style'=>'width:95%', 'onkeyup'=>'js:suggetTag();')); ?>
				</div></td>
			<td valign="top" align="left">
				<div class="row buttons">
				<?php
					echo CHtml::ajaxSubmitButton("Create",
							CHtml::normalizeUrl(array('/tag/create','render'=>false)),
							array('success'=>'js: function(data) {
								$("#tag_name").val("");
								$("#AdminTagModel_name").val("");
								$("#tag_search_form").submit();
								//$.fn.yiiGridView.update("admin-tag-model-grid");
		                    }','live' =>false),
							array('id'=>'closeDialog'));
				?>
				</div></td>
		</tr>
	</table>
	<?php $this->endWidget(); ?>

</div>
<!-- search-form -->