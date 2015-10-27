<?php
$this->breadcrumbs=array(
	'Admin Album Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AlbumIndex')),
	array('label'=>'Create', 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AlbumCreate')),
	array('label'=>'View', 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AlbumView')),
);
$this->pageLabel = "Copy Album #".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>