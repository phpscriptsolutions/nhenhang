<?php
$this->breadcrumbs=array(
	'Admin User Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('UserIndex')),	
);
$this->pageLabel = "Create User";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>