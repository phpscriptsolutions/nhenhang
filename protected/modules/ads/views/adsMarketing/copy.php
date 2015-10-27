<?php
$this->breadcrumbs=array(
	'Admin Ads Marketing Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminAdsMarketingModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AdminAdsMarketingModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminAdsMarketingModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép AdsMarketing")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>