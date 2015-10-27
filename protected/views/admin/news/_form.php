<div class="content-body">
    <div class="form">
        <div class="row">
            <?php echo CHtml::label(Yii::t('admin', 'Avatar'), "") ?>
            <div class="avatar-display upload-avatar">
                <?php
                if (isset($_POST['AdminNewsModel']['source_path']) && $_POST['AdminNewsModel']['source_path'] != 0) {
                    $url = Yii::app()->params['storage']['staticUrl']."/tmp/" . $_POST['AdminNewsModel']['source_path'];
                } else {
                    $url = $model->getAvatarUrl();
                }

                echo CHtml::image($url, "Avatar", array("id" => "img-display", "height" => 150));
                $this->widget('ext.xupload.XUploadWidget', array(
                    'url' => $this->createUrl("news/upload", array("parent_id" => 'tmp')),
                    'model' => $uploadModel,
                    'attribute' => 'file',
                    'options' => array(
                        'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
                            if(handler.response.error){
                                alert(handler.response.msg);
                                $("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>' . Yii::t('admin', 'Lỗi upload') . ' :"+handler.response.msg+"</div></td></tr>");
                            }else{
                                $("#img-display").attr("src","' . Yii::app()->params['storage']['staticUrl']."/tmp/" . '"+handler.response.name);
                                $("#AdminNewsModel_source_path").val(handler.response.name);
                            }				                                                               
                        }'
                    )
                ));
                ?>
            </div>
        </div>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-news-model-form',
            'enableAjaxValidation' => false,
                ));
        ?>


        <?php echo $form->errorSummary($model); ?>
        <?php
        $fileTmp = 0;
        if (isset($_POST['AdminNewsModel']['source_path'])) {
            $fileTmp = $_POST['AdminNewsModel']['source_path'];
        }
        echo CHtml::hiddenField("AdminNewsModel[source_path]", $fileTmp);
        ?>	
        <div class="row">
            <?php echo $form->labelEx($model, 'title'); ?>
            <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'intro'); ?>
            <?php echo $form->textArea($model, 'intro', array('cols' => 60, 'rows' => 8)); ?>
            <?php echo $form->error($model, 'intro'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'content'); ?>
            <?php //echo $form->textArea($model,'content',array('cols'=>60,'rows'=>8)); ?>
            <?php /*
              $this->widget('application.extensions.tinymce.ETinyMce',
              array(
              'name'=>'AdminNewsModel[content]',
              'model'=>$model,
              'attribute'=>'content',
              'width'=>'75%',
              'editorTemplate'=>'full'
              ));
             */
            ?>
            <?php
            $this->widget('ext.elrtef.elRTE', array(
                'model' => $model,
                'attribute' => 'content',
                //'name' => 'text',
                //'htmlOptions' => array('height' => '600'),
                'options' => array(
                    'doctype' => 'js:\'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\'',
                    'cssClass' => 'el-rte',
                    'cssfiles' => array('css/elrte-inner.css'),
                    'absoluteURLs' => true,
                    'allowSource' => true,
                    'lang' => 'vi',
                    'styleWithCss' => '',
                    'height' => 400,
                    'fmAllow' => true, //if you want to use Media-manager
                    'fmOpen' => 'js:function(callback) {$("<div id=\"elfinder\" />").elfinder(%elfopts%);}', //here used placeholder for settings
                    'toolbar' => 'maxi',
                ),
                'elfoptions' => array(//elfinder options
                    'url' => 'auto', //if set auto - script tries to connect with native connector
                    'passkey' => 'mypass', //here passkey from first connector`s line
                    'lang' => 'ru',
                    'dialog' => array('width' => '900', 'modal' => true, 'title' => 'Media Manager'),
                    'closeOnEditorCallback' => true,
                    'editorCallback' => 'js:callback'
                ),
                    )
            );
            ?>

            <?php echo $form->error($model, 'intro'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'related_artists'); ?>
            <?php echo $form->textField($model, 'related_artists', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'related_artists'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo CHtml::dropDownList("AdminNewsModel[status]", $model->status, array(Yii::t('admin', 'Chưa kích hoạt'), Yii::t('admin', 'Đang kích hoạt'))) ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>