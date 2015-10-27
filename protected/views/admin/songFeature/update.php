<?php
$this->breadcrumbs=array(
	'Admin Feature Song Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SongFeatureIndex')),
	array('label'=>'Create', 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('SongFeatureCreate')),
	array('label'=>'View', 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('SongFeatureView')),
	array('label'=>'Copy', 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('SongFeatureCopy')),
);
$this->pageLabel = "Update FeatureSong ";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>