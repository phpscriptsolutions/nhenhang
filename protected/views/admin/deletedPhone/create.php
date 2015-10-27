<?php
$this->breadcrumbs=array(
	'Deleted Phone Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('DeletedPhoneIndex')),	
);
$this->pageLabel = "Create DeletedPhone";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>