<?php
$this->breadcrumbs=array(
	'Deleted Phone Models'=>array('index'),
	$model->phone=>array('view','id'=>$model->phone),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('DeletedPhoneIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('DeletedPhoneCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->phone), 'visible'=>UserAccess::checkAccess('DeletedPhoneView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->phone), 'visible'=>UserAccess::checkAccess('DeletedPhoneCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật DeletedPhone")."#".$model->phone;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>