<?php
$this->breadcrumbs=array(
	'Game Event Thread Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GameEventThreadModelIndex')),	
);
$this->pageLabel = "Create GameEventThread";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>