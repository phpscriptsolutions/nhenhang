<?php
$this->breadcrumbs=array(
	'Admin Email Template Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('EmailTemplateIndex')),	
);
$this->pageLabel = "Create EmailTemplate";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>