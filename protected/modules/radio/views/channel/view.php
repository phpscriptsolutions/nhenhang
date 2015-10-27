<?php
$this->breadcrumbs=array(
	'Admin Radio Models'=>array('index'),
	$model->name,
);

/* $this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AdminRadioModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminRadioModelUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('AdminRadioModelDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('AdminRadioModelCopy')),
); */
//$this->pageLabel = Yii::t('admin', "Thông tin Radio")."#".$model->id;
?>

<div class="submenu title-box xfixed">
<div class="portlet" id="yw2">
<div class="portlet-content">
<div class="page-title">Chi tiết Kênh # <?php echo $model->id;?></div>
<ul class="operations menu-toolbar" id="yw3">
<li><a href="<?php echo Yii::app()->createUrl('/radio/channel', array('id'=>$model->id))?>">Quay lại Danh sách Kênh</a></li>
<li><a href="<?php echo Yii::app()->createUrl('/radio/collection', array('id'=>$model->id))?>">Danh sách Collection</a></li>
</ul>
</div>
</div>
</div>
<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'parent_id',
		'type',
		'time_point',
		'day_week',
		'object_ids',
		'ordering',
	),
)); ?>
</div>
