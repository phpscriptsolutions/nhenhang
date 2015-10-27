<?php
$this->breadcrumbs=array(
	'Admin Top Content Models'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('TopContentIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('TopContentUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('TopContentDelete')),
);
$this->pageLabel = Yii::t('admin', "Thông tin TopContent")."#".$model->id;

?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(        
                     'name'=>'',
                     'value'=>  '<img src="'.$model->getAvatarUrl().'" alt="" width="690px" height="296px" />',
                     'type' => 'raw'
                ),
                'id',
		'name',
		'type',
                'content_id',
                'group',
		'link',
		'sorder',
		'status',
	),
)); ?>
</div>
