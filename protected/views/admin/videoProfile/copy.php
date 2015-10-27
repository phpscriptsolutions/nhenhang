<?php
$this->breadcrumbs=array(
	'Admin Video Profile Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('VideoProfileIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('VideoProfileCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('VideoProfileView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép VideoProfile")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>