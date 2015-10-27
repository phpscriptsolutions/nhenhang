<?php
$form=$this->beginWidget('CActiveForm', array(
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-playlist-fav-model-grid',
	'dataProvider'=>$favlist->search(),	
	'columns'=>array(
		'id',
        array(
        	'header'=>'User',
            'name' => 'user.username',
		),
		/*
		array(
			'class'=>'CButtonColumn',
			'header'=> Yii::t('admin','Xóa'),
			'template'=>'{delete}',
			'deleteButtonUrl'=>'Yii::app()->controller->createUrl("deleteItems",array("cid[]"=>$data->id))'
		
		),
		*/
	),
));

$this->endWidget();