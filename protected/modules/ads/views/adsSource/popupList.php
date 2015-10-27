<?php
//$id_dialog = "find_artist";
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>$id_dialog,
                'options'=>array(
                    'title'=>Yii::t('admin','Danh sách mã quảng cáo'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'450px',
                    'height'=>'auto',
                	'buttons' => array(
                				'Close'=>'js:function(){$(this).dialog("close")}',
                				'Chọn'=>'js:function(){
                					total = $("input[name=\"cid\[\]\"]:checked").length;
                					if(total == 0){
                						alert("Cần chọn ít nhất 1 nghệ sỹ");
                						return false;
									}

			                    	var data = getCheckbox("#'.$id_dialog.' .popupform",artistList);
			                    	display_artist(data,"'.$id_field.'");
			                    	$(this).dialog("close");
			                    }'

                	),

                ),
                ));


Yii::app()->clientScript->registerScript('search2 ', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('#artist-form form').submit(function(){
    $.fn.yiiGridView.update('admin-artist-model-grid', {
        data: $(this).serialize()
    });
    return false;
});
$(\"#$id_dialog .popupform input[name='cid\[\]']\").live('click', function() {
	var artist_id = this.value;
	var artist_name = $(\"#\"+artist_id).text();
	//alert(artist_id+':'+artist_name)
	putItem(artist_id,artist_name);
	$(\"#$id_dialog\").dialog(\"close\");
});
");

?>

<div><a target="_blank" href="<?php echo Yii::app()->createUrl('ads/adsSource/create')?>">Tạo mã quảng cáo mới</a></div>
<div class="wide form search-form" id="artist-form" style="margin-bottom:0;padding:5px 10px ">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',	
)); ?>

    <div class="row">
        <?php echo $form->textField($model,'name',array('size'=>25,'maxlength'=>160,'class'=>'fl','style'=>'padding:1px 0; margin:0', 'onkeyup'=>'js:suggettk();')); ?>
        <?php echo CHtml::submitButton('Search',array('class'=>'fl','style'=>'margin:0;padding:0;border-radius:0', 'id'=>'timkiem', 'name'=>'timkiem')); ?>
    </div>

<?php $this->endWidget(); ?>
</div>

<?php

$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
    'method'=>'post',
    'htmlOptions'=>array('class'=>'popupform'),
));

$selectableRows = 2;
$multile = Yii::app()->request->getParam('multileSelect',1);
if(!$multile) $selectableRows = 1;

$columns = array(
				array(
						'class'                 =>  'CCheckBoxColumn',
						'selectableRows'        =>  $selectableRows,
						'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
						'headerHtmlOptions'   =>  array('width'=>'50px','style'=>'text-align:left'),
						'id'                    =>  'cid',
						'checked'               =>  'false'
				),
				/* array(
						'class'=>'CLinkColumn',
						'header'=>'Name',
						'labelExpression'=>'$data->name',
						'linkHtmlOptions'=>array('class'=>'artist_name', 'id'=>'$data->name'),
				), */
				array(
						'name'=>'name',
						'value'=>'chtml::link($data->name,Yii::app()->createUrl("video/update",array("id"=>$data->id)), array("id"=>$data->id))',
						'type'=>'raw',
				),
				array(
						'name'=>'id',
						'htmlOptions'=>array('class'=>'idcontent')
				),
            );
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'admin-artist-model-grid',
    'dataProvider'=>$model->search(),
    'columns'=> $columns,
    'htmlOptions'=>array('style'=>'padding:0'),
	'pager'=>array('class'=>'CLinkPager','maxButtonCount'=>3),
));

$this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog');

?>
