<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'jobDialog',
    'options' => array(
        'title' => Yii::t('admin', 'Bài hát đã tồn tại'),
        'autoOpen' => true,
        'modal' => 'true',
        'width' => '500px',
    ),
));
?>

<div class="form" id="jobDialogForm">
    <p style="margin: 15px 0px 10px 0px; text-align: center;">Bài hát này đã được <?php echo $cp_name; ?> đưa lên hệ thống, chi tiết xem <a href="/admin.php?r=song/update&id=<?php echo $song['id']?>" target="_blank" style="text-decoration: underline;">tại đây</a>.</p>
</div>
 <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

