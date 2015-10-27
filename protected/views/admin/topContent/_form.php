<?php
Yii::app()->getClientScript()->registerCssFile( Yii::app()->theme->baseUrl."/css/jquery.autocomplete.css");
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl."/js/jquery.autocomplete.js");
$link = Yii::app()->createUrl("topContent/autoComplete");

$script = <<<EOD
                var tc_type = $('#AdminTopContentModel_type').val();
				if(typeof tc_type === 'undefined'){
					tc_type = "album";
				}
                var link = '/topContent/autoComplete?t='+tc_type;
                
                $(document).ready(function(){
						$('#content_id_name').autocomplete(link, {
                                width: 260,
                                matchContains: true,
                                mustMatch: true,
                                selectFirst: false
                        });
                        $("#content_id_name").result(function(event, data, formatted) {
                            if(data){								
								$("#AdminTopContentModel_content_id").val(data[1]);
								$("#showname").html(data[0]);
								setTimeout(function(){
						            $("#content_id_name").val(data[0]);
						        },100);
                            }
                        }); 
		
                });
                
                function optType_onchange(){
                    $('#AdminTopContentModel_type_hid').val($('#AdminTopContentModel_type').val());
                    $('#AdminTopContentModel_type').attr('disabled','true');
                    $('#divdetail').show();
                    tc_type = $('#AdminTopContentModel_type_hid').val();
                    link = '/topContent/autoComplete?t='+tc_type;
                    if(tc_type != ''){
                        $('#content_id_name').autocomplete(link, {
                                width: 260,
                                matchContains: true,
                                mustMatch: true,
                                selectFirst: false
                        });
                        $("#content_id_name").result(function(event, data, formatted) {
                            if(data){
                                $("#AdminTopContentModel_content_id").val(data[1]);
								$("#showname").html(data[0]);
								setTimeout(function(){
						            $("#content_id_name").val(data[0]);
						        },100);
                            }
                        });
                    }
                }
		

EOD;
Yii::app()->clientScript->registerScript("auto",$script, CClientScript::POS_HEAD);

