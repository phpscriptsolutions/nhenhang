<?php
$this->breadcrumbs=array(
	'Admin Ads Source Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminAdsSourceModelIndex')),	
);
$this->pageLabel = "Create AdsSource";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>