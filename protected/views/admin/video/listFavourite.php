<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin Video Models'=>array('index'),
	'Manage',
);
$this->pageLabel = Yii::t('admin', "Danh sách yêu thích");
?>


<?php
if($model->search()->getItemCount() == 0 ){
    $padding = "padding:26px 0";
}else{
    $padding = "";
}
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>$padding),
));

                    
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-video-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
				'id',
		        array(
			    	'header'=>'Tên user',
			        'name' => 'user.username',
		        ),
			),
));
$this->endWidget();

?>
