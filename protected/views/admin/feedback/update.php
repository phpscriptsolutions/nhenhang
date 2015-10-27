<?php
$this->breadcrumbs=array(
	'User Reports Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('UserReportsModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('UserReportsModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('UserReportsModelView')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật UserReports")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>