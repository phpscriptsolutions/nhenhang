<?php
$this->breadcrumbs=array(
	'Admin Song Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SongIndex')),	
);
$this->pageLabel =Yii::t('admin','Copy bài hát: {name}',array('{name}'=>$model->name));
?>



<?php //echo $this->renderPartial('_form', array('model'=>$model,'uploadModel'=>$uploadModel,'categoryList'=>$categoryList)); ?>
<?php echo $this->renderPartial('_form', array(
											'model'=>$model,
											'uploadModel'=>$uploadModel,
											'categoryList'=>$categoryList,
											'cpList'=>$cpList,
										)); ?>