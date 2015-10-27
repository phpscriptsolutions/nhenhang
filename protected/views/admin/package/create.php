<?php
$this->breadcrumbs=array(
	'Admin Package Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('PackageIndex')),	
);
$this->pageLabel = "Create Package";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>