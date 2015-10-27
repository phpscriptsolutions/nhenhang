<?php
$cs=Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");

$this->menu=array(
	array('label'=>'Thêm video', 'url'=>"#", 'visible'=>UserAccess::checkAccess('VideoPlaylistCreate'),'linkOptions'=>array('onclick'=>'popupvideo()')),
	array('label'=>'Quay lại trang view video playlist', 'url'=>array('view', 'id'=>$model->id)),
);
Yii::app()->clientScript->registerScript('video-playlist-video-list', "
window.reorder = function()
{
   $.post('".$this->createUrl('videoPlaylist/reorder')."',$('.adminform').serialize(), function(data){
        alert('Cập nhật thành công')
   });
}

window.popupvideo = function(){
	jQuery.ajax({
	  'onclick':'$(\"#jobDialog\").dialog(\"open\"); return false;',
	  'url':'". $this->createUrl("videoPlaylist/addItems",array('video_playlist_id'=>$model->id))."',
	  'type':'GET',
	  'cache':false,
	  'beforeSend':function(){
	  		overlayShow();
	  },
	  'success':function(html){
	      jQuery('#jobDialog').html(html);
		  overlayHide();
      }
	});
    return;
}

");

$this->pageLabel = yii::t("admin", "Danh sách video trong video_playlist:  {videoPlaylist}", array('{videoPlaylist}'=>$model->name)) ;
?>

<div class="" >
	<div class="wide form">

	</div>
</div>

<?php
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform'),
));
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-video-playlist-model-grid',
	'dataProvider'=>$videoList->search(),
	'columns'=>array(
            /*array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),*/

		'id',
		'video_id',

        array(
        	'header'=>'Video',
            'name' => 'video.name',
		),
		array(
	    		'header'=>Yii::t('admin','Sắp xếp') .CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/css/img/save_icon.png"),$this->createUrl('videoPlaylist/reorderItems',array('id'=>$id)),array("id"=>"reorder") ),
	            'value'=> 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1,"class"=>"ordering"))',
	            'type' => 'raw',
			),
		array(
	            'class'=>'CLinkColumn',
	            'header'=> Yii::t('admin','Hiển thị'),
	            'labelExpression'=>'($data->status==1)?CHtml::image(Yii::app()->request->baseUrl."/css/img/publish.png"):CHtml::image(Yii::app()->request->baseUrl."/css/img/unpublish.png")',
	            'urlExpression'=>'($data->status==1)?Yii::app()->createUrl("videoPlaylist/unpublishItems",array("cid[]"=>$data->id)):Yii::app()->createUrl("videoPlaylist/publishItems",array("cid[]"=>$data->id))',
	            'linkHtmlOptions'=>array(),
			),
		array(
			'class'=>'CButtonColumn',
			'header'=> Yii::t('admin','Xóa'),
			'template'=>'{delete2}',
			//'deleteButtonUrl'=>'Yii::app()->controller->createUrl("deleteItems",array("cid[]"=>$data->id))'
                        'buttons'=>array(
                                    'delete2' => array(
                                        'imageUrl'=>Yii::app()->request->baseUrl.'/css/img/delete.png',                          
                                        'url' => 'Yii::app()->controller->createUrl("deleteItems",array("cid[]"=>$data->id))',
                                        'options'=>array('confirm'=>'Bạn có chắc chắn muốn xóa?'),
                                    ),
                            ),

		),
	),
));
Yii::app()->user->setState('pageSize',30);
?>
<?php
$this->endWidget();
?>