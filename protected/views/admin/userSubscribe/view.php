<?php
$this->breadcrumbs=array(
	'Admin User Subscribe Models'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('UserSubscribeIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
);
$this->pageLabel = Yii::t('admin', "Thông tin thuê bao").":".$model->user_phone;
$msg = Yii::app()->request->getparam('msg',null); 
if(isset($msg)){
	$msg = json_decode($msg);
	echo '<div class="wrr b fz13">';	
	echo 'Kết quả: Mã ['.$msg->errorCode.']: ['.$msg->message.']';
	echo '</div>';	
}
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'user_phone',
		'package_id',
		'created_time',
		'expired_time',
		'updated_time',
		//'event',
		'extended_count',
		'extended_retry_times',
		'status',
	),
)); ?>
</div>
