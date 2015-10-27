<style>
.refresh_loading{
	background: url(<?php echo Yii::app()->request->baseUrl ?>'/ajax-loader.gif') no-repeat center center;
}
.refresh_loading div{
	opacity: 0.2
}
</style>
<?php
$this->breadcrumbs=array(
	'Import Song File Models'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ImportSongFileModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('ImportSongFileModelUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('ImportSongFileModelDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('ImportSongFileModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin ImportSongFile")."#".$model->id;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'file_name',
		'importer',
		'status',
		array(
			'name'=>'params',
			'type'=>'raw',
			'value'=>'<div id="params_file">'.$model->params.'</div>'
		),
		'created_time',
	),
)); ?>
</div>
<div>
<button onclick="js:startImport(<?php echo $model->id;?>);" id="startbtn" type="button">Start Import</button>
<button onclick="js:reloadParams(<?php echo $model->id;?>);" id="refresh">Refresh Params</button>
<div id="import-run" style="display: none;"><span class="loading-import"><img src="<?php echo Yii::app()->theme->baseUrl ?>/images/ajax-loader-top-page.gif"></span></div>
<div id="result" style="height: 300px; overflow: auto;border: 1px solid #ccc;"></div>
</div>
<script>
function reloadParams(fileId)
{
	jQuery.ajax({
		'url': '<?php echo Yii::app()->createUrl('/import_song/importSongFile/reloadParams')?>',
		'type':'POST',
		'data': {fileId:fileId},
		'dataType':'json',
		'beforeSend': function(){
			$("#refresh").attr("disabled","disabled");
			$("#params_file").addClass("refresh_loading");
			},
		'success': function(data){
			$("#params_file").removeClass("refresh_loading");
				if(data.error_code == 0)
		        {
					$("#params_file").html(data.data);
		        }else{
		        	$("#params_file").html('Error: '+data.data);
			        }
				$("#refresh").removeAttr("disabled");
			}
    })
}
function startImport(fileId)
{
	$("#import-run").show();
	$("#startbtn").attr("disabled","disabled");
				jQuery.ajax({
					'url': '<?php echo Yii::app()->createUrl('/import_song/importSong/AjaxImport')?>',
					'type':'POST',
					'data': {fileId:fileId},
					'dataType':'json',
					'success': function(data){
							$("#result").prepend(data.data);
							if(data.success == 1)
					        {
					            $('#import-run').hide();
					            $("#result").append('<div>Import Song Completed!</div>');
					            $("#startbtn").removeAttr("disabled");
					        }else{
					        	startImport(fileId);
						    }
						}
			    })
}
</script>