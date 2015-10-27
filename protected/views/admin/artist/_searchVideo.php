<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('/artist/videolist',array('id'=>$artistId)),
	'method'=>'get',
)); ?>

<div class="fl">
	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array()); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'artist_name'); ?>
		<?php echo $form->textField($model,'artist_name',array()); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'created_time'); ?>
        <?php 
	       $this->widget('ext.daterangepicker.input',array(
	            'name'=>'AdminVideoModel[created_time]',
	       		'value'=>isset($_GET['AdminVideoModel']['created_time'])?$_GET['AdminVideoModel']['created_time']:'',
	        ));
	     ?>		
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
			if($this->cpId ==0)
				echo CHtml::dropDownList("AdminVideoModel[cp_id]", $model->cp_id, $cp );
			else
				echo CHtml::dropDownList("AdminVideoModel[cp_id]", $model->cp_id, $cp, array('disabled'=>'disabled') );
				
		?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'genre_id'); ?>
        <?php
				$category = CMap::mergeArray(
									array(''=> "Tất cả"),
									   CHtml::listData($categoryList, 'id', 'name')
									);
                echo CHtml::dropDownList("AdminVideoModel[genre_id]", $model->genre_id, $category ) 
		?>
             
	</div>	
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton('Search'); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->