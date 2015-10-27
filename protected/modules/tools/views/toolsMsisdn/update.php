<?php
$this->breadcrumbs=array(
	'Admin Tools Msisdn Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminToolsMsisdnModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AdminToolsMsisdnModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminToolsMsisdnModelView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminToolsMsisdnModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật ToolsMsisdn")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>