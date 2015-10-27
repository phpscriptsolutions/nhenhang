<?php

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('VideoIndex')),
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('VideoCreate')),
	array('label'=>Yii::t('admin','Thông tin'), 'url'=>array('view', 'id'=>$model->id), 'visible'=>UserAccess::checkAccess('VideoView')),
);
$this->pageLabel = $this->pageLabel =Yii::t('admin','Copy Video: {name}',array('{name}'=>$model->name));
?>



<?php echo $this->renderPartial('_form', array(
											'model'=>$model,
											'videoMeta'=>$videoMeta,
											'categoryList'=>$categoryList,
											'cpList'=>$cpList, 
											'uploadModel'=>$uploadModel,
								)); ?>