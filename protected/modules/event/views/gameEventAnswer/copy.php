<?php
$this->breadcrumbs=array(
	'Game Event Answer Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GameEventAnswerModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('GameEventAnswerModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('GameEventAnswerModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép GameEventAnswer")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>