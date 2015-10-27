<?php
$this->breadcrumbs=array(
	'Config Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ConfigIndex')),	
);
$this->pageLabel = "Create Config";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>