<?php
$this->breadcrumbs=array(
	'Admin News Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('NewsIndex')),	
);
$this->pageLabel = "Create News";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'uploadModel'=>$uploadModel,)); ?>