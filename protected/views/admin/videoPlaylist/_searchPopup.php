<div class="wide form" style='font-size: 11px !important;'>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <div class="fl" style="padding-left: 10px;">
	    <div class="row">
	        <?php echo $form->label($model,'name'); ?>
	        <?php echo $form->textField($model,'name', array('size'=>30)); ?>
	    </div>	    		
    </div>
    <div class="fl" style="padding-left: 10px;">
   	 	<div class="row">
	        <?php echo $form->label($model,'artist_name', array('style'=>'width:94px !important;')); ?>
	        <?php echo $form->textField($model,'artist_name', array('size'=>30)); ?>
	    </div>
	    <div class="row">
	        <?php echo $form->label($model,'cp_id', array('style'=>'width:94px !important;')); ?>
	        <?php #echo $form->textField($model,'cp_id', array('size'=>30)); ?>
	        <?php
	           $cp = CMap::mergeArray(
                                    array(''=> "Tất cả"),
                                       CHtml::listData($cpList, 'id', 'name')
                                    );
                echo CHtml::dropDownList("AdminVideoModel[cp_id]", $model->cp_id, $cp )
	        ?>
	    </div>
	    <div class="row">
	        <?php echo $form->label($model,'genre_id', array('style'=>'width:94px !important;')); ?>
	        <?php
				$category = CMap::mergeArray(
									array(''=> "Tất cả"),
									   CHtml::listData($categoryList, 'id', 'name')
									);
                echo CHtml::dropDownList("AdminVideoModel[genre_id]", $model->genre_id, $category )
             ?>

	    </div>

    </div>

	<div class="row buttons" style="text-align: left;">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->