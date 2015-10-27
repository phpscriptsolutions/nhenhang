<?php
$this->breadcrumbs=array(
	'Admin Package Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('PackageIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('PackageCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('PackageView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Package")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>