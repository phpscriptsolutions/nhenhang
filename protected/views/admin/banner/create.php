<?php
$this->breadcrumbs=array(
	'Banner Models'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List', 'url'=>array('index'), 'visible'=>UserAccess::checkAccess('BannerIndex')),	
);
$this->pageLabel = "Create Banner";

?>

<?php 
if(isset(Yii::app()->session['channel']) && Yii::app()->session['channel']=='app'){
	echo $this->renderPartial('_formapp', array('model'=>$model, 'uploadModel'=>$uploadModel));	
}else{
	echo $this->renderPartial('_form', array('model'=>$model, 'uploadModel'=>$uploadModel));
}
 
?>