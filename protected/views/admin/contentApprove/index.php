<style>
.s_0{
	cursor: pointer;
}
</style>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Content Approve Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ContentApproveModelCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách ContentApprove");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('content-approve-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

$('.s_0').live('click', function(){
	var id = $(this).attr('id');
	var type = $('#t_'+id).text();
		var url='admin.php?r=video/approvedAndApplyVideo&id='+id;
	if(type=='song'){
		url='admin.php?r=song/approvedAndApplySong&id='+id;
	}
		$.ajax({
	        url: url,
	        type: \"POST\",
	        dataType:\"json\",
	        data: {t:1},
	        beforeSend: function(){
				$(\"#r_\"+id).html(\"<img src=\'".Yii::app()->theme->baseUrl."/images/ajax-loader-top-page.gif\' />\")
		    },
	        success: function(Response) {
				if(Response.error_code==0){
					html = '<span class=\"s_label s_1\" id=\"'+id+'\">Đã duyệt</span>';
				}else{
					html = '<span class=\"s_label s_2\" id=\"'+id+'\">Fail</span>';
				}
	        		$(\"#r_\"+id).html(html);
	        }
	    });
})
");
?>
<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'sidebar_left')); ?>
<ul id="sub_menu" class="_submenu">
<li class="topline"><a class="menulink" href="<?php echo Yii::app()->createUrl('contentApprove/index')?>">Quản lý CTV</a></li>
<li class="topline"><a class="menulink" href="<?php echo Yii::app()->createUrl('reportAccount/index')?>">Thống kê khối lượng cv</a></li>
</ul>
<?php $this->endWidget();?>
<div class="title-box search-box">
    <?php echo CHtml::link(yii::t('admin','Tìm kiếm'),'#',array('class'=>'search-button')); ?></div>

<div class="search-form" style="display:block">

<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'userBeReport'=>$userBeReport
)); ?>
</div><!-- search-form -->
<button type="button" id="approve" >Duyệt Tất cả</button>
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

if(Yii::app()->user->hasFlash('ContentApprove')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('ContentApprove').'</div>';
}

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'content-approve-model-grid',
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
			'name'=> 'content_type',
			'value'=>'CHtml::tag("div",array("id"=>"t_$data->id"), $data->content_type)',
			'type'=>'raw'
		),	
		array(
			'name'=>'content_id',
			'value'=>'$data->content_type=="song"?CHtml::link($data->song->name, Yii::app()->createUrl("song/view", array("id"=>$data->content_id))):CHtml::link($data->video->name, Yii::app()->createUrl("video/view", array("id"=>$data->content_id)))',
			'type'=>'raw',
		),
		array(
			'header'=>'Artist Name',
			'value'=>'$data->content_type=="song"?$data->song->artist_name:$data->video->artist_name',
			'type'=>'raw',
		),
		array(
			'header'=>'Thời gian thực hiện',
			'value'=>'Formatter::time_elapsed(strtotime($data->created_time) - strtotime($data->approved_content_time))',
			'type'=>'raw',
		),
		'admin_name',
		array(
			'name'=>'approved_id',		
			'value'=>'$data->approved_id>0?AdminAdminUserModel::model()->findByPk($data->approved_id)->username:""',
			'type'=>'raw'
		),
		'created_time',
		array(
			'name'=>'status',
			'value'=>'"<div id=\"r_$data->id\">".CHtml::tag("span", array("class"=>"s_label s_$data->status","id"=>$data->id), str_replace(array(0,1,2),array("Chưa duyệt","Đã duyệt","Bỏ qua"), $data->status))."</div>"',
			'type'=>'raw',
			'htmlOptions'=>array('align'=>'center')
		),
		/*
		'data_change',
		'status',
		'created_time',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('content-approve-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),


		),
	),
));
$this->endWidget();

?>
<script>
$(function(){
	$('#cid_all').live('click',function() {
		var total_check = $("input[name='cid\[\]']:checked").length;
		
		if(total_check>0){
			$("#approve").show();
		}else{
			$("#approve").hide();	
		}
	})
	$("#approve").live('click', function(){
		var total_check = $("input[name='cid\[\]']:checked").length;
		if(total_check<=0){
			alert("Chọn ít nhất 1 bản ghi để duyệt");
			return false;
		}
		var cID=[];
		$("input[name='cid\[\]']:checked").each(function(){
			cID.push($(this).val());
		})
		ApproveAll(cID);
	})

	function ApproveAll(cid)
	{
		var id = cid[0];
		console.log(cid);
		var type = $('#t_'+id).text();
		var url='admin.php?r=video/approvedAndApplyVideo&id='+id;
		if(type=='song'){
			url='admin.php?r=song/approvedAndApplySong&id='+id;
		}
		$.ajax({
	        url: url,
	        type: "POST",
	        dataType:"json",
	        async: true,
	        data: {t:1},
	        beforeSend: function(){
				$("#r_"+id).html("<img src='<?php echo Yii::app()->theme->baseUrl;?>/images/ajax-loader-top-page.gif' />");
		    },
	        success: function(Response) {
				if(Response.error_code==0){
					html = '<span class="s_label s_1" id="'+id+'">Đã duyệt</span>';
				}else{
					html = '<span class="s_label s_2" id="'+id+'">Fail</span>';
				}
				cid.splice(0, 1);
	        	$("#r_"+id).html(html);
	        	if(cid.length>0){
	        		ApproveAll(cid);
	        	}
	        }
	    });
	}
})
</script>