<?php
$this->breadcrumbs=array(
	'Sms Config Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SmsConfigIndex')),	
);
$this->pageLabel = "Thêm mới";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>