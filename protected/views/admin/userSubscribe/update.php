<?php
$this->breadcrumbs=array(
	'Admin User Subscribe Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('UserSubscribeIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('UserSubscribeCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('UserSubscribeView')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật UserSubscribe")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>