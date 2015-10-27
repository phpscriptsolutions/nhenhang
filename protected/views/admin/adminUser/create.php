<?php
$this->breadcrumbs=array(
	'Admin Admin User Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=> Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminUserIndex')),	
);
$this->pageLabel = Yii::t('admin','Thêm mới'); 

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'cpList'=>$cpList,'roles'=>$roles,'userRole'=>'')); ?>