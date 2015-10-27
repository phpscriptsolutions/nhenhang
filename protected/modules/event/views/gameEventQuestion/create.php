<?php
$this->breadcrumbs=array(
	'Game Event Question Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GameEventQuestionModelIndex')),	
);
$this->pageLabel = "Create GameEventQuestion";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>