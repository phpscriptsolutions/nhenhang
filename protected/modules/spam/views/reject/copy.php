<?php
$this->breadcrumbs=array(
	'Spam Sms Reject Phone Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('spam-SpamSmsRejectPhoneModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('spam-SpamSmsRejectPhoneModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('spam-SpamSmsRejectPhoneModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép SpamSmsRejectPhone")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>