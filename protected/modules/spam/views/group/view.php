<?php
$this->breadcrumbs=array(
	'Quản lí nhóm SMS'=>array('index'),
	$model->name,
);
$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('spam-GroupIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('spam-GroupUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('spam-GroupDelete')),
//	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('spam-AdminSpamSmsGroupModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin SpamSmsGroup")."#".$model->id;
?>

<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
//		'total_phone',
	),
)); 
$this->renderPartial('phone_list', array(
            'model' => $phoneList,'group_id' => $group_id, 'uploadModel' => $uploadModel, 'message' => $message,  'errorList' => $errorList, 'dupList' => $dupList, 'subscribeList' => $subscribeList
        ));
?>
</div>
