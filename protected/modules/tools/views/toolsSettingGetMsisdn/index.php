<?php
$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('tools-ToolsSettingGetMsisdnCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách cấu hình lọc thuê bao");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-tools-setting-get-msisdn-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

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
echo $html_exp;

if(Yii::app()->user->hasFlash('ToolsSettingGetMsisdn')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('ToolsSettingGetMsisdn').'</div>';
}


$this->widget('application.widgets.admin.grid.CGridView', array(
	'id'=>'admin-tools-setting-get-msisdn-model-grid',
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
		'name',
		//'description',
		'created_datetime',
		array(
			'header'=>'Status',
			'type'=>'raw',
			'value'=>'$data->status=="Completed"?"<span class=\"s_label s_1\">$data->status</span>&nbsp;<span class=\"s_label s_1\"><a href=\"index.php?r=tools/ToolsMsisdn&id=$data->id\" target=\"_blank\">Thuê bao</a></span>":"<span class=\"s_label s_0\">$data->status</span>"'
		),
		array(
			'class'=>'CButtonColumn',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-tools-setting-get-msisdn-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),
			'template'=>'{view}{update}{delete}',
			/* 'buttons'=>array(
				'list_msisdn'=>array(
					'label'=>'danh sách',
					'url'=>'Yii::app()->createUrl(\'/tools/ToolsMsisdn\', array("id"=>$data->id))',
				)
			) */

		),
	),
));
$this->endWidget();

?>
