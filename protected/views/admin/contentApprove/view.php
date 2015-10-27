<?php
date_default_timezone_set('Asia/Saigon');
$this->breadcrumbs=array(
	'Content Approve Models'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Quay lại Danh sách'), 'url'=>array('index')),
);
$this->pageLabel = Yii::t('admin', "Thông tin ContentApprove");
?>
<?php 
//$data = CJSON::decode($model->data_change);
//echo '<pre>';print_r($data);
$timeFrom = $model->approved_content_time;
if(!empty($timeFrom)){
	$timeEslapse = Formatter::time_elapsed(strtotime($model->created_time) - strtotime($timeFrom));
}else{
	$timeEslapse = "N/A";
}

?>

<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'content_type',
		'content_id',
		'admin_id',
		'admin_name',
		array(
			'name'=>'status',
			'value'=>str_replace(array(0,1,2),array("<span class=\"s_label s_0\">Chưa duyệt</span>","<span class=\"s_label s_1\">Đã duyệt</span>","<span class=\"s_label s_2\">Bỏ qua</span>"), $model->status),
			'type'=>'raw'
		),
		array(
				'name'=>'approved_id',
				'value'=>$model->approved_id>0?AdminAdminUserModel::model()->findByPk($model->approved_id)->username:"",
				'type'=>'raw'
		),
		'created_time',
		array(
			'label'=>'Thời gian duyệt '.$model->content_type,
			'value'=>$model->approved_content_time,
		),
		array(
			'label'=>'Thời gian thực hiện',
			'value'=>$timeEslapse,
			'type'=>'raw'		
		),
	),
)); ?>

</div>
<div>
<?php 
if($model->content_type=='song'){
	$songCate = AdminSongGenreModel::model()->getCatBySong($model->content_id, true);
	$metaModel = AdminSongMetadataModel::model()->findByPk($model->content_id);
	$this->renderPartial('_song_view', array(
		'model' => AdminSongModel::model()->findByPk($model->content_id),
		'metaModel' => $metaModel,
		'songCate'=>$songCate
	));
}elseif($model->content_type=='video'){
	$metaModel = AdminVideoMetadataModel::model()->findByPk($model->content_id);
	$this->renderPartial('_video_view',array(
			'model'=>AdminVideoModel::model()->findByPk($model->content_id),
			'metaModel'=>$metaModel
	));
}
?>
</div>
<div id="compare">
<?php 
if($model->content_type=='song'){
	$this->renderPartial('_compare_song', array('dataDiff'=>$dataDiff));
}elseif($model->content_type=='video'){
	$this->renderPartial('_compare_video', array('dataDiff'=>$dataDiff));
}
?>
</div>
<button type="button" id="apply-content" <?php if($model->status>0) echo 'disabled="disabled"';?>>Duyệt & Update Thông tin</button>
<button type="button" id="ban-content" <?php if($model->status>0) echo 'disabled="disabled"';?>>Hủy thông tin sửa này</button>
<button type="button" onclick="location.href='<?php echo Yii::app()->createUrl('/contentApprove/index');?>'">Quay lại danh sách</button>
<div id="result"></div>
<?php 
if($model->content_type=='song'){
	$url = Yii::app()->createUrl('/song/approvedAndApplySong', array('id'=>$model->id));
}elseif($model->content_type=='video'){
	$url = Yii::app()->createUrl('/video/approvedAndApplyVideo', array('id'=>$model->id));
}else{
	$url="#";
}
?>
<script>
$(function(){
	$("#apply-content").live("click", function(){
		$.ajax({
	        url: "<?php echo $url;?>",
	        type: "POST",
	        dataType:"json",
	        data: {t:1},
	        beforeSend: function(){
		        $("#apply-content").attr("disabled","disabled");
		        $("#ban-content").attr("disabled","disabled");
				$("#result").html("<img src='<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader-top-page.gif' />")
		    },
	        success: function(Response) {
	        	$("#result").html(Response.error_msg);
	        }
	    });
		})
		
	$("#ban-content").live("click", function(){
		$.ajax({
	        url: "<?php echo Yii::app()->createUrl('contentApprove/cancelApproved', array('id'=>$model->id));?>",
	        type: "POST",
	        dataType:"json",
	        data: {t:1},
	        beforeSend: function(){
		        $("#ban-content").attr("disabled","disabled");
		        $("#apply-content").attr("disabled","disabled");
				$("#result").html("<img src='<?php echo Yii::app()->theme->baseUrl; ?>/images/ajax-loader-top-page.gif' />")
		    },
	        success: function(Response) {
	        	$("#result").html(Response.error_msg);
	        }
	    });
		})
})
</script>