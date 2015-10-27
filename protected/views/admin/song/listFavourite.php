
<?php
if($model->search()->getItemCount() == 0 ){
    $padding = "padding:26px 0";
}else{
    $padding = "";
}
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
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
