<?php
$this->breadcrumbs=array(
	'Import Song File Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ImportSongFileModelIndex')),	
);
$this->pageLabel = "Create ImportSongFile";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>