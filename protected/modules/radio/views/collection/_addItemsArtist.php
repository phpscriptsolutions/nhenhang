<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('job','Danh sách Ca sỹ'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'650px',
                    'height'=>'auto',
                ),
                ));


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#artistC form').submit(function(){
	$.fn.yiiGridView.update('admin-radio-collection-artist-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="title-box search-box">
    <?php echo CHtml::link('Lọc trên danh sách','#',array('class'=>'search-button')); ?>
</div>

<div class="search-form" id="artistC">

<?php 
/*$this->renderPartial('_searchPopup',array(
	'model'=>$songModel,
));*/ 
?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>
	<div class="row">
		<?php echo $form->label($CollModel,'name'); ?>
		<?php echo $form->textField($CollModel,'name',array('size'=>60,'maxlength'=>160)); ?>
	</div>
    <div class="row">
        <?php echo CHtml::submitButton('Search',array('class'=>'fl','style'=>'margin:0;padding:0;border-radius:0')); ?>
    </div>

<?php $this->endWidget(); ?>
</div>

<?php

$form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->getId().'/bulk'),
    'method'=>'post',
    'htmlOptions'=>array('class'=>'popupform'),
));
$columns = array(

                array(
                    'class'                 =>  'CCheckBoxColumn',
                    'selectableRows'        =>  2,
                    'checkBoxHtmlOptions'   =>  array('name'=>'cid[]'),
                    'headerHtmlOptions'   	=>  array('width'=>'50px','style'=>'text-align:left'),
                    'id'                    =>  'cid',
                    'checked'               =>  'false'
                ),
                'id',
		        'name',
            );

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'admin-radio-collection-artist-grid',
	'dataProvider'=>$CollModel->search(),
	'columns'=> $columns,
));

echo CHtml::hiddenField("channel_id",$channelId);

echo CHtml::ajaxSubmitButton(Yii::t('admin','Chọn'),CHtml::normalizeUrl(array('/radio/collection/addItems','id'=>0)),array('success'=>'js: function(data) {
                        $("#jobDialog").dialog("close");
                        //inlistzone = false;
						//$("#inlist-info").click();
						window.location.reload(true);
                    }'),array('id'=>'closeJobDialog'));
echo CHtml::button(Yii::t('admin','Bỏ qua'),array("onclick"=>'$("#jobDialog").dialog("close");'));


$this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog');

?>
