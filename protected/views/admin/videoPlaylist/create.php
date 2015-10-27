<?php
$this->breadcrumbs=array(
	'Admin Video Playlist Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('VideoPlaylistIndex')),	
);
$this->pageLabel = Yii::t('admin','Tạo video playlist'); 

?>


<?php echo $this->renderPartial('_form', array('model'=>$model,
												'categoryList'=>$categoryList,
												'uploadModel'=>$uploadModel,
												'cpList'=>$cpList,												
								)); ?>