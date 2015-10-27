<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-html-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'title'); ?>
			<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'title'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'url_key'); ?>
			<?php echo $form->textField($model,'url_key',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'url_key'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'content'); ?>
			
			<?php 
				/*$this->widget('application.extensions.tinymce.ETinyMce',
	            				array(
	            					'name'=>'adminHtmlModel[content]',
	            					'editorTemplate'=>'full',
	            					'model'=>$model,
	            					'attribute'=>'content',
	            					'width'=>'75%',
	            				));*/
			?>
			
            <?php
            $this->widget('ext.elrtef.elRTE', array(
                'model' => $model,
                'attribute' => 'content',
                //'name' => 'text',
                //'htmlOptions' => array('height' => '600'),
                'options' => array(
                    'doctype' => 'js:\'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\'',
                    'cssClass' => 'el-rte',
                    'cssfiles' => array('css/elrte-inner.css'),
                    'absoluteURLs' => true,
                    'allowSource' => true,
                    'lang' => 'vi',
                    'styleWithCss' => '',
                    'height' => 400,
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
            ?>
            			
			<?php echo $form->error($model,'content'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php echo $form->textField($model,'type',array('size'=>10,'maxlength'=>10)); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'pos'); ?>
			<?php echo $form->textField($model,'pos'); ?>
			<?php echo $form->error($model,'pos'); ?>
		</div>
                <div class="row">
			<?php echo $form->labelEx($model,'channel'); ?>
                        <?php $channel = array(
                                        'wap'=> 'wap',
                                        'web' => 'web',
                                        'api' => 'api'
                                    );
                        echo CHtml::dropDownList("AdminHtmlModel[channel]",  $model->channel, $channel ) ?>
			<?php //echo $form->textField($model,'status'); ?>
			<?php echo $form->error($model,'channel'); ?>
		</div>
	
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>