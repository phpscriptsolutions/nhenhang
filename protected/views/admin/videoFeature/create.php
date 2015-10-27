<?php
$this->breadcrumbs=array(
	'Admin Feature Video Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminFeatureVideoModelIndex')),	
);
$this->pageLabel = "Create FeatureVideo";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>