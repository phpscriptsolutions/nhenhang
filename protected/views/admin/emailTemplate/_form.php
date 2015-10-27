<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-email-template-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>45)); ?>
			<?php echo $form->error($model,'code'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'title'); ?>
			<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'title'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'subject'); ?>
			<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'subject'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'body'); ?>
			<?php 
				//echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50));

			    $this->widget('application.extensions.tinymce.ETinyMce',
	            				array(
	            					'name'=>'AdminEmailTemplateModel[body]',
	            					'model'=>$model,
	            					'attribute'=>'body',
	            					'width'=>'75%',
                                    'options' => array(
                                            'theme' => 'advanced',
                                    ),
	            				));
			?>
			<?php echo $form->error($model,'body'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'from'); ?>
			<?php echo $form->textField($model,'from',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'from'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
	        <?php 
	               $status = array(
	                                '1'=> Yii::t('admin','Đang kích hoạt'),
	                                '0'=> Yii::t('admin','Không kích hoạt'),
	                            );
	                echo CHtml::dropDownList("AdminEmailTemplateModel[status]",  $model->status, $status )
            ?>			
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>