<?php
$this->breadcrumbs=array(
	'Admin Shortlink Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminShortlinkModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AdminShortlinkModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminShortlinkModelView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminShortlinkModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật Shortlink")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>