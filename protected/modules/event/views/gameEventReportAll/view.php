<?php
$this->breadcrumbs=array(
	'Game Event Report All Models'=>array('index'),
	$model->date,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GameEventReportAllModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->date), 'visible'=>UserAccess::checkAccess('GameEventReportAllModelUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->date),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('GameEventReportAllModelDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->date), 'visible'=>UserAccess::checkAccess('GameEventReportAllModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin GameEventReportAll")."#".$model->date;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'date',
		'total_sub',
		'total_unsub',
		'access_event',
		'access_play',
		'total_play_all',
		'total_msisdn_valid',
		'listen_music',
		'download_music',
		'play_video',
		'download_video',
		'have_transaction',
	),
)); ?>
</div>
