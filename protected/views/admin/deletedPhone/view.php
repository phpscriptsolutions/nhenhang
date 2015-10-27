<?php
$this->breadcrumbs=array(
	'Deleted Phone Models'=>array('index'),
	$model->phone,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('DeletedPhoneIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->phone), 'visible'=>UserAccess::checkAccess('DeletedPhoneUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->phone),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('DeletedPhoneDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->phone), 'visible'=>UserAccess::checkAccess('DeletedPhoneCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin DeletedPhone")."#".$model->phone;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'phone',
	),
)); ?>
</div>
