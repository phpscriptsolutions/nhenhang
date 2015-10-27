<?php
    $actvivities = array(''=>Yii::t('admin',"Tất cả"));
    $channels = array(''=>Yii::t('admin',"Tất cả"));
    
    foreach (AdminUserActivityModel::$activities as $activity){
        $actvivities[$activity] = Yii::t('admin',$model->generateAttributeLabel($activity));
    }
    foreach (AdminUserActivityModel::$channels as $channel){
        $channels[$channel] = Yii::t('admin',$model->generateAttributeLabel($channel));
    }
?>
<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <div class="fl">
        <div class="row">
            <?php echo $form->label($model,'loged_time'); ?>
            <?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>$model->className.'[loged_time]',
                    'value'=>trim((isset($_GET[$model->className]['loged_time']))?$_GET[$model->className]['loged_time']:""),
		        ));
		     ?>
        </div>  	        
        <div class="row">
            <?php echo $form->label($model,'channel'); ?>
            <?php echo CHtml::dropDownList($model->className.'[channel]',$model->channel,
                            $channels
                    ); ?>
        </div>        
        <div class="row">
            <?php echo $form->label($model,'activity'); ?>

            <?php echo CHtml::dropDownList($model->className.'[activity]',$model->activity,
                            $actvivities
                    ); ?>
        </div>                   

        
   </div>
   <div class="fl">
        <div class="row">
            <?php echo $form->label($model,'user_phone'); ?>
            <?php echo $form->textField($model,'user_phone',array('size'=>16,'maxlength'=>16)); ?>
        </div>
       

        <div class="row">
            <?php echo $form->label($model,'obj1_id'); ?>
            <?php echo $form->textField($model,'obj1_id',array('size'=>10,'maxlength'=>10)); ?>
        </div>        

        <div class="row">
            <?php echo $form->label($model,'obj2_id'); ?>
            <?php echo $form->textField($model,'obj2_id',array('size'=>10,'maxlength'=>10)); ?>
        </div>       
   </div>

<!--


	<div class="row">
		<?php echo $form->label($model,'obj1_name'); ?>
		<?php echo $form->textField($model,'obj1_name',array('size'=>60,'maxlength'=>160)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'obj1_url_key'); ?>
		<?php echo $form->textField($model,'obj1_url_key',array('size'=>60,'maxlength'=>160)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'obj2_name'); ?>
		<?php echo $form->textField($model,'obj2_name',array('size'=>60,'maxlength'=>160)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'obj2_url_key'); ?>
		<?php echo $form->textField($model,'obj2_url_key',array('size'=>60,'maxlength'=>160)); ?>
	</div>



-->
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->