<?php
$this->breadcrumbs=array(
	'Banner Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('BannerIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('BannerCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('BannerView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Banner")."#".$model->id;
?>


<?php 

if(isset(Yii::app()->session['channel']) && Yii::app()->session['channel']=='app'){
	echo $this->renderPartial('_formapp', array('model'=>$model, 'uploadModel'=>$uploadModel));	
}else{
	echo $this->renderPartial('_form', array('model'=>$model, 'uploadModel'=>$uploadModel));
}

 ?>