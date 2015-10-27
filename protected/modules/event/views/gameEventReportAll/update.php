<?php
$this->breadcrumbs=array(
	'Game Event Report All Models'=>array('index'),
	$model->date=>array('view','id'=>$model->date),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GameEventReportAllModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('GameEventReportAllModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->date), 'visible'=>UserAccess::checkAccess('GameEventReportAllModelView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->date), 'visible'=>UserAccess::checkAccess('GameEventReportAllModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật GameEventReportAll")."#".$model->date;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>