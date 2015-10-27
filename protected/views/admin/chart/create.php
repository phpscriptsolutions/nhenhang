<?php
$this->breadcrumbs=array(
	'Collection Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Danh sách', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('CollectionIndex')),
);
$this->pageLabel = "Tạo mới bảng xếp hạng";
?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'msg' => isset($msg)?$msg:"")); ?>