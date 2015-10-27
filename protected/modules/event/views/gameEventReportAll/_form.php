<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'game-event-report-all-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'date'); ?>
			<?php echo $form->textField($model,'date',array('size'=>50,'maxlength'=>50)); ?>
			<?php echo $form->error($model,'date'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'total_sub'); ?>
			<?php echo $form->textField($model,'total_sub'); ?>
			<?php echo $form->error($model,'total_sub'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'total_unsub'); ?>
			<?php echo $form->textField($model,'total_unsub'); ?>
			<?php echo $form->error($model,'total_unsub'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'access_event'); ?>
			<?php echo $form->textField($model,'access_event'); ?>
			<?php echo $form->error($model,'access_event'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'access_play'); ?>
			<?php echo $form->textField($model,'access_play'); ?>
			<?php echo $form->error($model,'access_play'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'total_play_all'); ?>
			<?php echo $form->textField($model,'total_play_all'); ?>
			<?php echo $form->error($model,'total_play_all'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'total_msisdn_valid'); ?>
			<?php echo $form->textField($model,'total_msisdn_valid'); ?>
			<?php echo $form->error($model,'total_msisdn_valid'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'listen_music'); ?>
			<?php echo $form->textField($model,'listen_music'); ?>
			<?php echo $form->error($model,'listen_music'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'download_music'); ?>
			<?php echo $form->textField($model,'download_music'); ?>
			<?php echo $form->error($model,'download_music'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'play_video'); ?>
			<?php echo $form->textField($model,'play_video'); ?>
			<?php echo $form->error($model,'play_video'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'download_video'); ?>
			<?php echo $form->textField($model,'download_video'); ?>
			<?php echo $form->error($model,'download_video'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'have_transaction'); ?>
			<?php echo $form->textField($model,'have_transaction'); ?>
			<?php echo $form->error($model,'have_transaction'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>