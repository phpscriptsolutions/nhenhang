<?php

$this->menu=array(
	array('label'=>Yii::t('admin','Danh sách'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('SongIndex')),	
);
$this->pageLabel = Yii::t('admin','Thêm mới bài hát');

?>


<?php echo $this->renderPartial('_form', array(
											'model'=>$model,
											'uploadModel'=>$uploadModel,
											'categoryList'=>$categoryList,
											'cpList'=>$cpList,
                                            'copyright'=>$copyright,
                                            'hadsong' => $hadsong
										)); ?>