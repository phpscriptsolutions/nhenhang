<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Admin Feature Video Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>"#", 'visible'=>UserAccess::checkAccess('VideoFeatureCreate'),'linkOptions'=>array('onclick'=>'addVideo()')),
);
$this->pageLabel = yii::t('admin', 'Danh sách video chọn lọc');


Yii::app()->clientScript->registerScript('search', "
window.reorder = function()
{
   $.post('".$this->createUrl('videoFeature/reorder')."',$('.adminform').serialize(), function(data){
        alert('Cập nhật thành công')
   });
}
window.addVideo = function(){
	jQuery.ajax({
	  'onclick':'$(\"#jobDialog\").dialog(\"open\"); return false;',
	  'url':'". $this->createUrl("videoFeature/addVideo")."',
	  'type':'GET',
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
                        array(''=>Yii::t("admin","Hành động"),'deleteAll'=>'Delete','unpublish'=>'Ẩn','publish'=>'Hiện'),
                        array('onchange'=>'return submitform(this)')
                );
echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

echo '<div style="display:none">'.CHtml::checkBox ("all-item",false,array("value"=>$model->count(),"style"=>"width:30px")).'</div>';
if(Yii::app()->user->hasFlash('FeatureVideo')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('FeatureVideo').'</div>';
}
echo '</div>';
echo $html_exp;



?>
<script>
    var idf = 'admin-feature-video-model-grid';
    var modelf = 'AdminFeatureVideoModel_page';
</script>
<?php
$this->widget('application.widgets.admin.grid.CGridView', array(
	'id'=>'admin-feature-video-model-grid',
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
		'video_id',
        array(
        	'header'=>'Video',
        	'name' => 'video.name',
        	),
        array(
        	'header'=>'Artist',
        	'name' => 'video.artist_name',
        	),
        array(
	              'header'=>'Sắp xếp'.CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),"",array("onclick"=>"reorder()") ),
	              'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
	              'type' => 'raw',
        		  'htmlOptions'=>array('align'=>'center')
              ),
        array(
            'class'=>'CLinkColumn',
            'header'=>'Hiển thị',
            'labelExpression'=>'($data->status==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression'=>'($data->status==1)?Yii::app()->createUrl("videoFeature/unpublish",array("cid[]"=>$data->id)):Yii::app()->createUrl("videoFeature/publish",array("cid[]"=>$data->id))',
            'linkHtmlOptions'=>array(),
        	'htmlOptions'=>array('align'=>'center')
            
        ),
             array(
            'class'=>'CLinkColumn',
            'header'=>'Hot',
            'labelExpression'=>'($data->featured==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression'=>'($data->featured==1)?Yii::app()->createUrl("videoFeature/unhot",array("cid[]"=>$data->id)):Yii::app()->createUrl("videoFeature/hot",array("cid[]"=>$data->id))',
            'linkHtmlOptions'=>array(
                                ),
            
        ),    
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-feature-video-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),


		),
	),
));
$this->endWidget();

?>
