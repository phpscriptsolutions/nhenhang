<?php
$this->breadcrumbs=array(
	'Config Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ConfigIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ConfigSupper_Index',true)),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('ConfigView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('ConfigSupper_Index',true)),
);
$this->pageLabel = Yii::t('admin', "Cập nhật Config")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'update' => 'yes')); ?>