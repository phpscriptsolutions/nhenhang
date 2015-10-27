<?php
$this->breadcrumbs=array(
	'Admin Tools Msisdn Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminToolsMsisdnModelIndex')),	
);
$this->pageLabel = "Create ToolsMsisdn";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>