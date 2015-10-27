<?php
$this->breadcrumbs=array(
	'Admin Feature Video Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminFeatureVideoModelIndex')),
	array('label'=>'Create', 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AdminFeatureVideoModelCreate')),
	array('label'=>'View', 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminFeatureVideoModelView')),
	array('label'=>'Copy', 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminFeatureVideoModelCopy')),
);
$this->pageLabel = "Update FeatureVideo ";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>