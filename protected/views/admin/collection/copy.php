<?php
$this->breadcrumbs=array(
	'Collection Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('CollectionIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('CollectionCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('CollectionView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Collection")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>