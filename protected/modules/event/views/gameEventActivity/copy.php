<?php
$this->breadcrumbs=array(
	'Game Event Activity Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('GameEventActivityModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('GameEventActivityModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('GameEventActivityModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép GameEventActivity")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>