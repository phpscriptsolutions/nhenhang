<?php

$this->menu=array(
	array('label'=>'Danh sách File', 'url'=>array('index')),
);
$this->pageLabel = "Danh sách file \"".$model->file_name."\"";
$content_type = 'bài hát';
if($model->content_type == 'video') $content_type = 'video';
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'file_name',
		'file_path',
                'content_type',
		'created_by',
		'created_time',
	),
)); ?>
<div class="submenu  title-box">
	<div class="page-title">Danh sách <?php echo $content_type;?></div>
	<ul class="operations menu-toolbar">
            <li><a href="#" id="update-content">Nhập bản quyền</a></li>
            <li><a href="#" id="delete-content">Xóa</a></li>
            <!-- <li><a href="#" id="map-content">Map nội dung</a></li> -->
            <li><a href="#" id="export-xls-not-mapped" title="Export danh sách bài không map được">Export xls</a></li>
	</ul>
</div>
<div id="mapping-zone" style="height: 250px;overflow-y:auto; width: 90%;border: 1px solid #DDD; margin: 10px auto;display: none;">
</div>
<?php
$form = $this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl("/copyright_content/default/massUpdate"),
		'method' => 'post',
		'htmlOptions' => array('class' => 'adminform','id'=>'cpr_form'),
));
echo CHtml::hiddenField("fileId",$model->id);
echo CHtml::hiddenField("page",isset($_GET["page"])?$_GET["page"]:1);


$this->widget('application.widgets.admin.grid.GGridView', array(
	'id'=>'copyright-song-file-model-grid',
	'treeData'=>$songs,
	'enablePagination' => false,
	'columns'=>array(

			array(
					'class' => 'CCheckBoxColumn',
					'selectableRows' => 2,
					'checkBoxHtmlOptions' => array('name' => 'cid[]','class'=>'clb'),
					'headerHtmlOptions' => array('width' => '50px', 'style' => 'text-align:left'),
					'id' => 'cid',
					'checked' => 'false',
					'value'=>'$data["map_id"]'
			),

		/* array(
				'name' => '  ',
				'value' =>'CHtml::checkBox("cid[]",false,array("value"=>$data["map_id"],"id"=>"cid_".$data["map_id"]))',
				'type' => 'raw',
		), */


		array(
				'name' => 'ID '.$content_type,
				'value' => '$data["content_id"]',
				'type' => 'raw',
		),
		array(
				'name' => 'Tên '.$content_type,
				'value' => '$data["name"]',
				'type' => 'raw',
				'htmlOptions'=>array("style"=>"width:270px")
		),
		array(
				'name' => 'Số hd',
				'value' => '$data["copyright_code"]',
				'type' => 'raw',
		),
		array(
				'name' => 'Mã hd',
				'value' => '$data["copyright_id"]',
				'type' => 'raw',
		),
		array(
				'name' => 'Nội dung',
				'value' => '$data["content_type"]',
				'type' => 'raw',
		),
		array(
				'name' => 'Trạng thái',
				'value' => '$data["status"]>=1?$data["status"]==1?"<span class=\"s_label s_{$data["status"]}\">Thành công</span>":"<span class=\"s_label s_{$data["status"]}\">Lỗi</span>":"<span class=\"s_label s_{$data["status"]}\">Chưa nhập</span>"',
				'type' => 'raw',
		),

		array(
			'class'=>'CButtonColumn',
			'header'=> Yii::t('admin','Xóa'),
			'template'=>'{delete}',
			'deleteButtonUrl'=>'Yii::app()->controller->createUrl("delete",array("id"=>$data["id"],"fileId"=>$data["input_file"]))'
		),
	),
));
$this->endWidget();

echo '<div class="pager p10">';
$this->widget ( "CLinkPager", array (
		"pages" => $page,
		"maxButtonCount" => 10,
		"header" => "",
		"htmlOptions" => array ()
) );
echo '</div>';
?>

<script type="text/javascript">
//<!--
	var i=0;
	var mapSong = function(fileId)
	{
		jQuery.ajax({
			'url': '<?php echo Yii::app()->createUrl('/copyright_content/default/ajaxMap')?>',
			'type':'POST',
			'data': {fileId:fileId,offset:i},
			'dataType':'json',
			'success': function(data){
					var result = '<div class="res-row">'+data.errorMessage+'</div>';
					$("#mapping-zone").prepend(result);
					if(data.success == 1)
			        {
			            $("#mapping-zone").prepend("<div style='font-weight: bold;'>Map Song Completed!</div>");
			        }else{
			        	mapSong(fileId);
				    }
				}
	    })
		i++;
	}

	$("#map-content").live("click",function(){
		$("#mapping-zone").animate({
			 "height": "toggle","opacity": "toggle"
			}, { duration: 600 }); // can change 600 to  "slow"

		mapSong('<?php echo $model->id; ?>');
		return false;
	})

	$("#delete-content").live("click",function(){

		if($("#cpr_form input:checked").length==0){
			alert("Chưa chọn bản ghi nào")
			return false;
		}
		var r = confirm("Bạn chắc chắn muốn xóa?");
		if(!r){
			return false;
		}

		$("#cpr_form").attr("action","<?php echo Yii::app()->createUrl("/copyright_content/default/deleteItems")?>")
		$("#cpr_form").submit();
		return false;
	})

	$("#update-content").live("click",function(){

		/* if($("input.clb:checked").length==0){
			alert("Chưa chọn bản ghi nào")
			return false;
		} */
		$("#cpr_form").attr("action","<?php echo Yii::app()->createUrl("/copyright_content/default/massUpdate")?>")
		$("#cpr_form").submit();
		return false;
	})
        
        $("#export-xls-not-mapped").live("click",function(){
            $("#cpr_form").attr("action","<?php echo Yii::app()->createUrl("/copyright_content/default/exportXlsNotMapped")?>")
            $("#cpr_form").submit();
            return false;
	})
//-->
</script>
