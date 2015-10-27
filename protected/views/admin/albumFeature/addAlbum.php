<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('job','Danh sách album'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'650px',
                    'height'=>'auto',
                ),
                ));


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-album-list-model-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="title-box search-box">
    <?php echo CHtml::link(Yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">

<?php $this->renderPartial('_search',array(
	'model'=>$albumModel,
	'categoryList'=>$categoryList,
)); ?>
</div><!-- search-form -->

<?php

$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
    'method'=>'post',
    'htmlOptions'=>array('class'=>'popupform'),
));

$columns = array(
    
                array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),
                'id',
		        'name',
                array(
	                    'header'=>'Artist',
	                    'name' => 'artist_name',
                    ),
            );
            
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-album-list-model-grid',
	'dataProvider'=>$albumModel->search(),	
	'columns'=> $columns,
));

echo CHtml::ajaxSubmitButton(Yii::t('admin','Chọn'),CHtml::normalizeUrl(array('albumFeature/addAlbum','id'=>0)),array('success'=>'js: function(data) {
                        $("#jobDialog").dialog("close");
                        window.location.reload( true );
                    }'),array('id'=>'closeJobDialog'));
echo CHtml::hiddenField("object", $object);
echo CHtml::hiddenField("collect_id", $collect_id);
echo CHtml::button(Yii::t('admin','Bỏ qua'),array("onclick"=>'$("#jobDialog").dialog("close");'));


$this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog');

?>
