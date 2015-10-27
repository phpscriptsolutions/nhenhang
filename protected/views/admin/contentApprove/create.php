<?php
$this->breadcrumbs=array(
	'Content Approve Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ContentApproveModelIndex')),	
);
$this->pageLabel = "Create ContentApprove";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>