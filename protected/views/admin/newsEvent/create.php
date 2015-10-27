<?php
$this->breadcrumbs=array(
	'Admin News Event Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('NewsEventIndex')),
);
$this->pageLabel = "Create NewsEvent";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>