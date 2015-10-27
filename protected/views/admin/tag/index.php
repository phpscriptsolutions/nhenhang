<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'dialog',
                'options'=>array(
                    'title'=>Yii::t('admin','Danh sách tag'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'350px',
                    'height'=>'auto',
					'buttons' => array(
								'Close'=>'js:function(){$(this).dialog("close")}',
			                    'Chọn'=>'js:function(){
									if(typeof tags == "undefined") tags = [];
			                    	var data = getCheckbox(".adminform .checkbox-column",tags);
			                    	tags = data;
			                    	displayTag(tags,"#tags");
			                    	$(this).dialog("close");
			                    }'			                    
								),
                ),
                ));

Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");

Yii::app()->clientScript->registerScript('search', "
$('.search-box').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#tag_search_form').submit(function(){
	$.fn.yiiGridView.update('admin-tag-model-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->renderPartial('_search',array('model'=>$model,));
$this->renderPartial('_form',array());

$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
));

if(Yii::app()->user->hasFlash('Tag')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('Tag').'</div>';
}

//$this->widget('application.widgets.admin.grid.GGridview', array(
$this->widget('application.widgets.admin.grid.CGridView', array(
	'id'=>'admin-tag-model-grid',
	'dataProvider'=>$model->search(),
	'summaryText'=>'',
	'columns'=>array(
            array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),

        array(
        	'header'=>'name',
        	'name'=>'name',
        	'htmlOptions'=>array('class'=>'tagname artist_name'),
        ),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
		),
	),
	'htmlOptions'=>array('style'=>'height:450px;',),
	'pager'=>array('class'=>'CLinkPager','maxButtonCount'=>3),
));

$this->endWidget();
$this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
