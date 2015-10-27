<?php
$this->breadcrumbs=array(
	'Game Event Activity Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GameEventActivityModelIndex')),	
);
$this->pageLabel = "Create GameEventActivity";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>