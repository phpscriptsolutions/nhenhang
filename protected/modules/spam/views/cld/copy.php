<?php
$this->breadcrumbs=array(
	'Quản lí lịch bắn tin'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('spam-CldIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('spam-CldCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('spam-CldView')),
);
$this->pageLabel = Yii::t('admin', "Sao chép SpamSmsCld")."#".$model->id;
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>