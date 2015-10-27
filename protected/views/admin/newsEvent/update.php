<?php
$this->breadcrumbs=array(
	'Admin News Event Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('NewsEventIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('NewsEventCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('NewsEventView')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật NewsEvent")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>