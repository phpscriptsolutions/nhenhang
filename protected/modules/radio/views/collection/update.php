<?php
$this->breadcrumbs=array(
	'Radio Collection Models'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('RadioCollectionModelIndex')),
	array('label'=>Yii::t('admin', 'Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('RadioCollectionModelCreate')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('RadioCollectionModelView')),
	array('label'=>Yii::t('admin', 'Sao chép'), 'url'=>array('copy','id'=>$model->id), 'visible'=>UserAccess::checkAccess('RadioCollectionModelCopy')),
);
$this->pageLabel = Yii::t('admin', "Cập nhật RadioCollection")."#".$model->id;

?>
<div class="submenu title-box xfixed">
<div class="portlet" id="yw2">
<div class="portlet-content">
<div class="page-title">Sửa Collection # <?php echo $model->id;?></div>
<ul class="operations menu-toolbar" id="yw3">
<li><a href="<?php echo Yii::app()->createUrl('/radio/collection', array('id'=>$model->radio_id))?>">Quay lại Danh sách Collection</a></li>
</ul>
</div>
</div>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>