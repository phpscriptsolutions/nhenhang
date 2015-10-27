<?php
$this->breadcrumbs=array(
	'Admin Top Content Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminTopContentModelIndex')),	
);
$this->pageLabel = "Create TopContent";
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>