<?php
if($type == 0)
    $title = "Danh sách tác quyền";
else
    $title = "Danh sách quyền liên quan";
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'jobDialog',
    'options' => array(
        'title' => Yii::t('admin', $title),
        'autoOpen' => true,
        'modal' => 'true',
        'width' => '450px',
        'height' => 'auto',
        'buttons' => array(
            'Close' => 'js:function(){$(this).dialog("close")}',
            'Chọn' => 'js:function(){
                addcopy("'.$type.'");
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
$('#copyright-form form').submit(function(){
    $.fn.yiiGridView.update('admin-copyright-model-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<div class="wide form search-form" id="copyright-form" style="margin-bottom:0;padding:5px 10px ">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => '/admin.php?r=song/copyright',
        'method' => 'get',
            ));
    ?>

    <div class="row">
        <?php echo $form->textField($model, 'appendix_no', array('size' => 25, 'maxlength' => 160, 'class' => 'fl', 'style' => 'padding:1px 0; margin:0')); ?>
        <?php echo CHtml::submitButton('Search', array('class' => 'fl', 'style' => 'margin:0;padding:0;border-radius:0')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->getId() . '/bulk'),
    'method' => 'post',
    'htmlOptions' => array('class' => 'popupform'),
        ));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'admin-copyright-model-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'selectableRows' => 2,
            'checkBoxHtmlOptions' => array('name' => 'cid[]'),
            'headerHtmlOptions' => array('width' => '50px', 'style' => 'text-align:left'),
            'id' => 'cid',
            'checked' => 'false'
        ),
        array(
            'header' => 'Name',
            'value' => '$data->contract_no ." -> ". $data->appendix_no',
        ),
    ),
    'htmlOptions' => array('style' => 'padding:0'),
    'pager' => array('class' => 'CLinkPager', 'maxButtonCount' => 3),
));

$this->endWidget();
?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>