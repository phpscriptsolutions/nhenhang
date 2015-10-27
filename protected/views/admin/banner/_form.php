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
                if(!$model->isNewRecord){
                	$url=Yii::app()->params['storage']['bannerUrl'].$model->image_file."?v=".time();
                }
                if ($model->type == "image")
                    echo CHtml::image($url, "Banner", array("id" => "image-display"));
                else if ($model->type == "flash"){
                    if($model->height != null && $model->width !=null){
                        $height = $model->height;
                        $width = $model->width;
                    }
                    else
                    {
                        $height = $width = "100%";
                    }
                    echo '<div id="flashContent" style="width:100%; height:100%;margin-left: 15px; margin-bottom:10px">
                        <object width="' . $width . '" height="' . $height . '" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
                        codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0">
                        <param name="SRC" value="http://222.255.28.103:8080/css/wap/images/banner/' . $model->image_file . '">
                        <param name="wmode" value="transparent"/>    
                        <embed src="http://222.255.28.103:8080/css/wap/images/banner/' . $model->image_file . '" width="' . $width . '" height="' . $height . '">
                        </embed>
                        </object>            
                    </div>';
                }
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
            <?php echo $form->labelEx($model, 'banner width'); ?>
            <?php echo $form->textField($model, 'width', array('size' => 50, 'maxlength' => 50)); ?>
            <?php echo $form->error($model, 'width'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'banner height'); ?>
            <?php echo $form->textField($model, 'height', array('size' => 50, 'maxlength' => 50)); ?>
            <?php echo $form->error($model, 'height'); ?>
        </div>
        
        <div class="row">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 50)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'url'); ?>
            <?php echo $form->textField($model, 'url', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'url'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'start_time'); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'BannerModel[start_time]',
                'value' => $model->start_time,
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            ));
            echo $form->error($model, 'start_time'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model, 'expired_time'); ?>

            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'BannerModel[expired_time]',
                'value' => $model->expired_time,
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array(
                    'style' => 'height:20px;'
                ),
            ));
            ?>
            <?php echo $form->error($model, 'expired_time'); ?>
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
            <?php echo $form->error($model, 'status'); ?>
        </div>

		<?php /*
        <div class="row">
            <?php echo $form->labelEx($model, 'channel'); ?>
            <?php
            $channel = Yii::app()->params['bannerChannel'];
            echo CHtml::dropDownList("BannerModel[channel]", $model->channel, $channel)
            ?>  
            <?php echo $form->error($model, 'channel'); ?>
        </div>
        */?>
        
        <div class="row">
            <?php echo CHtml::label("Log lượt click", "") ?>
            <?php            
            echo CHtml::dropDownList("BannerModel[log_click]", $model->log_click, array(0=>'Không log',1=>'Log lượt click'))
            ?> 
            <span>Chỉ áp dụng cho wap</span>
            <?php echo $form->error($model, 'channel'); ?>
        </div>
        <div id="for">
            <div class="row">
                <?php echo $form->labelEx($model, 'position'); ?>
                <?php
                $position = Yii::app()->params['position'];
                ?>                
                <select id="BannerModel_position" name="BannerModel[position]" style="width:300px">
                    <?php
                    if(!$model->isNewRecord){
                    	$positionSelected = $model->position;
                    }else{
                    	$positionSelected="";
                    }
                    foreach($position as $channel => $arr){
                        foreach($arr as $key => $val){
							if($positionSelected==$key){
								$selected = "selected";
							}else{
								$selected = "";
							}
                            echo "<option class='$channel' value='$key' $selected>$val</option>";
                        }
                    }
                    ?>
                </select>
                <?php
                echo $form->error($model, 'position');
                echo CHtml::hiddenField('BannerModel[type]', $model->type);
                ?>
            </div>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'Tỷ lệ hiển thị'); ?>
            <?php echo $form->textField($model, 'rate', array('size' => 50, 'maxlength' => 2)); ?>
            <span>(Nhập giá trị nhỏ hơn 10)</span>
            <?php echo $form->error($model, 'rate'); ?>
        </div>
        <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>

<?php $this->endWidget(); ?>

    </div><!-- form -->
</div>