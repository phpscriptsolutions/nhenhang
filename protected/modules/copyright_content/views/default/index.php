<?php
/* @var $this DefaultController */
/* @var $model CopyrightSongFileModel */

$this->breadcrumbs=array(
	'Copyright Song File Models'=>array('index'),
	'Manage',
);
$this->menu=array(
	array('label'=>'Thêm mới', 'url'=>array('create')),
);
$this->pageLabel = "Quản lý File đầu vào";

?>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'copyright-input-file-model-grid',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'file_name',
        'content_type',
		'created_by',
		'created_time',
		'id',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
