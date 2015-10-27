<?php
$this->breadcrumbs=array(
	'Admin User Models'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('UserIndex')),
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin','Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('UserUpdate')),
	array('label'=>Yii::t('admin','Copy'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('UserCopy')),
);
$this->pageLabel = "View User#".$model->id;
?>



<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'password',
		'fullname',
		'phone',
		'email',
		'gender',
		'address',
		'login_time',
		'created_time',
		'updated_time',
		'status',
	),
)); ?>
