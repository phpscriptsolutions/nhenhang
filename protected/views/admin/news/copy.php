<?php
$this->breadcrumbs=array(
	'Admin News Models'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('NewsIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('NewsCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('NewsView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép News")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model,'uploadModel'=>$uploadModel,)); ?>