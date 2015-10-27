<?php 
$param = json_decode($model->params);
?>

<?php
Yii::app()->clientScript->registerScript('search', "
    $('#BannerModel_channel').change(function(){
    if($(this).val()=='web' || $(this).val() == 'ringtune'){
        $('#forweb').show();
    }
    else $('#forweb').hide();
});
");
?>

<div class="content-body">
    <div class="form">
        <div class="row">
            <?php echo CHtml::label(Yii::t('admin', 'Banner Image'), "") ?>
            <div class="avatar-display upload-avatar">
                <?php
                if (isset($_POST['BannerModel']['image_upload']) && $_POST['BannerModel']['image_upload'] != 0) {
                    $url = Yii::app()->params['storage']['staticUrl']."/tmp/" . $_POST['BannerModel']['image_upload'];
                } else {
                    $url = Yii::app()->request->baseUrl . "/css/wap/images/banner/" . $model->image_file;
                }
                $image_file = $model->image_file;
                $pos1 = strpos($image_file, "gif");
                $pos2 = strpos($image_file, "jpeg");
                $pos3 = strpos($image_file, "png");

                $is_image = false;
                if (($pos1 === true) || (($pos2 === true)) || ($pos3 === true))
                    $is_image = true;
                echo CHtml::image($url, "Banner", array("id" => "image-display"));
                $this->widget('ext.xupload.XUploadWidget', array(
                    'url' => $this->createUrl("banner/upload", array("parent_id" => 'tmp')),
                    'model' => $uploadModel,
                    'attribute' => 'file',
                    'options' => array(
                        'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
                            if(handler.response.error){
                                alert(handler.response.msg);
                                $("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>' . Yii::t('admin', 'Lỗi upload') . ' :"+handler.response.msg+"</div></td></tr>");
                            }else{
                                $("#image-display").attr("src","' . Yii::app()->params['storage']['staticUrl']."/tmp/" . '"+handler.response.name);
                                $("#BannerModel_image_upload").val(handler.response.name);
                                if(handler.response.type == "application\/x-shockwave-flash")
                                    $("#BannerModel_type").val("flash");
                                else
                                    $("#BannerModel_type").val("image");
                                }
                            }'
                    )
                ));
                ?>
            </div>
        </div>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'banner-model-form',
            'enableAjaxValidation' => false,
                ));
        ?>
        <?php
        $fileTmp = 0;
        if (isset($_POST['BannerModel']['image_upload'])) {
            $fileTmp = $_POST['BannerModel']['image_upload'];
        }
        echo CHtml::hiddenField("BannerModel[image_upload]", $fileTmp);
        ?>	
        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 50)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
            <?php echo CHtml::hiddenField('BannerModel[url]','0')?>
            <?php echo CHtml::hiddenField('BannerModel[start_time]',date("Y-m-d H:i:s"))?>
            <?php echo CHtml::hiddenField('BannerModel[expired_time]',date("Y-m-d H:i:s"))?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php
            $status = array(
                AdminBannerModel::ACTIVE => "Hoạt động",
                AdminBannerModel::INACTIVE => "Không hoạt động",
            );
            echo CHtml::dropDownList("BannerModel[status]", $model->status, $status)
            ?>
            <?php //echo $form->textField($model,'status'); ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>


        <div class="row">
            <?php echo $form->labelEx($model, 'channel'); ?>
            <?php
            echo CHtml::textField('BannerModel[channel]','app',array('readonly'=>'readonly'))
            ?>
        </div>
               
        <div class="row">
            <?php echo CHtml::label("Content Type", "") ?>
            <?php echo CHtml::dropDownList("params[content_type]", "$param->content_type", array('song'=>'Song','video'=>'Video','album'=>'Album','playlist'=>'Playlist','register'=>'Register')) ?>
        </div>
        <div class="row">
            <?php echo CHtml::label("Content ID", "") ?>
            <?php echo CHtml::textField('params[content_id]',"$param->content_id")?>
        </div>
        <div class="row">
            <?php echo CHtml::label("Áp dụng cho", "") ?>
            <?php echo CHtml::dropDownList("BannerModel[apply_user]", $model->apply_user, array(1=>'Subscribe',2=>'Unsubscribe')) ?>
        </div><div class="row">
            <?php echo CHtml::label("Kích thước ảnh", "") ?>
            <?php echo CHtml::dropDownList("params[size_image]", "$param->size_image", array('320'=>'320','480'=>'480','720'=>'720')) ?>
        </div>
        <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>
<?php $this->endWidget(); ?>

    </div><!-- form -->
</div>