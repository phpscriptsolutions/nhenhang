<?php
$this->breadcrumbs=array(
	'Admin Metadata Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('MetadataIndex')),	
);
$this->pageLabel = "Create Metadata";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>