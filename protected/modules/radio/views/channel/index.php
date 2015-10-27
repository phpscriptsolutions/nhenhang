<style>
.s_0, .s_1{
	cursor: pointer;
}
</style>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js");
?>
<div class="submenu title-box xfixed">
                    <div class="portlet" id="yw2">
<div class="portlet-content">
<div class="page-title">Danh sách kênh</div>
<ul class="operations menu-toolbar" id="yw3">
<li><a href="<?php echo Yii::app()->createUrl('/radio/channel/create')?>">Tạo mới kênh</a></li>
</ul>
</div>
</div>
</div>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('admin-radio-model-grid', {
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

if(Yii::app()->user->hasFlash('Radio')){
    echo '<div class="flash-success">'.Yii::app()->user->getFlash('Radio').'</div>';
}
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-radio-model-grid',
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
			'header'=>'Thumb',
			'value'=>'CHtml::image(Common::getLinkIconsRadio($data->id, "channel"), "thumb",array("width"=>50))',
			'type'=>'raw'		
		),
		array(
				'header'=>'Channel Name',
				'value'=>'$data->name'
		),
		array(
			'header'=>'Parent Channel',
			'value'=>'$data->parent_id>0?AdminRadioModel::model()->findByPk($data->parent_id)->name:"root"',
			'type'=>'raw'		
		),
		'type',
		array(
				'header'=>'Time Point',
				'type'=>'raw',
				'value'=>'str_replace(array(1,2,3), array("Sáng","Chiều","Tối"), $data->time_point)'
		),
		array(
				'header'=>'Day Of Week',
				'type'=>'raw',
				'value'=>'str_replace(array(1,2,3,4,5,6,7), array("Hai","Ba","Tư","Năm","Sáu","Bảy","Chủ nhật"), $data->day_week)'
		),
		'ordering',
		array(
			'header'=>'Status',
			//'value'=>'($data->status==1)?"<span style=\"color:#37DF66\">Actived</span>":"<span style=\"color:#E0147E\">Not Actived</div>"',
			'value'=>'"<div id=\"r_$data->id\">".CHtml::tag("span", array("class"=>"s_label s_$data->status","id"=>$data->id), str_replace(array(0,1),array("Not Actived","Actived"), $data->status))."</div>"',
			'type'=>'raw'				
		),
		'id',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{collection} {update} {delete}',
			'htmlOptions'=>array('width'=>60, 'align'=>'center'),
			'buttons'=>array(
				'collection'=>array(
					'label'=>'Danh sách Collection',
					'imageUrl'=>Yii::app()->theme->baseUrl.'/images/bullet_star.png',
					'url'=>'Yii::app()->createUrl("/radio/collection", array("id"=>$data->id))'	
				),
				'delete'=>array(
						'options' => array(
							'confirm' => 'Bạn chắc chắn muốn xóa kênh này',
							'ajax' => array(
								'type' => 'POST',
								'url' => "js:$(this).attr('href')", // ajax post will use 'url' specified above
								'success' => 'function(data){
	                                if(data == ""){
	                                              //update the grid...
	                                                $.fn.yiiGridView.update("admin-radio-model-grid");
	                                                return false;
	                                }else{
										alert(data)
	                                	return false;
	                                }
	                            }',
							),
						),
				),
			),
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,30=>30,50=>50,100=>100),array(
                                                                                  'onchange'=>"$.fn.yiiGridView.update('admin-radio-model-grid',{ data:{pageSize: $(this).val() }})",
                                                                                )),


		),
	),
));
$this->endWidget();

?>
<script>
$(function(){
	$(".s_0, .s_1").live("click", function(){
		var id = $(this).attr("id");
		var url = "?r=radio/channel/active&id="+id;
		$.ajax({
	        url: url,
	        type: "POST",
	        data: {t:1},
	        success: function(Response) {
	        	$.fn.yiiGridView.update('admin-radio-model-grid');
	        }
	    });
	})
})
</script>