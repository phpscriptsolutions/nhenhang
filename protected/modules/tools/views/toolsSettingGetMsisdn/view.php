<?php
$this->breadcrumbs=array(
	'Admin Tools Setting Get Msisdn Models'=>array('index'),
	$model->name,
);
$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('tools-ToolsSettingGetMsisdnIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('tools-ToolsSettingGetMsisdnUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('tools-ToolsSettingGetMsisdnDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('tools-ToolsSettingGetMsisdnCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin ToolsSettingGetMsisdn")."#".$model->id;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'params',
		'description',
		'created_datetime',
		'status',
	),
)); ?>
</div>
