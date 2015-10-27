<?php
Yii::app()->clientScript->registerScript('editQuestion', "
window.changeType = function(e)
{
    if($(e).val() == 'text') {
        \$('#type_text').css( 'display', 'block');
		\$('#type_image').css( 'display', 'none');
    } else {
		\$('#type_text').css( 'display', 'none');
        \$('#type_image').css( 'display', 'block');
    }
}
");
?>
<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'game-event-question-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->labelEx($model,'Nội dung'); ?>			
            <?php
            	echo $form->textArea($model,'name',array('rows'=>6, 'cols'=>140));
            /*
            $this->widget('ext.elrtef.elRTE', array(
                'model' => $model,
                'attribute' => 'name',
                'options' => array(
                    'doctype' => 'js:\'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\'',
                    'cssClass' => 'el-rte',
                    'cssfiles' => array('css/elrte-inner.css'),
                    'absoluteURLs' => true,
                    'allowSource' => true,
                    'lang' => 'vi',
                    'styleWithCss' => '',
                    'height' => 200,
                    'fmAllow' => true, //if you want to use Media-manager
                    'fmOpen' => 'js:function(callback) {$("<div id=\"elfinder\" />").elfinder(%elfopts%);}', //here used placeholder for settings
                    'toolbar' => 'maxi',
                ),
                'elfoptions' => array(//elfinder options
                    'url' => 'auto', //if set auto - script tries to connect with native connector
                    'passkey' => 'mypass', //here passkey from first connector`s line
                    'lang' => 'ru',
                    'dialog' => array('width' => '900', 'modal' => true, 'title' => 'Media Manager'),
                    'closeOnEditorCallback' => true,
                    'editorCallback' => 'js:callback'
                ),
                    )
            );
            */
            ?>
            			
			<?php echo $form->error($model,'name'); ?>
		</div>		
		
		<div class="row">
			<?php echo $form->labelEx($model,'Điểm'); ?>
			<?php echo $form->textField($model,'point', array('value'=>1));?>
			<?php echo $form->error($model,'point'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'Type'); ?>			
			<?php
				$types = array(
								'text'=>Yii::t('admin','text'),
								'image'=>Yii::t('admin','image'),															
							);
				echo CHtml::dropDownList("GameEventQuestionModel[type]", !$model->isNewRecord ? $model->type : 'text', $types, array("onchange" => "changeType(this)") );
			?>			
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'Trạng thái'); ?>			
			<?php
				$status = array(
								1=>Yii::t('admin','Hiển thị'),
								0=>Yii::t('admin','Không hiển thị'),								
							);
				echo CHtml::dropDownList("GameEventQuestionModel[status]", !$model->isNewRecord?GameEventQuestionModel::model()->findByPk($model->id)->status:1, $status );
			?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'level'); ?>
			<?php echo $form->textField($model,'level'); ?>
			<?php echo $form->error($model,'level'); ?>
		</div>
		<div id='type_text' style="<?php echo ($model->isNewRecord || $model->type == 'text') ? 'display: block' : 'display: none'; ?>">
			<div class="row" style="clear:none; width: 600px; float: left;">
				<label>A</label>
				<textarea id="answer_a" name="answer[]" cols="50" rows="4"><?php echo ($model->isNewRecord || !isset($answers[0])) ? '' : $answers[0]->name;?></textarea>
			</div>
			
			<div class="row" style="clear:none; width: 600px; float: left;">
				<label>B</label>
				<textarea id="answer_b" name="answer[]" cols="50" rows="4"><?php echo ($model->isNewRecord || !isset($answers[1])) ? '' : $answers[1]->name;?></textarea>
			</div>
			<div class="row" style="clear:none; width: 600px; float: left;">
				<label>C</label>
				<textarea id="answer_c" name="answer[]" cols="50" rows="4"><?php echo ($model->isNewRecord || !isset($answers[2])) ? '' : $answers[2]->name;?></textarea>
				
			</div>
			<div class="row" style="clear:none; width: 600px; float: left;">
				<label>D</label>
				<textarea id="answer_d" name="answer[]" cols="50" rows="4"><?php echo ($model->isNewRecord || !isset($answers[3])) ? '' : $answers[3]->name;?></textarea>
			</div>
		</div>
		
		<div id='type_image' style="<?php echo ($model->type == 'image') ? 'display: block' : 'display: none'; ?>">
			<div class="row">
				<label>A</label>
				<?php 
					$fileTmp = (isset($_POST['ask_image_0']) && $_POST['ask_image_0'] != 0) ?$_POST['ask_image_0'] : 0;
						$this->widget('ext.elfinder.ServerFileInput', array(
								'id' => 'ask_image_0',
								'name' => 'ask_image_0',
								'value' => (!$model->isNewRecord && isset($answers[0])) ? $answers[0]->name : '',
								'connectorRoute' => 'event/elfinder/connector',
						));
				?>
			</div>
			<div class="row">
				<label>B</label>
				<?php 
					$fileTmp = (isset($_POST['ask_image_1']) && $_POST['ask_image_1'] != 0) ?$_POST['ask_image_1'] : 0;
						$this->widget('ext.elfinder.ServerFileInput', array(
								'id' => 'ask_image_1',
								'name' => 'ask_image_1',
								'value' => (!$model->isNewRecord && isset($answers[1])) ? $answers[1]->name : '',
								'connectorRoute' => 'event/elfinder/connector',
						));
				?>
			</div>
			<div class="row">
				<label>C</label>
				<?php 
					$fileTmp = (isset($_POST['ask_image_2']) && $_POST['ask_image_2'] != 0) ?$_POST['ask_image_2'] : 0;
						$this->widget('ext.elfinder.ServerFileInput', array(
								'id' => 'ask_image_2',
								'name' => 'ask_image_2',
								'value' => (!$model->isNewRecord && isset($answers[2])) ? $answers[2]->name : '',
								'connectorRoute' => 'event/elfinder/connector',
						));
				?>
			</div>
			<div class="row">
				<label>D</label>
				<?php 
					$fileTmp = (isset($_POST['ask_image_3']) && $_POST['ask_image_3'] != 0) ?$_POST['ask_image_3'] : 0;
						$this->widget('ext.elfinder.ServerFileInput', array(
								'id' => 'ask_image_3',
								'name' => 'ask_image_3',
								'value' => (!$model->isNewRecord && isset($answers[3])) ? $answers[3]->name : '',
								'connectorRoute' => 'event/elfinder/connector',
						));
				?>
			</div>			
		</div>
		<div class="row">		
			<label>Đáp án</label>
			<input type="radio" name="answer_chk" value="0" <?php echo ($model->isNewRecord || (!$model->isNewRecord && isset($answers[0]) && $answers[0]->is_true == 1)) ? 'checked="checked"' : '';?>>A&nbsp; 
			<input type="radio" name="answer_chk" value="1" <?php echo (!$model->isNewRecord && isset($answers[1]) && $answers[1]->is_true == 1) ? 'checked="checked"' : '';?>>B&nbsp;
			<input type="radio" name="answer_chk" value="2" <?php echo (!$model->isNewRecord && isset($answers[2]) && $answers[2]->is_true == 1) ? 'checked="checked"' : '';?>>C&nbsp; 
			<input type="radio" name="answer_chk" value="3" <?php echo (!$model->isNewRecord && isset($answers[3]) && $answers[3]->is_true == 1) ? 'checked="checked"' : '';?> >D&nbsp; 
		</div>
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>	
	</div><!-- form -->
</div>