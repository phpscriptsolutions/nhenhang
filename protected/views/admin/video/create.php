<?php
$this->breadcrumbs=array(
	'Admin Video Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('VideoIndex')),	
);
$this->pageLabel = Yii::t('admin','Thêm mới video'); 

?>


<?php echo $this->renderPartial('_form', array(
											'model'=>$model,
											'categoryList'=>$categoryList,
											'cpList'=>$cpList, 
											'uploadModel'=>$uploadModel,
                                            'supperAdmin' => $supperAdmin
								)); ?>