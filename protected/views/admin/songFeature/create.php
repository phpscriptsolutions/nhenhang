<?php
$this->breadcrumbs=array(
	'Admin Feature Song Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SongFeatureIndex')),	
);
$this->pageLabel = "Create FeatureSong";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>