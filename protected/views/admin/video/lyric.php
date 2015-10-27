<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'jobDialog',
    'options' => array(
        'title' => Yii::t('admin', 'Cập nhật lời bài hát'),
        'autoOpen' => true,
        'modal' => 'true',
        'width' => '605px',
    ),
));
?>

<script type="text/javascript">
$("#closeJobDialog").click(function() {
  $('#description').elrte('updateSource');
});
</script>
<div class="form" id="jobDialogForm">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'job-form',
        'enableAjaxValidation' => true,
            ));
    ?>
    <div class="row" style="">
        <?php echo CHtml::hiddenField("popup", "1") ?>
        <?php echo CHtml::hiddenField("id", $id) ?>
        <?php echo CHtml::hiddenField("page", '1') ?>
        <?php
        $this->widget('ext.elrtef.elRTE', array(
                'model' => $model,
                'attribute' => 'description',
                'name' => 'description',
                'htmlOptions' => array('height' => '50'),
                'options' => array(
                    'doctype' => 'js:\'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\'',
                    'cssClass' => 'el-rte',
                    'cssfiles' => array('css/elrte-inner.css'),
                    'absoluteURLs' => true,
                    'allowSource' => true,
                    'lang' => 'vi',
                    'styleWithCss' => '',
                    'height' => 200,
                    'fmAllow' => true, //if you want to use Media-manager
                    'fmOpen' => 'js:function(callback) {$("<div id=\"elfinder\" />").elfinder(%elfopts%);}', //here used placeholder for settings
                    'toolbar' => 'compact',
                ),
                'elfoptions' => array(//elfinder options
                    'url' => 'auto', //if set auto - script tries to connect with native connector
                    'passkey' => 'mypass', //here passkey from first connector`s line
                    'lang' => 'ru',
                    'dialog' => array('width' => '300', 'modal' => true, 'title' => 'Media Manager'),
                    'closeOnEditorCallback' => true,
                    'editorCallback' => 'js:callback'
                ),
                    ));
        
        ?>
        <div id="editor"></div>
        <div style="float: right;">
        <?php
//        window.location.reload();
        echo CHtml::ajaxSubmitButton(Yii::t('admin', 'Lưu lại'), 
                    CHtml::normalizeUrl(array('video/lyric')), array(
                        'dataType'=>"json",
                        'beforeSend'=>'js: function(){
                            $("#loading").css({
                                "z-index":"999",
                                "width":"100%",
                                "height":"100%",
                                "position":"fixed",
                                "display":"block"
                            });
                        }',
                        'complete'=>'js: function(){
                            $("#loading").css({
                                "z-index":"0",
                                "width":"0px",
                                "height":"0px",
                                "display":"none"
                            });
                        }',
                        'success' => 'js: function(data) {
                        if(data.flag == 1){
                            $("#"+data.id).attr("src","/css/img/lyric_new.png");
                        }
                        else{
                            $("#"+data.id).attr("src","/css/img/lyric.png");
                            }
                        $("#jobDialog").dialog("close");
                    }'), array('id' => 'closeJobDialog'));
            echo '  ';echo CHtml::button(Yii::t('admin', 'Bỏ qua'), array("onclick" => '$("#jobDialog").dialog("close");//window.location.href=$("li.selected a").attr("href")'));
        ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

 <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

