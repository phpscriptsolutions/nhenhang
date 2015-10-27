<?php
$this->breadcrumbs=array(
	'Radio Collection Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RadioCollectionModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('RadioCollectionModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RadioCollectionModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép RadioCollection")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>