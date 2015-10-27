<?php
$this->breadcrumbs=array(
	'Admin Artist Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ArtistIndex')),
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ArtistCreate')),
);

$this->pageLabel = yii::t('admin','Sao chép thông tin nghệ sỹ - {name}',array('{name}'=>$model->name));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'categoryList'=>$categoryList, 'uploadModel'=>$uploadModel,'artistMeta'=>$artistMeta)); ?>