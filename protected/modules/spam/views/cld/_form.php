<div class="content-body">
	<div class="form">
	<?php
        if(isset($error))
            echo '<br><span class="note row required">Thời điểm bắn tin phải lớn hơn thời gian hiện tại 30 phút.</span><p>&nbsp;</p>';
        ?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-spam-sms-cld-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
                
                        <div class="row">
			<?php echo $form->labelEx($model,'message'); ?>
			<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'message'); ?>
		</div>    
	
			<div class="row">
			<?php echo $form->labelEx($model,'group_id'); ?>
			<?php echo CHtml::dropDownList('CldModel[group_id]', $group_id, $smsGroup); ?>
			<?php echo $form->error($model,'group_id'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'send_time'); ?>
			<?php // echo $form->textField($model,'send_time'); ?>
                            
                        <?php
                        $this->widget('ext.timepicker.timepicker', array(
                            'model' => $model,
                            'select' => 'datetime',
                            'name' => 'send_time'
                        ));
 
//                        $this->widget('ext.daterangepicker.input',array(
//	            'name'=>'AdminRingtoneModel[created_time]',
//	       		'value'=>isset($_GET['AdminRingtoneModel']['created_time'])?$_GET['AdminRingtoneModel']['created_time']:'',
//	        ));
                        ?>
			<?php echo $form->error($model,'send_time'); ?>
		</div>
	
			<div class="row">
			<?php //echo $form->labelEx($model,'status'); ?>
			<?php echo $form->hiddenField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'params'); ?>
			<?php echo $form->textArea($model,'params',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'params'); ?>
		</div>
	
			<div class="row">
			<?php //echo $form->labelEx($model,'created_time'); ?>
			<?php echo $form->hiddenField($model,'created_time'); ?>
			<?php echo $form->error($model,'created_time'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>