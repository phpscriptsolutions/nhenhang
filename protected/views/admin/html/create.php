<?php
$this->breadcrumbs=array(
	'Admin Html Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('HtmlIndex')),	
);
$this->pageLabel = "Create Html";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>