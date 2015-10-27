<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js"); ?>
<?php 
	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');
	
	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
	$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
	$cssFile=$baseScriptUrl.'/styles.css';
	$cs->registerCssFile($cssFile);
	$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);
?>

<?php
$month1 = date('Y-05-d');// date('Y-05-d H:m:s');

$day = "";

if((date('d')+3)<10)
    $day = "0".(date('d')+3);
else if((date('d')+3) > 30)
    $day = "25";
else
    $day = date('d')+3;
    
$month2 = date('Y-05')."-".$day;//." ".date('H:m:s');

Yii::app()->clientScript->registerScript('import', "
    $('.timet').hide();
    $('#autoconfirm').click(function(){
        $('.timet').toggle();
        });
    
    $('#yw0').val('".$month1."');      
    
    $('#yw1').val('".$month2."');
  
");
?>

<div class="form content-body">
	<div class="form" id="basic-zone">
		<div class="row global_field">
			<?php echo CHtml::label("Excel file(*.xls)", "") ?>
		    <?php 
		        $this->widget('ext.xupload.XUploadWidget', array(
		                            'url' => $this->createUrl("/import_song/importUpload/upload", array("parent_id" => 'tmp')),
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
			<div class="options-row">
			 <?php 	
			 		echo CHtml::label('Bắt đầu từ', 'start_row');
			 		echo CHtml::textField("AdminImportSongModel[start_row]",true); 
			 ?>
			 </div>
			 <div class="options-row">
			 <?php 	
			 		echo CHtml::label('Giới hạn(tối đa 1000)', 'limit_row');
			 		echo CHtml::textField("AdminImportSongModel[limit_row]", 1000); 
			 ?>
			 </div>
                        
                        <div class="options-row">
			 <?php 	
			 		echo CHtml::label('Tự động duyệt', 'autoconfirm_label');
			 		echo CHtml::checkBox("autoconfirm", false); 
			 ?>
			 </div>
                        
                        <div class="options-row timet">
			 <?php 	
                                        $songModel = new AdminSongModel();
			 		echo CHtml::label('Thời gian tạo', 'created_time_label');
			 		$this->widget('ext.timepicker.timepicker', array(
                                            'model' => $songModel,
                                            'select' => 'datetime',
                                            'name' => 'created_time'
                                        ));
			 ?>
			 </div>
                        
                        <div class="options-row timet">
			 <?php 	
                                        $songModel = new AdminSongModel();
			 		echo CHtml::label('Thời gian duyệt', 'updated_time_label');
			 		$this->widget('ext.timepicker.timepicker', array(
                                            'model' => $songModel,
                                            'select' => 'datetime',
                                            'name' => 'updated_time'
                                        ));
			 ?>
			 </div>
                        
                        
                        
			 <div class="row buttons import-btn">
				<?php 
           		 echo CHtml::ajaxSubmitButton('Import',array('/import_song/importUpload/newimport'),
           			array(
                  		'type' => 'POST',
           				'beforeSend' => 'function(){
            			 importBefore();}',
                		'success'=>'js:'.'function(data){'.'importAfterScan(data);}',), 
		                array('class'=>'button green'),
		                array('update'=>'#resultImport')
                    ); 
        		?>
				<span class="loading-import" style="display:none"><img src="<?php echo Yii::app()->request->baseUrl ?>/ajax-loader.gif"></span>
			</div>
			<div id="ads"></div>
			<div id="resultImport" name="resultImport">
                <a href="/admin.php?r=song/index&unknow_cat=1">Danh sách bài hát không có thể loại</a>
				<div class="imported"></div>
				<div class="grid-view data-import" style="display:none" id="admin-song-model-grid">
					<div class="title-result"><strong>Danh sách bài hát import lỗi(<span class="count-import-err">0</span>)</strong></div>
						<div class="import-result">
							<table class="items">
							<thead>
							<tr>
								<th id="admin-song-model-grid_c1"></th>
								<th id="admin-song-model-grid_c2" width="35%">Name </th>
								<th id="admin-song-model-grid_c3">Đường dẫn</th>
								<th id="admin-song-model-grid_c4">TT File</th>
							</tr>
							</thead>
							<tbody class="result_row">
							</tbody>
							</table>
						</div>
					</div>
			</div>
			
		<?php $this->endWidget(); ?>
		
	</div>
	
	<div class="form" id="fav-zone" style="display: none;">
	</div>
</div>