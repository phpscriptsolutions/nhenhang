<?php
$this->breadcrumbs=array(
	'Admin Genre Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GenreIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('GenreCreate')),
);
$this->pageLabel = Yii::t('admin', "Sao chép Genre")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model,'categoryList'=>$categoryList)); ?>