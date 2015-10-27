<?php
$this->breadcrumbs=array(
	'Admin Admin User Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminUserIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AdminUserCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminUserView')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật User")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'cpList'=>$cpList,'roles'=>$roles,'userRole'=>$userRole)); ?>