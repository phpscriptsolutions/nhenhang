<?php
$this->breadcrumbs=array(
	'Admin Feature Album Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AlbumFeatureIndex')),
	array('label'=>'Create', 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AlbumFeatureCreate')),
	array('label'=>'View', 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AlbumFeatureView')),
	array('label'=>'Copy', 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('AlbumFeatureCopy')),
);
$this->pageLabel = "Update FeatureAlbum ";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>