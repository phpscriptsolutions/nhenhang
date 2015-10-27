<?php
$this->breadcrumbs=array(
	'Admin Package Models'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('PackageIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('PackageUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('PackageDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('PackageCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin Package")."#".$model->id;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'name',
		'vina_service_code',
		'fee',
		'duration',
		'price_song_streaming',
		'price_video_streaming',
		'price_song_download',
		'price_video_download',
		'sorder',
		'description',
		'status',
		'sms_short_code',
		'sms_command_code',
	),
)); ?>
</div>
