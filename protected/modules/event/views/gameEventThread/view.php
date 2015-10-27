<?php
$this->breadcrumbs=array(
	'Game Event Thread Models'=>array('index'),
	$model->name,
);


$this->pageLabel = Yii::t('admin', "Thông tin GameEventThread")."#".$model->id;
?>


<div class="content-body">
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'question_list',
		'created_time',
	),
)); ?>
</div>

<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");
$this->menu = array(
	array('label' => Yii::t('admin', 'Danh sách'), 'url' => array('index')),
	array('label' => Yii::t('admin', 'Thêm mới'), 'url' => array('create')),
	array('label' => Yii::t('admin', 'Cập nhật'), 'url' => array('update', 'id' => $model->id)),
	array('label' => Yii::t('admin', 'Xóa'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
	array('label' => 'Thêm mới item', 'url' => "#", 'visible' => true, 'linkOptions' => array('onclick' => 'addItem()')),
);

Yii::app()->clientScript->registerScript('mainscript', "


window.addItem = function(){
	jQuery.ajax({
	  'onclick':'$(\"#jobDialog\").dialog(\"open\"); return false;',
	  'url':'" . $this->createUrl("gameEventQuestion/addQuestion") . "',
	  'type':'GET',
	  'data': { thread_id : '$thread_id'  },
	  'cache':false,
	  'success':function(html){
	  jQuery('#jobDialog').html(html)
}
});
return;
}

");
?>
<?php
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl("event/gameEventThread/deleteQuestion"),//Yii::app()->createUrl($this->getId().'/bulk'),//Yii::app()->createUrl('event/gameEventQuestion/deleteQuestion'),//Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>''),
));
echo '<style>
.grid-view input[type="text"] {
    width: 50px;
}    
</style>';
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'admin-collection-modell-grid',
    'dataProvider' => $questions->customSearch($model->question_list),
    'columns' => array(
        'id',
        array(
            'header' => 'Câu hỏi',
            'value' => '$data->name',
        ),        
       // $arr,
       
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'Yii::app()->createUrl("event/gameEventThread/deleteQuestion",array("thread_id" => '.$thread_id.',"question_id"=>$data->id))',
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('admin-collection-modell-grid',{ data:{pageSize: $(this).val() }})",
            )),
        ),
       
    ),
));
$this->endWidget();
?>