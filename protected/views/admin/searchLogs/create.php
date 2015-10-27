<?php
$this->breadcrumbs=array(
	'Search Logs Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SearchLogsIndex')),	
);
$this->pageLabel = "Create SearchLogs";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>