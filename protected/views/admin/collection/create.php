<?php
$this->breadcrumbs=array(
	'Collection Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('CollectionIndex')),	
);
$this->pageLabel = "Create Collection";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'msg' => isset($msg)?$msg:"")); ?>