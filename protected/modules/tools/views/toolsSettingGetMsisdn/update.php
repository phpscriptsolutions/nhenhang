<?php
$this->breadcrumbs=array(
	'Admin Tools Setting Get Msisdn Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminToolsSettingGetMsisdnModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AdminToolsSettingGetMsisdnModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminToolsSettingGetMsisdnModelView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminToolsSettingGetMsisdnModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật ToolsSettingGetMsisdn")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'params'=>$params)); ?>