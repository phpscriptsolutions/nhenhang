<?php include_once '_header.php';?>
<body <?php echo (($controller->id == 'artist' && $action == 'view') || ($controller->id == 'user' && $action == 'detail'))? 'class="artist"' : ''; ?>>
<?php include_once 'ga.php'?>
<?php //include_once '_social_connect.php'?>
<div class="wraper">
    <?php echo $content ?>
<?php include_once '_footer.php';?>

    <?php
    if(Yii::app()->user->hasFlash('error_token')):
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogClassroom',
        'options'=>array(
            'title'=>Yii::t('web','Thông báo'),
            'autoOpen'=>true,
            'modal'=>true,
            'width'=>450,
            'height'=>auto,
            'position' => array(
                'my'=>"top",
                'at'=>'top+10%',
            )
        ),
    ));?>
        <div class="errorMessage" style="width: 80%; margin: 30px auto;">
            <ul>
                <li><?php echo Yii::t('web','Đã hết thời gian thực hiện thao tác này. Vui lòng thực hiện lại. Trân trọng cảm ơn!'); ?></li>
            </ul>
        </div>
    <?php $this->endWidget(); endif;?>

</div>
<div id="page_id" style="display: none;"><?php echo strtolower($controller->id)."_".strtolower($action) ?></div>
<div id="user_id" style="display: none;"><?php echo $userId ?></div>
<div id="overlay" style="display: none;"></div>
<div id="box_load" style="display: none;"><img src="/web/images/stop.png" /></div>
<?php echo CHtml::hiddenField('page_url',urlencode(Yii::app()->createAbsoluteUrl(Yii::app()->request->url)))?>
</body>
</html>
