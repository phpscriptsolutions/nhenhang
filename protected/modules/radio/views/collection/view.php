<?php
$this->breadcrumbs=array(
	'Radio Collection Models'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RadioCollectionModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create')),
	array('label'=>Yii::t('admin', 'Cập nhật'), 'url'=>array('update', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RadioCollectionModelUpdate')),
	array('label'=>Yii::t('admin', 'Xóa'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?'), 'visible'=>UserAccess::checkAccess('RadioCollectionModelDelete')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('RadioCollectionModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Thông tin RadioCollection")."#".$model->id;
?>
<div class="submenu title-box xfixed">
<div class="portlet" id="yw2">
<div class="portlet-content">
<div class="page-title">Chi tiết Collection # <?php echo $model->id;?></div>
<ul class="operations menu-toolbar" id="yw3">
<li><a href="<?php echo Yii::app()->createUrl('/radio/collection', array('id'=>$model->radio_id))?>">Quay lại Danh sách Collection</a></li>
</ul>
</div>
</div>
</div>

<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'radio_id',
		'collection_id',
		'ordering',
	),
)); ?>
</div>
