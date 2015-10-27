<?php
$this->breadcrumbs=array(
	'Admin Album Models'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('AlbumIndex')),
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('AlbumCreate')),
	array('label'=>Yii::t('admin','Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('AlbumView')),
);
$this->pageLabel = Yii::t('admin','Cập nhật album: {name}',array('{name}'=>$model->name)); 

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,
												'categoryList'=>$categoryList,
												'uploadModel'=>$uploadModel,
												'cpList'=>$cpList,
												'albumMeta'=>$albumMeta
								)); ?>