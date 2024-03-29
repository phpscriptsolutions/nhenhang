<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
$this->breadcrumbs=array(
	'Import Song Models'=>array('index'),
	'Manage',
);

$this->menu=array(	
	array('label'=> Yii::t("admin","Thêm mới"), 'url'=>array('create'), 'visible'=>UserAccess::checkAccess('ImportSongModelCreate')),
);
$this->pageLabel = Yii::t("admin","Danh sách ImportSong");


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('import-song-model-grid', {
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
<button onclick="js:scaning(<?php echo $_GET['fileId'];?>);" id="startbtn">Scan & Check</button>
<div id="scaning-run" style="display: none"><span class="loading-import"><img src="<?php echo Yii::app()->theme->baseUrl ?>/images/ajax-loader-top-page.gif"></span></div>
<div id="result"></div>
<script>
function scaning(fileId)
{
	$("#scaning-run").show();
	$("#startbtn").attr("disabled","disabled");
				jQuery.ajax({
					'url': '<?php echo Yii::app()->createUrl('/tools/importSong/CheckSong')?>',
					'type':'POST',
					'data': {fileId:fileId},
					'dataType':'json',
					'success': function(data){
							$("#result").html(data.data);
							if(data.completed == 1)
					        {
					            $('#scaning-run').hide();
					            $("#result").html('<div>Scan Song Completed!</div>');
					            $("#startbtn").removeAttr("disabled");
					            $.fn.yiiGridView.update('import-song-model-grid',{ data:{pageSize: 30 }})
					        }else{
					        	scaning(fileId);
						    }
						}
			    })
}
</script>
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
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>$padding),
));
echo '<div class="op-box">';
echo Yii::t("admin"," Tổng số được chọn").": <span id='total-selected'>0</span>";

echo '<div style="display:none">'.CHtml::checkBox ("all-item",false,array("value"=>$model->count(),"style"=>"width:30px")).'</div>';
echo '</div>';
echo $html_exp;

if(Yii::app()->user->hasFlash('ImportSong')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('ImportSong').'</div>';
}

$this->widget('application.widgets.admin.grid.CGridView', array(
	'id'=>'import-song-model-grid',
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

		'stt',
		'name',
		'artist',
		/*
		'category',
		'sub_category',
		'composer',
		'artist',
		'album',
		'path',
		'file',
		'import_datetime',
		'file_name',
		*/
		array(
			'header'=>'Song In System',
			'type'=>'raw',
			'value'=>'$data->new_song_id>0?Chtml::link("$data->new_song_id",array("/song/update&id=$data->new_song_id"), array("target"=>"_blank")):0'
		),
		array(
			'header'=>'Status',
			'value'=>'$data->status<=0?"<span class=\"s_label s_0\">Chưa Scan</span>":($data->status==1?"<span class=\"s_label s_1\">Đã tồn tại</span>":"<span class=\"s_label s_2\">Không tồn tại</span>")',
			'type'=>'raw'
		),
		array(
			'class'=>'CButtonColumn',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('import-song-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),


		),
	),
));
$this->endWidget();

?>
