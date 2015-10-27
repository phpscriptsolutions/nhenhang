<?php
$this->breadcrumbs=array(
	'Admin Artist Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ArtistIndex')),	
);
$this->pageLabel = Yii::t('admin','Thêm mới nghệ sỹ'); 

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'categoryList'=>$categoryList,'uploadModel'=>$uploadModel,'artistMeta'=>$artistMeta)); ?>