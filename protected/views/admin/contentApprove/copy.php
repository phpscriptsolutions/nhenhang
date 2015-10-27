<?php
$this->breadcrumbs=array(
	'Content Approve Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ContentApproveModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ContentApproveModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('ContentApproveModelView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép ContentApprove")."#".$model->id;
?>



<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>