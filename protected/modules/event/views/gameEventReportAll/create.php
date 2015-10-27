<?php
$this->breadcrumbs=array(
	'Game Event Report All Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GameEventReportAllModelIndex')),	
);
$this->pageLabel = "Create GameEventReportAll";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>