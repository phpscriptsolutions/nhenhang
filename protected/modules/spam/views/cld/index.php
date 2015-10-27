<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Quản lí lịch bắn tin'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('spam-CldCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách SpamSmsCld");
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-spam-sms-cld-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

$(document).ready(function(){
    var isActive = new Array();
    var index = 0;
    $('.link-column a').each(function(i){
        var text = $(this).html();
        if(text=='Đã gửi'){
            $(this).css('color','#000');
            $(this).css('cursor','auto');
            $(this).css('text-decoration','none');
        }
        else if(text=='Đang gửi'){
            $(this).css('font-weight','bold');
            $(this).css('color','red');
            $(this).css('cursor','auto');
            $(this).css('text-decoration','none');
            $(this).parent('td').parent('tr').find('td').attr('style','background:#6AE86C!important');
            isActive[index++] = i;
        }
        else{
            $(this).css('font-weight','bold');
            $(this).parent('td').parent('tr').find('td').attr('style','background:#63D1ED!important');
        }
    });
    
    /**
    * Check xem co Cld nao o trang thai 1 (Dang gui) hay ko
    * Neu co thi hien ra thong bao
    */
    $('.link-column a').click(function(e){
        var text = $(this).html();
        if(text=='Chưa gửi'){
            if(isActive.length > 0){
                cfm = confirm('Hiện có lịch đang được bắn. Nếu bạn active lịch này thì lịch đang được bắn kia sẽ bị hủy bỏ. Bạn có chắc chắn muốn active lịch này không? ');
                if(!cfm)
                    e.preventDefault();
            }
            
        }
        
    });

});
");
?>

<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">

<?php $this->renderPartial('_search',array(
	'model'=>$model,'smsGroup'=>$smsGroup
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

if($model->search()->getItemCount() == 0 ){
    $padding = "padding:26px 0";
}else{
    $padding = "";
}
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl("spam/".$this->getId().'/bulk'),
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

if(Yii::app()->user->hasFlash('SpamSmsCld')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('SpamSmsCld').'</div>';
}

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-spam-sms-cld-model-grid',
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
		'description',
                'message',
		'group_id',
		'send_time',
//		'status',
                array(
                    'class'=>'CLinkColumn',
                    'header'=>'Status',
                    'labelExpression'=>'($data->status==0)?"Chưa gửi":(($data->status==1)?"Đang gửi":"Đã gửi")',
                    'urlExpression'=>'($data->status==0)?Yii::app()->controller->createUrl("Cld/active",array("cid"=>$data->id)):"javascript:void(0)"',
                    'linkHtmlOptions'=>array(
                                        ),

                ),
            
		/*
		'params',
		'created_time',
		*/
		array(
			'class'=>'CButtonColumn',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-spam-sms-cld-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),


		),
	),
));
$this->endWidget();

?>
