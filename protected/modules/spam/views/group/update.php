<?php
$this->breadcrumbs=array(
	'Quản lí nhóm SMS'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('spam-GroupIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('spam-GroupCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('spam-GroupView')),
//	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('spam-AdminSpamSmsGroupModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật SpamSmsGroup")."#".$model->id;

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>