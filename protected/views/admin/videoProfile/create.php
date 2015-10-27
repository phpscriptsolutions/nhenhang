<?php
$this->breadcrumbs=array(
	'Admin Video Profile Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('VideoProfileIndex')),	
);
$this->pageLabel = "Create VideoProfile";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>