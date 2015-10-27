<?php
Yii::app()->clientScript->registerScript('type', "
$('#config_type').change(function(){
	var type = $('#config_type').val();
    if(type == 'array')
        $('#guide_style').show();
    else
        $('#guide_style').hide();
});

");
?>

<div class="content-body">
	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'config-model-form',
		'enableAjaxValidation'=>false,
	)); ?>

		<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->errorSummary($model); ?>

			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php
            if(isset($update))
                echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45,'readonly' => 'readonly','style' => 'background:#f2f2f2'));
            else
                echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>

        <div class="row">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php //echo $form->textField($model,'type',array('size'=>60,'maxlength'=>255));
            $types = AdminConfigModel::TYPE;
            $arr_type = explode(',',$types);?>
            <select name="ConfigModel[type]" id="config_type">
            <?php
            foreach($arr_type as $type){
                $selected = ($model->type == $type)? "selected":"";
                echo "<option $selected value='$type'>$type</option>";
            }
            ?>
            </select>
			<?php echo $form->error($model,'type'); ?>
		</div>

        <div class="row">
			<?php echo $form->labelEx($model,'value'); ?>
			<?php //echo $form->textField($model,'value',array('size'=>60,'maxlength'=>255)); ?>
			<?php
            if($model->type == "array")
                echo CHtml::textArea('ConfigModel[value]',json_encode(unserialize($model->value)),array('maxlength'=>500,'cols'=>40,'rows'=>8));
            else
                echo $form->textArea($model,'value',array('maxlength'=>500,'cols'=>40,'rows'=>8));

            ?>
            <?php echo $form->error($model,'value'); ?>
        </div>
        <div class="row" id="guide_style" style="line-height:20px;<?php echo ($model->type == "array")?"":"display:none";?>">
            <label for=""><b>Chú thích</b></label>
            <div style="float: left;">
                <p>Nếu type là <b>array</b> thì nhập value theo format sau:
                    <b>{'key-1':'value-1','key-n':'value-n'};</b>
                </p>
                <p>Đọc thêm tại <a href="http://www.php.net/manual/en/function.json-decode.php" target="_blank">đây</a></p>
            </div>
		</div>

			<div class="row">
			<?php echo $form->labelEx($model,'comment'); ?>
			<?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'comment'); ?>
		</div>


			<div class="row">
			<?php echo $form->labelEx($model,'category'); ?>
			<?php //echo $form->textField($model,'category',array('size'=>60,'maxlength'=>255));

            $categories = AdminConfigModel::CATEGORY;
            $arr_category = explode(',',$categories);?>
            <select name="ConfigModel[category]">
            <?php
            foreach($arr_category as $category){
                $selected = ($model->category == $category)? "selected":"";
                echo "<option $selected value='$category'>$category</option>";
            }
            ?>
            </select>
			<?php echo $form->error($model,'category'); ?>
		</div>

			<div class="row">
			<?php echo $form->labelEx($model,'channel'); ?>
			<?php //echo $form->textField($model,'channel',array('size'=>60,'maxlength'=>255));
            $channels = AdminConfigModel::CHANNEL;
            $arr_channel = explode(',',$channels);
            $model_channel = explode(',',$model->channel);
            ?>
            <select name="channels[]" multiple="multiple">
            <?php
            foreach($arr_channel as $channel){
                $selected = (in_array($channel, $model_channel))? "selected":"";
                echo "<option $selected value='$channel'>$channel</option>";
            }
            ?>
            </select>
			<?php echo $form->error($model,'channel'); ?>
		</div>

			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->
</div>