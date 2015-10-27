<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Quản lí nhóm SMS'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('spam-GroupCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách SpamSmsGroup");
?>
<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-spam-sms-group-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

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
$html_exp = '
    <div id="expand">
        <p id="show-exp">&nbsp;&nbsp;</p>
        <ul id="mn-expand" style="display:none">
            <li><a href="javascript:void(0)" class="item-in-page">'. Yii::t("admin","Chọn trang này").'('.$model->search()->getItemCount().')</a></li>
            <li><a href="javascript:void(0)" class="all-item">'.  Yii::t("admin","Chọn tất cả").' ('.$model->count().')</a></li>
            <li><a href="javascript:void(0)" class="uncheck-all">'.  Yii::t("admin","Bỏ chọn tất cả").'</a></li>
        </ul>
    </div>
';

$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl("spam/".$this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>$padding),
));

if(Yii::app()->user->hasFlash('SpamSmsGroup')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('SpamSmsGroup').'</div>';
}


$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-spam-sms-group-model-grid',
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
		array(
			'name'=>'name',
			'value'=>'chtml::link(Formatter::substring($data->name," ",12),Yii::app()->createUrl("spam/Group/view",array("id"=>$data->id)))',
            'type'=>'raw',
		),
		'description',
		'total_phone',
		'id',
		array(
			'class'=>'CButtonColumn',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-spam-sms-group-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),


		),
	),
));
$this->endWidget();

?>
