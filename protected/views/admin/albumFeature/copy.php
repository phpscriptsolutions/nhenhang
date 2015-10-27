<?php
$this->breadcrumbs=array(
	'Admin Feature Album Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AlbumFeatureIndex')),
	array('label'=>'Create', 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AlbumFeatureAddAlbum')),
	array('label'=>'View', 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AlbumFeatureIndex')),
);
$this->pageLabel = "Copy FeatureAlbum #".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>