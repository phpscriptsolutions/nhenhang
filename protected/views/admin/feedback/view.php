<?php
$this->breadcrumbs=array(
	'User Reports Models'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('UserReportsModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('UserReportsModelUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('UserReportsModelDelete')),
);
$this->pageLabel = Yii::t('admin', "Thông tin UserReports")."#".$model->id;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'subject',
		'content',
		'content_id',
		'content_type',
		'user_id',
		'user_phone',
		'ip',
		'user_agent',
		'ref',
		'platform',
		'os',
		'os_version',
		'browse',
		'browse_version',
		'created_time',
		'updated_time',
		'note',
		'status',
		'error_code',
		'error_message',
		'error_type',
	),
)); ?>
</div>
