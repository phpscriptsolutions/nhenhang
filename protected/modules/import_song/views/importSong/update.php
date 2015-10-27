<?php
$this->breadcrumbs=array(
	'Import Song Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ImportSongModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ImportSongModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('ImportSongModelView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('ImportSongModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật ImportSong")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>