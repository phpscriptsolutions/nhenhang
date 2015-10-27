<?php
$this->breadcrumbs=array(
	'Admin Cp Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('CpIndex')),	
);
$this->pageLabel = Yii::t('admin','Quản lý CP');

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>