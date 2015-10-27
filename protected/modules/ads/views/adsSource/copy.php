<?php
$this->breadcrumbs=array(
	'Admin Ads Source Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminAdsSourceModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AdminAdsSourceModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminAdsSourceModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép AdsSource")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>