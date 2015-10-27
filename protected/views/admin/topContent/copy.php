<?php
$this->breadcrumbs=array(
	'Admin Top Content Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminTopContentModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AdminTopContentModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminTopContentModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép TopContent")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>