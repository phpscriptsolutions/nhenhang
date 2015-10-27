<?php
$this->breadcrumbs=array(
	'User Reports Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('UserReportsModelIndex')),	
);
$this->pageLabel = "Create UserReports";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>