<?php
$this->breadcrumbs=array(
	'Spam Sms Reject Phone Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('spam-SpamSmsRejectPhoneModelIndex')),	
);
$this->pageLabel = "Create SpamSmsRejectPhone";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>