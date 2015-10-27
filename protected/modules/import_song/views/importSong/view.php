<?php
$this->breadcrumbs=array(
	'Import Song Models'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ImportSongModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('ImportSongModelUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('ImportSongModelDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('ImportSongModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin ImportSong")."#".$model->id;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'autoconfirm',
		'created_time',
		'updated_time',
		'stt',
		'name',
		'category',
		'sub_category',
		'composer',
		'artist',
		'album',
		'path',
		'file',
		'status',
		'import_datetime',
		'importer',
		'file_name',
		'new_song_id',
	),
)); ?>
</div>
