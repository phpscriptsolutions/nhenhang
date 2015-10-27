<?php
$this->breadcrumbs=array(
	'Admin Tools Setting Get Msisdn Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminToolsSettingGetMsisdnModelIndex')),	
);
$this->pageLabel = "Create ToolsSettingGetMsisdn";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>