<?php
$this->breadcrumbs=array(
	'Game Event Answer Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GameEventAnswerModelIndex')),	
);
$this->pageLabel = "Create GameEventAnswer";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>