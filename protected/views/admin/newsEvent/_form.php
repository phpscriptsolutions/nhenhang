<div class="content-body">
	<div class="form">
            <div class="row">
                <?php echo CHtml::label(Yii::t('admin', 'Image'), "") ?>
                <div class="avatar-display upload-avatar">
                    <?php
                    if (isset($_POST['source_image_path']) && $_POST['source_image_path'] != 0) {
                        $url = Yii::app()->params['storage']['staticUrl'] . "/tmp/" . $_POST['source_image_path'];
                    } else {
                    	$url = "";
                    	if(!$model->isNewRecord){
                    		$url = $model->getAvatarUrl($model->id,"s1");
                    	}
                    }

                    echo CHtml::image($url, "Avatar", array("id" => "img-display", "width" => 300));
                    echo '<span>Upload ảnh 860x312</span>';
                    $this->widget('ext.xupload.XUploadWidget', array(
                        'url' => $this->createUrl("NewsEvent/upload", array("parent_id" => 'tmp')),
                        'model' => $this->uploadModel,
                        'attribute' => 'file',
                        'options' => array(
                            'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
                                if(handler.response.error){
                                    alert(handler.response.msg);
                                    $("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>' . Yii::t('admin', 'Lỗi upload') . ' :"+handler.response.msg+"</div></td></tr>");
                                }else{
                                    $("#img-display").attr("src","' . Yii::app()->params['storage']['staticUrl'] . "/tmp/" . '"+handler.response.name);
                                    $("#source_image_path").val(handler.response.name);
                                }
                            }'
                        )
                    ));
                    ?>
                </div>
            </div>
	<?php
    $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-news-event-model-form',
		'enableAjaxValidation'=>false,
	)); ?>


		<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->errorSummary($model); ?>
        <?php
            $fileTmp = 0;
            if (isset($_POST['source_image_path'])) {
                $fileTmp = $_POST['source_image_path'];
            }
            echo CHtml::hiddenField("source_image_path", $fileTmp);
        ?>

		<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>

			<div class="row">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php
				$data = array(
							'news'=>'news',
							'song'=>'song',
							'video'=>'video',
							'album'=>'album',
							//'register'=>'register',
							'custom'=>'custom'
						);
				echo CHtml::dropDownList("AdminNewsEventModel[type]", $model->type, $data)
			?>
			<?php echo $form->error($model,'type'); ?>
		</div>

			<div class="row">
			<?php echo $form->labelEx($model,'object_id'); ?>
			<?php echo $form->textField($model,'object_id'); ?>
			<?php echo $form->error($model,'object_id'); ?>
		</div>

        <div class="row">
			<?php echo $form->labelEx($model,'custom_link'); ?>
			<?php echo $form->textField($model,'custom_link',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'custom_link'); ?>
		</div>

        <div class="row" style="display: none;">
			<?php echo $form->labelEx($model,'channel'); ?>
			<?php
			$chanelList = (!$model->isNewRecord)?$model->channel:$_SESSION['channel'];
			$data = Yii::app()->params['eventChannel'];
            $arr_option = explode(',',$chanelList);
            echo '<select id="channels" name="channels[]" multiple="multiple">';
            foreach($data as $key=>$val){
                $selected = (in_array($val,$arr_option))? 'selected="selected"':'';
                echo '<option value="'.$val.'" '.$selected.'>'.$key.'</option>';
            }
            echo '</select>';
            echo $form->error($model,'channel'); ?>
		</div>
        <?php if(isset($_SESSION['channel']) && $_SESSION['channel'] != 'wap'):?>
        <div class="row">
			<?php echo $form->labelEx($model,'content'); ?>
			<?php echo $form->textArea($model,'content',array('style'=>'width:360px;height:100px;','maxlength'=>500)); ?>
			<?php echo $form->error($model,'content'); ?>
        </div>
        <div class="row">
            <label for=""><b>Chú ý</b></label>
            <p style="line-height: 17px;">Trường Content(là thông tin mô tả về bài hát, video, album, playlist, news) không được để trống</p>
        </div>
        <?php endif;?>
        
        <div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->dropDownList($model,'status',array(0=>"Ẩn",1=>"Hiện")); ?>
			<?php echo $form->error($model,'custom_link'); ?>
		</div>
		        
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->
</div>