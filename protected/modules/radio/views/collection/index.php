<?php
/* $cs=Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
 */

/* Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('radio-collection-model-grid', {
		data: $(this).serialize()
	});
	return false;
});

"); */
?>
<div class="submenu title-box xfixed">
<div class="portlet" id="yw2">
	<div class="portlet-content">
	<div class="page-title">Danh sách Radio Conllection # <?php echo $model->channel->name;?></div>
	<ul class="operations menu-toolbar" id="yw3">
	<li><a href="<?php echo Yii::app()->createUrl('/radio/channel')?>">Danh sách kênh</a></li>
	<li><a href="#" onclick="PopupRadioCollection()">Thêm Collection</a></li>
	</ul>
	</div>
</div>
</div>
<?php 
Yii::app()->clientScript->registerScript('radio-collection-list', "
window.reorder = function()
{
   $.post('".Yii::app()->createUrl('/radio/collection/reorder', array('channel_id'=>$channelId))."',$('.adminform').serialize(), function(data){
        alert('Cập nhật thành công');
		location.reload();
   });
}

window.PopupRadioCollection = function(){
	jQuery.ajax({
	  'onclick':'$(\"#jobDialog\").dialog(\"open\"); return false;',
	  'url':'". Yii::app()->createUrl("/radio/collection/addItems",array('channel_id'=>$channelId))."',
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

if(Yii::app()->user->hasFlash('RadioCollection')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('RadioCollection').'</div>';
}

if($type=='artist'){
	$collection_column = array(
		'name'=>'collection_id',
		'value'=>'$data->artist->name'
	);
}elseif($type=='genre'){
	$collection_column = array(
		'name'=>'collection_id',
		'value'=>'$data->genre->name'
	);
}elseif($type=='playlist'){
	$collection_column = array(
		'name'=>'collection_id',
		'value'=>'$data->playlist->name'
	);
}elseif($type=='album'){
	$collection_column = array(
		'name'=>'collection_id',
		'value'=>'$data->album->name'
	);
}else{
	$collection_column = array(
		'name'=>'collection_id',
		'value'=>'$data->collection->name."(".$data->collection->code.")"'
	);
}
$type_column = array(
			'header'=>'Type',
			'value'=>'"'.$type.'"',
			'type'=>'raw'
		);
switch ($type)
{
	case 'playlist':
		$icon_column = array(
				'header'=>'Edit Icon',
				'value'=>'CHtml::link("Edit",Yii::app()->createUrl("playlist/update", array("id"=>$data->collection_id)), array("target"=>"_blank"))',
				'type'=>'raw'
		);
		break;
	case 'album':
		$icon_column = array(
				'header'=>'Edit Icon',
				'value'=>'CHtml::link("Edit",Yii::app()->createUrl("album/update", array("id"=>$data->collection_id)), array("target"=>"_blank"))',
				'type'=>'raw'
		);
		break;
	case 'genre':
		$icon_column = array(
				'header'=>'Edit Icon',
				'value'=>'CHtml::link("Edit",Yii::app()->createUrl("genre/update", array("id"=>$data->collection_id)), array("target"=>"_blank"))',
				'type'=>'raw'
		);
		break;
	case 'artist':
		$icon_column = array(
				'header'=>'Edit Icon',
				'value'=>'CHtml::link("Edit",Yii::app()->createUrl("artist/update", array("id"=>$data->collection_id)), array("target"=>"_blank"))',
				'type'=>'raw'
		);
		break;
		default:
			$icon_column = array(
				'header'=>'Edit Icon',
				'value'=>'CHtml::link("Edit",Yii::app()->createUrl("collection/update", array("id"=>$data->collection_id)), array("target"=>"_blank"))',
				'type'=>'raw'
			);
			break;
}

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'radio-collection-model-grid',
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
			'name'=>'radio_id',
			'value'=>'$data->channel->name'
		),
		$collection_column,
		$type_column,
		array(
				'header' => 'Ordering ' . CHtml::link(CHtml::image(Yii::app()->request->baseUrl . "/css/img/save_icon.png"), "", array("onclick" => "reorder()")),
				'value' => 'CHtml::textField("sorder[$data->id]", $data->ordering,array("size"=>1))',
				'type' => 'raw',
		),
		'id',
		$icon_column,
		array(
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('radio-collection-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),

		),
	),
));
$this->endWidget();

?>
