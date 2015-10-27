<?php
$this->breadcrumbs=array(
	'Admin Shortlink Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminShortlinkModelIndex')),	
);
$this->pageLabel = "Create Shortlink";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>