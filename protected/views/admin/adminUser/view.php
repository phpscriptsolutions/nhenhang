<?php
$this->breadcrumbs=array(
	'Admin Admin User Models'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminUserIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
);
$this->pageLabel = Yii::t('admin', "Thông tin User")."#".$model->id;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
                array(
                    'label'=>'Tên CP',
                    'value'=>$cp->name,
                ),
                array(
                    'label'=>'Tên đăng nhập',
                    'value'=>$model['username'],
                ),
		'email',
                array(
                    'label'=>'Tên đầy đủ',
                    'value'=>$model['fullname'],
                ),
                array(
                    'label'=>'Số điện thoại',
                    'value'=>$model['phone'],
                ),
                array(
                    'label'=>'Công ty',
                    'value'=>$model['company'],
                ),
                array(
                    'label'=>'Trạng thái',
                    'value'=>$model['status']?'Đang kích hoạt':'Không kích hoạt',
                ),
	),
)); ?>
</div>
