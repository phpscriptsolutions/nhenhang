<?php
$this->breadcrumbs=array(
	'Radio Collection Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RadioCollectionModelIndex')),	
);
$this->pageLabel = "Create RadioCollection";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>