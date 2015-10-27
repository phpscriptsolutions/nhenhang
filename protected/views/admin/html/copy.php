<?php
$this->breadcrumbs=array(
	'Admin Html Models'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('HtmlIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('HtmlCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('HtmlView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Html")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>