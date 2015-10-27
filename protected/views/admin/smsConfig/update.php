<?php
$this->breadcrumbs=array(
	'Sms Config Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SmsConfigIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('SmsConfigCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('SmsConfigView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('SmsConfigCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật SmsConfig")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>