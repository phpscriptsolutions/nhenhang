<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<div class="fl">
		<div class="row">
			<?php echo $form->label($model,'type'); ?>
			<?php 
			echo $form->dropDownList($model, 'type', Yii::app()->params['genreType'], array('prompt'=>'--None--'));
			?>
		</div
	</div>
	<!-- 
	<div class="fl">
		<div class="row fr">
			<?php echo $form->label($model,'parent_id'); ?>
			<?php #echo $form->textField($model,'parent_id',array('size'=>50,'maxlength'=>150)); ?>
			<?php
				$category = CMap::mergeArray(
									array('0'=> "  "),
									   CHtml::listData($categoryList, 'id', 'name')
									);
                echo CHtml::dropDownList("AdminGenreModel[parent_id]", $model->parent_id, $category ) 
             ?>
             
		</div>
	</div>
	 -->
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->