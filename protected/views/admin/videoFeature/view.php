<?php
$this->breadcrumbs=array(
	'Admin Feature Video Models'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminFeatureVideoModelIndex')),
	array('label'=>'Create', 'url'=>array('create')),
	array('label'=>'Update', 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminFeatureVideoModelUpdate')),
	array('label'=>'Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('AdminFeatureVideoModelDelete')),
	array('label'=>'Copy', 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminFeatureVideoModelCopy')),
);
$this->pageLabel = "View FeatureVideo#".$model->id;
?>



<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'video_id',
		'created_by',
		'created_time',
		'sorder',
		'status',
	),
)); ?>
