<?php
$this->breadcrumbs=array(
	'Admin Genre Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GenreIndex')),	
);
$this->pageLabel = "Create Genre";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'categoryList'=>$categoryList,)); ?>