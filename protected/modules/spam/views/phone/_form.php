<div class="content-body">
    
    <?php       
      $this->widget('ext.xupload.XUploadWidget', array(
				                            'url' => $this->createUrl("Phone/upload", array("parent_id" => 'tmp')),
				                            'model' => $uploadModel,
				                            'attribute' => 'file',
				                            'options' => array(
				                                           'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
				                                           						if(handler.response.error){
				                                           							alert(handler.response.msg);
				                                           							$("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>'.Yii::t('admin','Lỗi upload').' :"+handler.response.msg+"</div></td></tr>");
				                                           						}else{				                                           							
                                                                                                                                $("#source_name").val(handler.response.name);                                                                                                                                
				                                           						}				                                                               
				                                                            }'
				                                        )
				        ));
    ?>
    <div class="form">

        <?php
        $form = $this->beginWidget(
                'CActiveForm', array(
                'id' => 'upload-form',
                'enableAjaxValidation' => false,
    
                    )
        );
        ?>
        <p>&nbsp;</p>
        <p class="note"><strong><?php echo $message; ?></strong></p><p>&nbsp;</p>
        <?php if(is_array($errorList) && count($errorList)>0){
          $str = implode(',',$errorList);
          echo '<p class="note"><strong>Danh sách các số điện thoại bị lỗi:</strong></p>';
          echo $str;
          
        }?>
        <p class="note"><?php echo yii::t('SpamModule','Lưu ý: Chỉ hỗ trợ file .xls (Excell 2003)'); ?></p>
        <div class="row buttons">
            <?php
            echo CHtml::hiddenField("source_name");
            ?>
        </div>
        <div class="row buttons">
            <?php
            echo CHtml::label('Nhóm SMS','group_id');
            echo CHtml::dropDownList('group_id', '1', $smsGroup);
            ?>
        </div>
        
        
        <div class="row buttons">
            <?php echo CHtml::submitButton('Submit'); ?>
        </div>
        
        <?php
        $this->endWidget();
        ?>

    </div><!-- form -->
</div>