<?php
$this->breadcrumbs=array(
	'Admin Feature Album Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AlbumFeatureIndex')),	
);
$this->pageLabel = "Create FeatureAlbum";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>