?>
<div class="content-body">
	<div class="form">
                <?php echo CHtml::label(yii::t('admin','Ảnh đại diện'), ""); ?>
                <div class="thumb pl130">
                <?php
			if (isset($_POST['tmp_file_path']) && $_POST['tmp_file_path'] != 0) {
				$url = Yii::app()->params['storage']['staticUrl']."/tmp/" . $_POST['tmp_file_path'];
			} else {
				$url = $model->getAvatarUrl($model->id,'s1');
			}
			echo CHtml::image($url, "Avatar", array("id" => "img-display", "style"=>"height: 296px !important; width:690px !important;" ));
			echo '<p style="padding:10px">Upload ảnh '.$this->coverWidth.'x'.$this->coverHeight.'</p>';
			
			$this->widget('ext.xupload.XUploadWidget', array(
	                'url' => $this->createUrl("topContent/upload", array("parent_id" => 'tmp')),
	                'model' => $this->uploadModel,
	                'attribute' => 'file',
	                'text' => Yii::t('admin', 'Upload file'),
	                'options' => array(
	                    'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
                                                        if(handler.response.error){
                                                                alert(handler.response.msg);
                                                                $("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>' . Yii::t('admin', 'Error upload') . ': "+handler.response.msg+"</div></td></tr>");
                                                        }else{
                                                                $("#tmp_file_path").val(handler.response.name);
                                                                $("#files").html("<tr><td><label></label></td><td><div class=\'success\'>' . Yii::t('admin', 'Upload success image') . ': "+files[index].name+"</div></td></tr>");
                                                                $(".errorSummary").hide();
                                                                $("#img-display").attr("src","' . Yii::app()->params['storage']['staticUrl'] . "/tmp/" . '"+handler.response.name);
                                                        }
                            }'
                            )
                            ));
                ?>
                <?php if (isset($error) && ($error == 1)): ?>
            		<div style="padding:10px;"><span class='required'>Vui lòng chọn lại ảnh 690x296px!</span></div>
            	<?php endif; ?>
                </div>
            <div style="clear: both;"/>            
        </div>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'admin-top-content-model-form',
			'enableAjaxValidation'=>false,
		)); ?>
                <?php echo $form->errorSummary($model); ?>
                
                <?php
		            $fileTmp = 0;
		            if (isset($_POST['tmp_file_path'])) {
		                $fileTmp = $_POST['tmp_file_path'];
		            }
		            echo CHtml::hiddenField("tmp_file_path", $fileTmp);
		        ?>
        
                <?php if($model->isNewRecord):?>
                <div class="row">
			<?php echo $form->labelEx($model,'type'); ?>
                        <?php //echo $form->dropDownList($model,'type', TopContentModel::getTypeArray(), array('onchange'=>'optType_onchange()', 'size'=>1));?>
                        <select id="AdminTopContentModel_type" name="AdminTopContentModel[type]" onchange="optType_onchange()" style="background-color: lightyellow;">
                            <option selected="selected" value="">Select a type</option>
                            <option value="album">Album</option>
                            <?php /*<option value="video_playlist">Live show</option>*/?>
                        </select>
                        <?php echo $form->hiddenField($model,'type',array('id'=>'AdminTopContentModel_type_hid')); ?>
		</div>
                <?php endif;?>
                <div id="divdetail" style="<?php if(Yii::app()->controller->action->id == 'create') echo 'display: none;'?>">
                    <p class="note">Fields with <span class="required">*</span> are required.</p>
                    <div class="row">
                            <?php echo $form->labelEx($model,'name'); ?>
                            <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php //if($model->isNewRecord):?>
                    <div class="row">
                        <?php echo $form->labelEx($model,'Tên nội dung'); ?>
                        <?php echo CHtml::textField('content_id_name','',array('id'=>'content_id_name')); ?>
                        <?php //echo $form->textField($model,'content_id',array('readOnly'=>'true','size'=>60,'maxlength'=>255)); ?>
                    </div>
                    <?php //endif;?>
                    <div class="row">
                           <?php echo $form->labelEx($model,'content id'); ?>
                           <?php echo $form->textField($model,'content_id',array('readOnly'=>'true','style'=>'background-color: lightyellow;')); ?>
                           <span id="showname"></span>
                    </div>
                        
                    <?php if(!($model->isNewRecord)):?>
                         <div class="row">
                            <?php echo $form->labelEx($model,'type'); ?>
                            <?php echo $form->textField($model,'type',array('readOnly'=>'true','style'=>'background-color: lightyellow;')); ?>
                        </div>
                    <?php endif;?>
                    <div class="row">
                            <?php echo $form->labelEx($model,'group'); ?>
                            <?php
                                $groupType = array('home'=>'home','video'=>'video','album'=>'album');
                                echo $form->dropDownList($model, 'group', $groupType, array());
                            ?>
                    </div>
                     <div class="row">
                            <?php echo $form->labelEx($model,'sorder'); ?>
                            <?php echo $form->textField($model,'sorder'); ?>
                            <?php echo $form->error($model,'sorder'); ?>
                    </div>
                    
                    <?php /*
    				<div class="row">
                            <?php echo $form->labelEx($model,'link'); ?>
                            <?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>255)); ?>
                            <?php echo $form->error($model,'link'); ?>
                    </div>

                    <div class="row">
                            <?php echo $form->labelEx($model,'status'); ?>
                            <?php echo $form->textField($model,'status'); ?>
                            <?php echo $form->error($model,'status'); ?>
                    </div>
                    */?>
                    
			         <div class="row global_field">
			            <?php echo CHtml::label(Yii::t('admin', 'Tag'), ''); ?>
			            <div>
							<a href="<?php echo Yii::app()->createUrl('tag/index')?>" class="show-pop">Chọn tag từ danh sách</a>
					       	<div id="tags" class="artist-zone">
					       	</div>            
			            </div>
			        </div>
                    <div class="row">
                        <?php echo $form->labelEx($model,'description'); ?>
                        <?php echo $form->textArea($model,'description', array('style'=>'width: 500px;height: 100px;')); ?>
                        <?php echo $form->error($model,'description'); ?>
                    </div>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('style'=>'width: 140px;')); ?>
                        <?php echo CHtml::button('Reset', array('onclick'=>'window.location.reload();', 'style'=>'width: 140px;')); ?>
                    </div>
                </div>
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>
<script type="text/javascript">
//<!--
var page_id = "topContent";
var tags = [];
tags = [<?php foreach ($this->tags as $tag):?>
{id:<?php echo $tag->tag_id?>,name:'<?php echo $tag->tag_name?>'},
<?php endforeach;?>];

displayTag(tags,"#tags");
//-->
</script>