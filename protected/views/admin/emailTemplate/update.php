<?php
$this->breadcrumbs=array(
	'Admin Email Template Models'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('EmailTemplateIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('EmailTemplateCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('EmailTemplateView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('EmailTemplateCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật EmailTemplate")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>