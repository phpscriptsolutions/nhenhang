<?php
$this->breadcrumbs=array(
	'Import Song Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ImportSongModelIndex')),	
);
$this->pageLabel = "Create ImportSong";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>