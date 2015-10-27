<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));
echo "<pre>";print_r($model->video);exit;
?>

<div class="fl" style="width: 50%">
	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model->video,'name',array()); ?>
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
	        ));
	     ?>		
	</div>	
</div>
<div class="fl" style="width: 50%">
	<div class="row">
		<?php echo $form->label($model,'cp_id'); ?>
	    <?php 
	    	$cp = CMap::mergeArray(
            			array(''=> "Tất cả"),
                        			CHtml::listData($cpList, 'id', 'name')
							);
			echo CHtml::dropDownList("AdminVideoModel[cp_id]", $model->cp_id, $cp )
		?>
	        		
	</div>
	<div class="row">
		<?php echo $form->label($model,'genre_id'); ?>
		<?php #echo $form->textField($model,'genre_id'); ?>
        <?php
				$category = CMap::mergeArray(
									array(''=> "Tất cả"),
									   CHtml::listData($categoryList, 'id', 'name')
									);
                echo CHtml::dropDownList("AdminVideoModel[genre_id]", $model->genre_id, $category ) 
		?>
             
	</div>	
	<?php $style = ($this->type == 9999)?"display:block":"display:none"; ?>
    <div class="row" style="<?php echo $style?>">
		<?php echo $form->label($model,'status'); ?>
        <?php 
               $status = array(
                                ''=> "Tất cả",
                                '0'=> "Chưa convert",
                                '1'=> "Chờ duyệt",
                                '2'=> "Đã duyệt",
                                '3'=> "Convert lỗi",
                                '5'=> "Đã xóa",
                            );
                echo CHtml::dropDownList("AdminVideoModel[status]",  $model->status, $status )
        ?>	 		
	</div>		
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton('Search'); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->