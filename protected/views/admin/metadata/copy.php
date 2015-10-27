<?php
$this->breadcrumbs=array(
	'Admin Metadata Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('MetadataIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('MetadataCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('MetadataView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Metadata")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>