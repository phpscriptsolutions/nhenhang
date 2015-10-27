<?php
$this->breadcrumbs=array(
	'Admin Radio Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminRadioModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AdminRadioModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminRadioModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Radio")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>