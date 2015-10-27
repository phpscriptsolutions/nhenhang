<?php
/* @var $this DefaultController */
/* @var $model CopyrightSongFileModel */

$this->breadcrumbs=array(
	'Copyright Song File Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Danh sách', 'url'=>array('index')),
);
$this->pageLabel = "Thêm mới 1 danh sách";
?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>