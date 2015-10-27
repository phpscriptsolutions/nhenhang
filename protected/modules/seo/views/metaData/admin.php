<div class="content-body">
    <div class="form">

        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'find-content',
            'enableAjaxValidation'=>false,
            'action' => $this->createUrl('/seo/metaData/admin'),
            'method'=>'get',
        )); ?>
        <div class="row">
            <label>Content Type:</label>
            <?php
            $data = array('album'=>'Album','song'=>'Song','video'=>'Video','genre'=>'Genre','artist'=>'Artist','collection'=>'Rank');
            echo CHtml::dropDownList('Find[content_type]',$contentType, $data, array('prompt'=>'--None--'));
            ?>
        </div>
        <div class="row">
            <label>Real ID or Encrypt ID:</label>
            <?php
                echo CHtml::textField('Find[content_id]',$contentId);
            ?>
        </div>
        <div class="row buttons">
            <?php echo CHtml::button('Find', array('onclick'=>'return findContent();')); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
    <div id="content_meta"></div>
</div>
<script>
function findContent(){
    $.ajax({
        url: '<?php echo Yii::app()->createUrl('/seo/metaData/findContentMeta');?>',
        data: {data:$('#find-content').serialize()},
        type: "post",
        beforeSend: function()
        {
            $('#content_meta').html('<img src="/themes/admin-new/images/ajax-loader-top-page.gif" />');
        },
        success: function(response){
            $('#content_meta').html(response);
        }
    })
}
</script>