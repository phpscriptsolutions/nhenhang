<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-tools-setting-get-msisdn-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
		<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textArea($model,'name',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
		<fieldset>
			<legend>Kiểu lọc thuê bao</legend>
			<div class="row">
				<?php echo CHtml::label('Kiểu'); ?>
				<?php 
				$data = array(
						1=>'Thuê bao có phát sinh giao dịch',
						2=>'Thuê bao không phát sinh giao dịch',
				);
				echo CHtml::dropDownList('params[type]', $params->type, $data, array('style'=>'width: 250px;')); 
				?>
				<?php echo $form->error($model,'name'); ?>
			</div>
		</fieldset>
		<fieldset>
			<legend>Thời gian lọc thuê bao</legend>
			<table>
				<tr>
					<td>
					Từ:&nbsp;
					</td>
					<td>
					<?php 
						echo CHtml::textField('params[datefrom]',$params->datefrom,array('style'=>'width: 100px;', 'class'=>'datetime'));
					?>
					</td>
					<td>Đến:&nbsp;</td>
					<td>
						<?php 
							echo CHtml::textField('params[dateto]',$params->dateto,array('style'=>'width: 100px;', 'class'=>'datetime'));
						?>
					</td>
				</tr>
			</table>
		</fieldset>
		<fieldset>
		<legend>Điều kiện loại trừ</legend>
			<div class="row">
			<?php echo CHtml::label('Không thuộc các tập bắn tin'); ?>
			<?php 
			echo CHtml::textField('params[spam_group_excluded]', $params->spam_group_excluded);
			?>
			</div>
		</fieldset>
		
		<fieldset>
			<legend>Thời gian đăng ký gói cước</legend>
			<table>
				<tr>
					<td>
					Từ:&nbsp;
					</td>
					<td>
					<?php 
						echo CHtml::textField('params[subs_datefrom]',$params->subs_datefrom,array('style'=>'width: 100px;', 'class'=>'datetime'));
					?>
					</td>
					<td>Đến:&nbsp;</td>
					<td>
						<?php 
							echo CHtml::textField('params[subs_dateto]',$params->subs_dateto,array('style'=>'width: 100px;', 'class'=>'datetime'));
						?>
					</td>
				</tr>
			</table>
		</fieldset>
		<div class="row">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php 
			$status = array(
					'NotActive'=>'Not Active',
					'Start'=>'Start',
					'Processing'=>'Processing',
					'Completed'=>'Completed',
			);
			echo $form->dropDownList($model, 'status', $status);
			?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
			<?php echo CHtml::button('Close', array('onclick'=>'location.href="'.Yii::app()->createUrl('/tools/toolsSettingGetMsisdn').'"'))?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>
<script>
			  $(function() {
			    $( ".datetime" ).datepicker({ dateFormat: 'yy-mm-dd' });
			  });
			</script>