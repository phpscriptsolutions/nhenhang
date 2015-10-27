<?php
$this->breadcrumbs=array(
	'Admin Video Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('VideoIndex')),
	array('label'=>Yii::t('admin','Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('VideoView')),
);
$this->pageLabel = "Update Video ";

?>

<?php echo $this->renderPartial('_form', array(
											'model'=>$model,
											'categoryList'=>$categoryList,
											'cpList'=>$cpList, 
											'uploadModel'=>$uploadModel,
                                            'activetime'=>$activetime,
                                            'supperAdmin' => $supperAdmin
								)); ?>