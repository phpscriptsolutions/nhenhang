<?php
$this->breadcrumbs=array(
	'Admin User Subscribe Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Danh sách', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('UserSubscribeIndex')),	
);
$this->pageLabel = "Create UserSubscribe";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'packageList'=>$packageList,)); ?>