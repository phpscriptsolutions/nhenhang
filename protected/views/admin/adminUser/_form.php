<div class="content-body">
	<div class="form">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'admin-admin-user-model-form',
			'enableAjaxValidation'=>false,
			'htmlOptions'=>array('onsubmit'=>'return checkData()'),
		)); ?>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'cp_id'); ?>
			<?php
			$cp = CMap::mergeArray(
				array('0'=> ""),
				CHtml::listData($cpList, 'id', 'name')
			);
			echo CHtml::dropDownList("AdminAdminUserModel[cp_id]", $model->cp_id, $cp,array('onchange'=>'setrole(this)') )
			?>
			<?php echo $form->error($model,'cp_id'); ?>
		</div>


		<div class="row">
			<?php echo $form->labelEx($model,'username'); ?>
			<?php
			if($model->id && !isset($copy))
				echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50,'readonly'=>'readonly'));
			else
				echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50));
			?>
			<?php echo $form->error($model,'username'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'email'); ?>
			<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>160)); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'password'); ?>
			<?php echo CHtml::passwordField("AdminAdminUserModel[password]")?>
			<?php echo $form->error($model,'password'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'fullname'); ?>
			<?php echo $form->textField($model,'fullname',array('size'=>60,'maxlength'=>160)); ?>
			<?php echo $form->error($model,'fullname'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'phone'); ?>
			<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'phone'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'company'); ?>
			<?php echo $form->textField($model,'company',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'company'); ?>
		</div>

		<?php
		$htmlRoleText = '<b>Content Provider</b>';
		$htmlRoleText .= '<input type="hidden" name="role" id="role" value="Content Provider" readonly="readonly" />';
		$htmlRoleList = '<select name="role" id="role">';
		$htmlRoleList .= '<option></option>';
		foreach ($roles as $role){
			if($role->name != "SuperAdmin"){
				$htmlRoleList .= '<option value="'.$role->name.'" ';
				if($userRole==$role->name){
					$htmlRoleList .= 'SELECTED="SELECTED" ';
				}
				$htmlRoleList .= ">";
				$htmlRoleList .= $role->name;
				$htmlRoleList .= '</option>';
			}
		}
		$htmlRoleList .= '</select>';
		?>


		<div class="row">
			<?php echo CHtml::label("Nhóm quyền", "") ?>
			<?php /*
			<select name="role" id="role">
				<option></option>
				<?php foreach ($roles as $role):?>
				<?php if($role->itemname != "SuperAdmin"): ?>
				<option value="<?php echo $role->itemname ?>" <?php echo ($userRole==$role->itemname)?" SELECTED":""?>>
					<?php echo $role->itemname ?>
				</option>
				<?php endif; ?>
				<?php endforeach;?>
			</select>
			*/?>
			<div id="role-zone">
				<?php echo (isset($model->id) && $model->cp_id != 0)?$htmlRoleText:$htmlRoleList ?>
			</div>
		</div>


		<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php
			$data = array(
				1=>Yii::t('admin','Đang kích hoạt'),
				0=>Yii::t('admin','Không kích hoạt'),
			);
			echo CHtml::dropDownList("AdminAdminUserModel[status]", $model->status, $data ) ?>

			<?php echo $form->error($model,'status'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model,'Đổi lại mật khẩu'); ?>
			<?php echo $form->checkbox($model,'require_changepass'); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>

		<?php $this->endWidget(); ?>

	</div><!-- form -->
</div>
<script type="text/javascript">
	//<!--
	function setrole(el)
	{
		if(el.value != 0){
			$('#role-zone').html('<?php echo $htmlRoleText ?>');
		}else{
			$('#role-zone').html('<?php echo $htmlRoleList?>');
		}
	}
	function checkData()
	{
		if($('#role').val() == ""){
			alert('Chưa chọn nhóm quyền');
			return false;
		}
		return true;
	}
	//-->
</script>