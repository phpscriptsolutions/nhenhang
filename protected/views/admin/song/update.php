<?php
$this->breadcrumbs=array(
	'Admin Song Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin', 'Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SongIndex')),
	array('label'=>Yii::t('admin', 'Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('SongView')),
	array('label'=>yii::t('admin','Xóa'), 'url'=>array('/song/confirmDel'), 'visible'=>UserAccess::checkAccess('SongIndex'),'linkOptions'=>array('class'=>'delete-obj')),
);
$this->pageLabel = Yii::t('admin', 'Cập nhật thông tin bài hát');
?>
<div class="form-delete hide">
	<form id="delete-obj-form">
		<input type="checkbox" checked="checked" name="cid[]" value="<?php echo $model->id ?>" />
		<input type="hidden" name="reqsource" value="viewlayout" />
	</form>
</div>

<?php echo $this->renderPartial('_form', array(
											'model'=>$model,
											'uploadModel'=>$uploadModel,
											'categoryList'=>$categoryList,
											'cpList'=>$cpList,
                                            'activetime'=>$activetime,
										)); ?>