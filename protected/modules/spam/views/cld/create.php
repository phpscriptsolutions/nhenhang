<?php
$this->breadcrumbs=array(
	'Quản lí lịch bắn tin'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('spam-CldIndex')),	
);
$this->pageLabel = "Create SpamSmsCld";

?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'smsGroup'=>$smsGroup,'error' => $error)); ?>