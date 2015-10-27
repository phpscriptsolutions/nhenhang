<?php
$this->breadcrumbs=array(
	'Game Event User Log Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GameEventUserLogModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('GameEventUserLogModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('GameEventUserLogModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép GameEventUserLog")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>