<?php
$this->breadcrumbs=array(
	'Admin Video Playlist Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('VideoPlaylistIndex')),
	array('label'=>'Create', 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('VideoPlaylistCreate')),
	array('label'=>'View', 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('VideoPlaylistView')),
);
$this->pageLabel = "Copy Video Playlist #".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>