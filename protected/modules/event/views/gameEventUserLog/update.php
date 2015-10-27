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
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('GameEventUserLogModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật GameEventUserLog")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>