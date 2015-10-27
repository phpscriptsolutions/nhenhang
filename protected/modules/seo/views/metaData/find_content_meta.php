<div id="result"></div>
<div class="form">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'content-metadata-form',
        'enableAjaxValidation'=>false,
        'action' => $this->createUrl('/seo/metaData/admin'),
    )); ?>
    <fieldset>
        <legend>SEO Meta Data</legend>
        <div class="row">
            <label>Content Id:</label>
            <?php echo $content->id;?>
        </div>
        <div class="row">
            <label>Content Name:</label>
            <?php echo $content->name;?>
        </div>
        <div class="row">
            <label>Content Encrypt:</label>
            <?php
            Yii::import("application.vendors.Hashids.*");
            $hashids = new Hashids(Yii::app()->params["hash_url"]);
            echo $hashids->encode($content->id);
            ?>
        </div>
        <div class="row">
            <label>[title]:</label>
            <?php echo CHtml::textField("MetaData[title]", isset($metaData['title']) ? $metaData['title'] : "", array('style' => 'width:400px;', 'maxlength' => 100)); ?>
        </div>
        <div class="row">
            <label>[keywords]:</label>
            <?php echo CHtml::textArea("MetaData[keywords]", isset($metaData['keywords']) ? $metaData['keywords'] : "", array('style' => 'width:400px;height: 100px;', 'maxlength' => 500)); ?>
        </div>
        <div class="row">
            <label>[description]:</label>
            <?php echo CHtml::textArea("MetaData[description]", isset($metaData['description']) ? $metaData['description'] : "", array('style' => 'width:400px;height: 100px;', 'maxlength' => 255)); ?>
        </div>
        <?php echo CHtml::hiddenField('MetaData[content_id]',$contentId)?>
        <?php echo CHtml::hiddenField('MetaData[content_type]',$contentType)?>
    </fieldset>
    <div class="row buttons">
        <?php echo CHtml::button('Save', array('onclick'=>'return updateMetaData();')); ?>
        <?php echo CHtml::button('Clear Meta Data', array('onclick'=>'return deleteMetaData();')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    function updateMetaData(){
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('/seo/metaData/admin');?>',
            data: {data:$('#content-metadata-form').serialize()},
            type: "post",
            dataType: 'json',
            beforeSend: function()
            {
                $('#result').html('<img src="/themes/admin-new/images/ajax-loader-top-page.gif" />');
            },
            success: function(response){
                $('#result').html(response.msg);
            }
        })
    }
    function deleteMetaData(){
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('/seo/metaData/deleteMeta');?>',
            data: {data:$('#content-metadata-form').serialize()},
            type: "post",
            dataType: 'json',
            beforeSend: function()
            {
                $('#result').html('<img src="/themes/admin-new/images/ajax-loader-top-page.gif" />');
            },
            success: function(response){
                $('#result').html(response.msg);
                findContent();
            }
        })
    }
</script>