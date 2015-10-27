<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'User Reports Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('UserReportsModelCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách Log lỗi từ player");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-reports-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

");
?>


<div class="search-form" style="display:block">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
));

if(Yii::app()->user->hasFlash('UserReports')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('UserReports').'</div>';
}


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-reports-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
            array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),
		
		'subject',
		'content',
		'content_id',
		'content_type',
		'ip',
		'user_id',
		'created_time',
		'id',
		/*
		'user_phone',
		'ip',
		'user_agent',
		'ref',
		'platform',
		'os',
		'os_version',
		'browse',
		'browse_version',
		'updated_time',
		'note',
		'status',
		'error_code',
		'error_type',
		*/
		array(
			'class'=>'CButtonColumn',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('user-reports-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),


		),
	),
));
$this->endWidget();

?>
