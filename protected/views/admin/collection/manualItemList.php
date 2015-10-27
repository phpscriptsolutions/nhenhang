<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js");
$this->menu = array(
    array('label' => Yii::t('admin', 'Danh sách'), 'url' => array('index')),
    array('label' => Yii::t('admin', 'Thêm mới'), 'url' => array('create')),
    array('label' => Yii::t('admin', 'Cập nhật'), 'url' => array('update', 'id' => $mainmodel->id)),
    array('label' => Yii::t('admin', 'Xóa'), 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $mainmodel->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Thêm mới item', 'url' => "#", 'visible' => true, 'linkOptions' => array('onclick' => 'addItem()')),
);

Yii::app()->clientScript->registerScript('mainscript', "
window.reorder = function()
{
	$('.grid-view').addClass('grid-view-loading');
   $.post('" . $this->createUrl('collection/reorder', array('id'=>$_GET['id'])) . "',$('.adminform').serialize(), function(data){
        alert('Cập nhật thành công');
   		location.reload(true);
   });
}
window.saveCustomCol = function()
{
   $.post('" . $this->createUrl('collection/customCol') . "',$('.adminform').serialize(), function(data){
        alert('Cập nhật thành công')
   });
}


window.addItem = function(){
	jQuery.ajax({
	  'onclick':'$(\"#jobDialog\").dialog(\"open\"); return false;',
	  'url':'" . $this->createUrl("$addItemLink") . "',
	  'type':'GET',
      'data': { object: 'collection', collect_id : '$collect_id'  },
	  'cache':false,
	  'success':function(html){
	      jQuery('#jobDialog').html(html)
	      }
	});
    return;
}

");
?>

<div class="search-form" style="display:block">
	<div class="wide form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route,array("id"=>$mainmodel->id)),
		'method'=>'get',
	));
	?>
	
		<div class="row">
			<?php echo $form->label($model,'Tìm theo tên'); ?>
			<?php echo $form->textField($model,'objName',array('size'=>60,'maxlength'=>255)); ?>
		</div>
		
		<div class="row buttons">
			<?php echo CHtml::submitButton('Search'); ?>
			<?php echo CHtml::link("Reset", Yii::app()->createUrl($this->route,array("id"=>$mainmodel->id))) ?>
		</div>
	<?php $this->endWidget(); ?>
	
	</div>
</div><!-- search-form -->



<?php
$form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
	'method'=>'post',
	'htmlOptions'=>array('class'=>'adminform','style'=>''),
));
$artistName = ($type == "playlist") ? '$data->' . $type . '->username' : '$data->' . $type . '->artist_name';

/**
 * voi bang xep hang: show custom col (gia tri nay se duoc hien thi o trang /bxh)
 */
if(strpos($mainmodel->code, 'BXH') !== false)
        $arr = array(
                    'header' => 'Custom rank' . CHtml::link(CHtml::image(Yii::app()->request->baseUrl . "/css/img/save_icon.png"), "", array("onclick" => "saveCustomCol()")),
                    'value' => 'CHtml::textField("customCol[$data->item_id]", $data->' . $type . '->custom_rank,array("size"=>1))',
                    'type' => 'raw',
                );
echo '<style>
.grid-view input[type="text"] {
    width: 50px;
}    
</style>';
echo '<input type="hidden" name="type" value="'.$mainmodel->type.'">';
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'admin-collection-modell-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'id',
        'item_id',
        array(
            'header' => 'Tên',
            'value' => '$data->' . $type . '->name',
        ),
        array(
            'header' => 'Người tạo',
            'value' => $artistName,
        ),
        array(
            'header' => 'Sắp xếp' . CHtml::link(CHtml::image(Yii::app()->request->baseUrl . "/css/img/save_icon.png"), "", array("onclick" => "reorder()")),
            'value' => 'CHtml::textField("sorder[$data->id]", $data->sorder,array("size"=>1))',
            'type' => 'raw',
        ),
        $arr,
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'Yii::app()->controller->createUrl("collectionItem/delete",array("id"=>$data->id))',
            'header' => CHtml::dropDownList('pageSize', $pageSize, array(10 => 10, 30 => 30, 50 => 50, 100 => 100), array(
                'onchange' => "$.fn.yiiGridView.update('admin-collection-modell-grid',{ data:{pageSize: $(this).val() }})",
            )),
        ),
    ),
));
$this->endWidget();
?>
