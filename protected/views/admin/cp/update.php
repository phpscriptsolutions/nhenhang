<?php
$this->breadcrumbs=array(
	'Admin Cp Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('CpIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('CpCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('CpView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('CpCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật Cp")."#".$model->name;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>