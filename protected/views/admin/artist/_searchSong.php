<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl('/artist/songlist',array('id'=>$artistId)),
	'method'=>'get',
)); ?>
    <div class="fl">
	    <div class="row">
	        <?php echo $form->label($model,'name'); ?>
	        <?php echo $form->textField($model,'name', array('size'=>30)); ?>
	    </div>
	    <div class="row">
	        <?php echo $form->label($model,'artist_name'); ?>
	        <?php echo $form->textField($model,'artist_name', array('size'=>30)); ?>
	    </div>
	    
        <div class="row created_time">
            <?php echo $form->label($model,'created_time'); ?>
            <?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'AdminSongModel[created_time]',
		       		'value'=>isset($_GET['AdminSongModel']['created_time'])?$_GET['AdminSongModel']['created_time']:'',
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
                echo CHtml::dropDownList("AdminSongModel[cp_id]", $model->cp_id, $cp )
	        ?>
	    </div>
	    <div class="row">
	        <?php echo $form->label($model,'genre_id'); ?>
	        <?php
				$category = CMap::mergeArray(
									array(''=> "Tất cả"),
									   CHtml::listData($categoryList, 'id', 'name')
									);
                echo CHtml::dropDownList("AdminSongModel[genre_id]", $model->genre_id, $category ) 
             ?>
                            
	    </div>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
		<?php echo CHtml::resetButton('Reset') ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->