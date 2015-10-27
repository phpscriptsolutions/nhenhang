<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Collection Models'=>array('index'),
	'Manage',
);
$this->menu=array(
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('CollectionCreate')),
);

$this->pageLabel = Yii::t("admin","Danh sách Collection");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('collection-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

window.reorder_col = function()
{
   $.post('".$this->createUrl('collection/reorder_col')."',$('.adminform').serialize(), function(data){
        alert('Cập nhật thành công')
   });
}
");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

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
echo '<div class="op-box">';
echo CHtml::dropDownList('bulk_action','',
                        array(''=>Yii::t("admin","Hành động"),'deleteAll'=>'Delete','1'=>'Update'),
                        array('onchange'=>'return submitform(this)')
                );
echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

echo '<div style="display:none">'.CHtml::checkBox ("all-item",false,array("value"=>$model->count(),"style"=>"width:30px")).'</div>';
echo '</div>';
//echo $html_exp;

if(Yii::app()->user->hasFlash('Collection')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('Collection').'</div>';
}

$genre_id = Yii::app()->request->getParam('genre_id','');
$custom_field = Yii::app()->request->getParam('custom_field','');
echo "<input type='hidden' value='$genre_id' name='genre_id'/>";
echo "<input type='hidden' value='$custom_field' name='custom_field'/>";
if($genre_id){
	$col = array(
	              'header'=>'Sắp xếp'.CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),"",array("onclick"=>"reorder_col()") ),
	              'value'=> 'CHtml::textField("sorder[$data->id]", $data->col_gen->sorder,array("size"=>1))',
	              'type' => 'raw',
        		  'htmlOptions'=>array('align'=>'center')
              );
	$col2 = array(
            'class' => 'CLinkColumn',
            'header' => 'Hiển thị',
            'labelExpression' => '($data["status"]==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression' => '($data["status"]==1)?Yii::app()->createUrl("collection/unpublish",array("cid[]"=>$data["id"],"genre_id"=>'.$genre_id.')):Yii::app()->createUrl("collection/publish",array("cid[]"=>$data["id"],"genre_id"=>'.$genre_id.'))',
            'linkHtmlOptions' => array(
            ),
        );
}
else{
	$col = 'sql_query';
	$col2 = array(
            'class' => 'CLinkColumn',
            'header' => 'Hiển thị',
            'labelExpression' => '($data["status"]==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression' => '($data["status"]==1)?Yii::app()->createUrl("collection/unpublish",array("cid[]"=>$data["id"])):Yii::app()->createUrl("collection/publish",array("cid[]"=>$data["id"]))',
            'linkHtmlOptions' => array(
            ),
        );
}

if($custom_field){
    $col3 = array(
        'header'=>'Sắp xếp'.CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),"",array("onclick"=>"reorder_col()") ),
        'value'=> 'CHtml::textField("sorder[$data->id]", $data->'.$custom_field.',array("size"=>1))',
        'type' => 'raw',
        'htmlOptions'=>array('align'=>'center')
    );
}
else
    $col3 = 'mode';
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'collection-model-grid',
	'dataProvider'=>($genre_id)?$model->newsearch($genre_id):$model->search($custom_field?$custom_field:null),
	'columns'=>array(
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
		'code',
		'type',
		array(
            'class' => 'CLinkColumn',
            'header' => 'Show ở trang chủ',
            'labelExpression' => '($data["home_page"]>=1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression' => '($data["home_page"]>=1)?Yii::app()->createUrl("collection/unshowathomepage",array("cid[]"=>$data["id"])):Yii::app()->createUrl("collection/showathomepage",array("cid[]"=>$data["id"]))',
            'linkHtmlOptions' => array(
            ),
        ),
        $col3,
		$col,
		$col2,

		//'sql_query',
		array(
			'class'=>'CButtonColumn',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('collection-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),


		),
	),
));
$this->endWidget();

?>
