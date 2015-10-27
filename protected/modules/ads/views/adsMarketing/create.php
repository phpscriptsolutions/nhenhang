<?php
$this->breadcrumbs=array(
	'Admin Ads Marketing Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ads-AdsMarketingIndex')),	
);
$this->pageLabel = "Tạo quảng cáo truyền thông";

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>