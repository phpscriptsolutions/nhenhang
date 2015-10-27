<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");

$this->menu=array(	
	array('label'=>Yii::t('admin','Thêm mới'), 'url'=>"#", 'visible'=>UserAccess::checkAccess('AlbumFeatureAddAlbum'),'linkOptions'=>array('onclick'=>'addAlbum()')),
);
$this->pageLabel = Yii::t('admin','Danh sách album - chọn lọc'); 

Yii::app()->clientScript->registerScript('album-feature', "
window.reorder = function()
{
   $.post('".$this->createUrl('albumFeature/reorder')."',$('.adminform').serialize(), function(data){
        alert('Cập nhật thành công')
   });
}
window.addAlbum = function(){
	jQuery.ajax({
	  'onclick':'$(\"#jobDialog\").dialog(\"open\"); return false;',
	  'url':'". $this->createUrl("albumFeature/addAlbum")."',
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
                        array(''=>Yii::t("admin","Hành động"),'deleteAll'=>'Delete','unpublish'=>Yii::t('admin','Ẩn'),'publish'=>Yii::t('admin','Hiện')),
                        array('onchange'=>'return submitform(this)')
                );
echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

echo '<div style="display:none">'.CHtml::checkBox ("all-item",false,array("value"=>$model->count(),"style"=>"width:30px")).'</div>';
if(Yii::app()->user->hasFlash('FeatureAlbum')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('FeatureAlbum').'</div>';
}
echo '</div>';
echo $html_exp;




$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-feature-album-model-grid',
	'dataProvider'=>$model->search(),	
	'columns'=>array(
            array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
            		'headerHtmlOptions'     =>  array('width'=>'50px','style'=>'text-align:left;height:30px;padding-top:10px'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),

		'id',
         array(
                'header'=>'Album',
                'name' => 'album.name',
        	),
        array(
	    		'header'=>'Sắp xếp'.CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),"",array("onclick"=>"reorder()") ),
	            'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
	            'type' => 'raw',
        		'sortable'=>false,
			),
		array(
	            'class'=>'CLinkColumn',
	            'header'=>'Hiển thị',
	            'labelExpression'=>'($data->status==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
	            'urlExpression'=>'($data->status==1)?Yii::app()->createUrl("albumFeature/unpublish",array("cid[]"=>$data->id)):Yii::app()->createUrl("albumFeature/publish",array("cid[]"=>$data->id))',
	            'linkHtmlOptions'=>array(),
			),
             array(
            'class'=>'CLinkColumn',
            'header'=>'Hot',
            'labelExpression'=>'($data->featured==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
            'urlExpression'=>'($data->featured==1)?Yii::app()->createUrl("albumFeature/unhot",array("cid[]"=>$data->id)):Yii::app()->createUrl("albumFeature/hot",array("cid[]"=>$data->id))',
            'linkHtmlOptions'=>array(
                                ),
            
        ),    
                
            
		array(
				'header'=>'Ngày tạo',
				'name'=>'created_time',
				'value'=>'date("d-m-Y", strtotime($data->created_time))',
			),
		array(
				'class'=>'CButtonColumn',
				'header'=>'Xóa',
				'template'=>'{delete}',
			),
	),
));
$this->endWidget();

?>
