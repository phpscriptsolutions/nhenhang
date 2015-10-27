<?php
$this->breadcrumbs=array(
	'Admin Ads Marketing Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ads-AdsMarketingIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ads-AdsMarketingCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('ads-AdsMarketingView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('ads-AdsMarketingCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật AdsMarketing")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>