<?php
$this->breadcrumbs=array(
	'Import Song File Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ImportSongFileModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ImportSongFileModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('ImportSongFileModelView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('ImportSongFileModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật ImportSongFile")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>