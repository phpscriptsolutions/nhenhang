<div class="form content-body">
	<div class="form" id="basic-zone">
		<div class="row global_field">
			<?php echo CHtml::label("Excel file(*.xls)", "") ?>
		    <?php 
		        $this->widget('ext.xupload.XUploadWidget', array(
		                            'url' => $this->createUrl("/tools/importUpload/upload", array("parent_id" => 'tmp')),
		                            'model' => $uploadModel,
		                            'attribute' => 'file',
		        					'text'=>Yii::t('admin', 'Upload file'),
		                            'options' => array(
		                                           	'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
		                                           						if(handler.response.error){
		                                           							alert(handler.response.msg);
		                                           							$("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>'.Yii::t('admin','Lỗi upload').': "+handler.response.msg+"</div></td></tr>");
		                                           						}else{
		                                           							$("#AdminImportSongModel_source_path").val(handler.response.name);
		                                           							$("#files").html("<tr><td><label></label></td><td><div class=\'success\'>'.Yii::t('admin','Upload thành công ').': "+files[index].name+"</div></td></tr>");
		                                           							$(".errorSummary").hide();
		                                           							$(".wrr").hide();
		                                           							$("#resultImport").hide();
		                                           							$(".result_row").html("");
		                                           						}
		                                                            }'
		                                        )
		        ));
		    ?>
			
		</div>
		<div>Mẫu file import <a href="http://s2.chacha.vn/uploads/test_check_song.xls">download</a></div>
		<?php $form=$this->beginWidget('CActiveForm', array(
		    'id'=>'admin-importsong-model-form',
		    'enableAjaxValidation'=>false,
			'clientOptions'=>array('validateOnSubmit'=>true),
		));
		 ?>
		
			<?php echo $form->errorSummary($model); ?>
			<?php
				$fileTmp = ($model->source_path != "")?$model->source_path:0;		
				echo CHtml::hiddenField("AdminImportSongModel[source_path]", $fileTmp);
				echo CHtml::hiddenField("AdminImportSongModel[ajax]", true);
				
			?>
			<div class="error-result"></div>
                        
			 <div class="row buttons import-btn">
				<?php 
           		 echo CHtml::ajaxSubmitButton('Import',array('/tools/importUpload/newimport'),
           			array(
                  		'type' => 'POST',
						'dataType'=>'json',
           				'beforeSend' => 'function(){
            			 importBefore();}',
                		'success'=>'js:'.'function(data){
							$(".loading-import").css("display","none");
							$("#result").html(data.errorDesc);
						}',
						), 
		                array('class'=>'button green'),
		                array('update'=>'#resultImport')
                    ); 
        		?>
				<span class="loading-import" style="display:none"><img src="<?php echo Yii::app()->theme->baseUrl ?>/images/ajax-loader-top-page.gif"></span>
				<span id="result"></span>
			</div>
		<?php $this->endWidget(); ?>
		
	</div>
	
	<div class="form" id="fav-zone" style="display: none;">
	</div>
</div>