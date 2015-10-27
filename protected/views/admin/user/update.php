<?php
$this->breadcrumbs=array(
	'Admin User Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('UserIndex')),
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin','Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('UserView')),
	array('label'=>Yii::t('admin','Copy'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('UserCopy')),
);
$this->pageLabel = "Update User ";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>