<?php
$this->breadcrumbs=array(
	'Search Logs Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SearchLogsIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('SearchLogsCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('SearchLogsView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép SearchLogs")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>