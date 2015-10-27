<?php
$this->breadcrumbs=array(
	'Admin Weather Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminWeatherModelIndex')),	
);
$this->pageLabel = "Create Weather";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>