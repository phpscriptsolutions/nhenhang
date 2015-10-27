<?php
$this->breadcrumbs=array(
	'Admin Song Profile Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SongProfileIndex')),	
);
$this->pageLabel = "Create SongProfile";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>