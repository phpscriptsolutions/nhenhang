<?php
$this->breadcrumbs=array(
	'Game Event Question Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('event-GameEventQuestionModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('event/GameEventQuestionModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('Event-GameEventQuestionModelView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('Event/GameEventQuestionModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật GameEventQuestion")."#".$model->id;

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'answers'=>$answers)); ?>