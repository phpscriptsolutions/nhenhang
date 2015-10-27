<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin Top Content Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('TopContentCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách TopContent");


Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('admin-top-content-model-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    window.reorder_col = function()
    {
        $.post('".$this->createUrl('topContent/reordercol')."',$('.adminform').serialize(), function(data){
            alert('Cập nhật thành công!');
            window.location.reload();
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
                        array(''=>Yii::t("admin","Hành động"),'deleteAll'=>'Delete'),
                        array('onchange'=>'return submitform(this)')
                );
echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

echo '<div style="display:none">'.CHtml::checkBox ("all-item",false,array("value"=>$model->count(),"style"=>"width:30px")).'</div>';
echo '</div>';

if(Yii::app()->user->hasFlash('TopContent')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('TopContent').'</div>';
}


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-top-content-model-grid',
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
		'id',
                array(
                    'name' => 'name',
                    //'value' => 'chtml::link($data->name,Yii::app()->createUrl((($data->type=="video_playlist")?"videoPlaylist/videolist":$data->type."/view"),array("id"=>$data->content_id)))',
                    'value' => 'Chtml::link($data->name,Yii::app()->createUrl("topContent/update",array("id"=>$data->id)))',
                    'type' => 'raw',
                ),
		'type',
                'content_id',
                'group',
		'link',
		array(
                    'header'=>'Sắp xếp'.CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),"",array("onclick"=>"reorder_col()") ),
                    'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
                    'type' => 'raw',
                    'htmlOptions'=>array('align'=>'center')
		),
		/*
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-top-content-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),


		),
	),
));
$this->endWidget();

?>
