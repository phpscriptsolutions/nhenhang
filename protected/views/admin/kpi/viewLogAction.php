<?php
$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('logAction')),
);
$this->pageLabel = Yii::t('admin', "Thông tin Logaction")."#".$model->id;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'adminId',
		'adminName',
		'controller',
		'action',
        'params',
		'ip',
		'created_time',
	),
)); ?>
</div>
