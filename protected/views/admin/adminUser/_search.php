<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="fl">
		<div class="row">
			<?php echo $form->label($model,'username'); ?>
			<?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?>
		</div>
	</div>
	<div class="fl">
		<div class="row">
			<?php echo $form->label($model,'cp_id'); ?>
	        <?php 
	           $cp = CMap::mergeArray(
                                    array(''=> "Tất cả"),
                                       CHtml::listData($cpList, 'id', 'name')
                                    );
                echo CHtml::dropDownList("AdminAdminUserModel[cp_id]", $model->cp_id, $cp )
	        ?>
	        			
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('admin','Tìm kiếm') ); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->