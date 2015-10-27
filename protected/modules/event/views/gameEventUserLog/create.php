<?php
$this->breadcrumbs=array(
	'Game Event User Log Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GameEventUserLogModelIndex')),	
);
$this->pageLabel = "Create GameEventUserLog";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>