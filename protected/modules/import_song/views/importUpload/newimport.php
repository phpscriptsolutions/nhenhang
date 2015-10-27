<?php
$this->menu=array(
array('label'=>Yii::t('admin','Về trang trước'), 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('ImportSongIndex')),
);
$this->pageLabel = Yii::t('admin','Import bài hát');
?>
<?php echo $this->renderPartial('_form', array('uploadModel'=>$uploadModel,'model'=>$model));
?>