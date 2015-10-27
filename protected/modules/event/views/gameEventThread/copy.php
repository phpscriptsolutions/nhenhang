<?php
$this->breadcrumbs=array(
	'Game Event Thread Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GameEventThreadModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('GameEventThreadModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('GameEventThreadModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép GameEventThread")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>