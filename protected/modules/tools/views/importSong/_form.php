<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'import-song-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'autoconfirm'); ?>
			<?php echo $form->textField($model,'autoconfirm'); ?>
			<?php echo $form->error($model,'autoconfirm'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'created_time'); ?>
			<?php echo $form->textField($model,'created_time'); ?>
			<?php echo $form->error($model,'created_time'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'updated_time'); ?>
			<?php echo $form->textField($model,'updated_time'); ?>
			<?php echo $form->error($model,'updated_time'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'stt'); ?>
			<?php echo $form->textField($model,'stt'); ?>
			<?php echo $form->error($model,'stt'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'category'); ?>
			<?php echo $form->textField($model,'category',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'category'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'sub_category'); ?>
			<?php echo $form->textField($model,'sub_category',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'sub_category'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'composer'); ?>
			<?php echo $form->textField($model,'composer',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'composer'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'artist'); ?>
			<?php echo $form->textField($model,'artist',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'artist'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'album'); ?>
			<?php echo $form->textField($model,'album',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'album'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'path'); ?>
			<?php echo $form->textField($model,'path',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'path'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'file'); ?>
			<?php echo $form->textField($model,'file',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'file'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'import_datetime'); ?>
			<?php echo $form->textField($model,'import_datetime'); ?>
			<?php echo $form->error($model,'import_datetime'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'importer'); ?>
			<?php echo $form->textField($model,'importer',array('size'=>60,'maxlength'=>100)); ?>
			<?php echo $form->error($model,'importer'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'file_name'); ?>
			<?php echo $form->textField($model,'file_name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'file_name'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'file_id'); ?>
			<?php echo $form->textField($model,'file_id',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'file_id'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'new_song_id'); ?>
			<?php echo $form->textField($model,'new_song_id'); ?>
			<?php echo $form->error($model,'new_song_id'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>