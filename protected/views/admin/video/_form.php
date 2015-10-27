<?php
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('bbq');

$cs->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/form.js");
$baseScriptUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')) . '/gridview';
$cssFile = $baseScriptUrl . '/styles.css';
$cs->registerCssFile($cssFile);
$cs->registerScriptFile($baseScriptUrl . '/jquery.yiigridview.js', CClientScript::POS_END);
?>
<div class="content-body">
    <div class="form" id="basic-zone">
    <?php /*
        <div class="row global_field">
            <?php echo CHtml::label("Video file", "") ?>
            <?php
            $this->widget('ext.xupload.XUploadWidget', array(
                'url' => $this->createUrl("video/upload", array("parent_id" => 'tmp')),
                'model' => $uploadModel,
                'attribute' => 'file',
                'text' => 'Upload file',
                'options' => array(
                    'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
                        if(handler.response.error){
                            alert(handler.response.msg);
                            $("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>' . Yii::t('admin', 'Lỗi upload') . ': "+handler.response.msg+"</div></td></tr>");
                        }else{
                            $("#tmp_source_path").val(handler.response.name);
                            $("#files").html("<tr><td><label></label></td><td><div class=\'success\'>' . Yii::t('admin', 'Upload thành công video') . ': "+files[index].name+"</div></td></tr>");
                            $(".errorSummary").hide();
                        }
                    }'
                )
            ));
            ?>
            <div class="pl130 i"><i><?php echo Yii::t('admin', 'Chỉ hỗ trợ file MP4'); ?></i></div>
        </div>
	*/?>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-video-model-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data','onsubmit'=>'return validate_form();')
                ));
        ?>

        <?php echo $form->errorSummary($model); ?>
        <?php
        $fileTmp = (isset($_POST['tmp_source_path']) && $_POST['tmp_source_path']!=0) ?$_POST['tmp_source_path'] : 0;
        echo CHtml::hiddenField("tmp_source_path", $fileTmp);
        ?>

        <?php if ($model->id): ?>
            <div class="row global_field">
                <?php echo CHtml::label("Ảnh đại diện", ""); ?>
                <div class="oflowh">                
                    <?php echo CHtml::image(AvatarHelper::getAvatar("video", $model->id, 150, strtotime($model->updated_time)), "Avatar", array("height" => 80)); ?>
                    <div class="clf m5"><br /></div>
                    <?php /*
                    <div class="fl">
                        <?php echo CHtml::image(str_replace('s2.chacha.vn', 'audio.chacha.vn:81', $model->getAvatarListUrl($model->id)) . "1.jpg", "Avatar", array("height" => 80,"class"=>"crop_img","id"=>"AdminVideoModel_avatar_1")); ?>
                        <input type="radio" name="AdminVideoModel[avatar]" value="1" />
                    </div>
                    <div class="fl">
                        <?php echo CHtml::image(str_replace('s2.chacha.vn', 'audio.chacha.vn:81',$model->getAvatarListUrl($model->id)) . "2.jpg", "Avatar", array("height" => 80,"class"=>"crop_img","id"=>"AdminVideoModel_avatar_2")); ?>
                        <input type="radio" name="AdminVideoModel[avatar]" value="2" />
                    </div>
                    <div class="fl">
                        <?php echo CHtml::image(str_replace('s2.chacha.vn', 'audio.chacha.vn:81',$model->getAvatarListUrl($model->id)) . "3.jpg", "Avatar", array("height" => 80,"class"=>"crop_img","id"=>"AdminVideoModel_avatar_3")); ?>
                        <input type="radio" name="AdminVideoModel[avatar]" value="3" />
                    </div>
                    <div class="fl">
                        <?php echo CHtml::image(str_replace('s2.chacha.vn', 'audio.chacha.vn:81',$model->getAvatarListUrl($model->id)) . "4.jpg", "Avatar", array("height" => 80,"class"=>"crop_img","id"=>"AdminVideoModel_avatar_4")); ?>
                        <input type="radio" name="AdminVideoModel[avatar]" value="4" />
                    </div>
                    <div class="clb m10 oflowh"></div>
                    <div class="borderB"></div>
                    */?>
                    
                    <div class="clb m10 oflowh"></div>
                    <div class="uploadimg">                        
                        <input type="file" name="avatar_upload" id="avatar_upload" />
                        <br/><br/>
                        <b><?php echo Yii::t('admin', 'Upload file jpg'); ?></b>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row global_field">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255, 'class' => 'txtchange')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'url_key'); ?>
            <?php echo $form->textField($model, 'url_key', array('size' => 60, 'maxlength' => 255, 'class' => 'txtrcv')); ?>
            <?php echo $form->error($model, 'url_key'); ?>
        </div>

        <div class="row active_fromtime">
            <div style="float: left;"><?php echo $form->label($model,'active time'); ?></div>
            <div style="float: left; ">
                <?php
                    $this->widget('ext.daterangepicker.input',array(
                         'name'=>'active_time',
                         'value'=>(isset($activetime)&&($activetime[0]<>'01/01/1970'))?$activetime[0].' - '.$activetime[1]:'',
                     ));
                ?>
            </div>
        </div>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'Thể loại'); ?>
            <?php
            $selected = CHtml::listData($this->videoCate, "genre_id", "genre_id");
            //echo CHtml::dropDownList("AdminVideoModel[genre_id]", $model->genre_id, CHtml::listData($categoryList, 'id', 'name')); ?>
            <!--<select name="AdminVideoModel[genre_id]" id="AdminVideoModel_genre_id">
                <option value="">--Select genre--</option>
                <?php /*foreach($categoryList as $cat):*/?>
                    <option value="<?php /*echo $cat['id'];*/?>" <?php /*if($cat['id']==$model->genre_id) echo 'selected';*/?> <?php /*if($cat['parent_id']==0):*/?>disabled="disabled" <?php /*endif;*/?>><?php /*echo $cat['name'];*/?></option>
                <?php /*endforeach;*/?>
            </select>-->
            <select size="8" multiple="multiple" name="genre_ids[]" id="genre_ids">
                <?php foreach($categoryList as $cat):?>
                    <option value="<?php echo $cat['id'];?>" <?php if(in_array($cat['id'],$selected)) echo 'selected';?> <?php if($cat['parent_id']==0):?>disabled="disabled" <?php endif;?>><?php echo $cat['name'];?></option>
                <?php endforeach;?>
            </select>
            <?php echo $form->error($model, 'genre_id'); ?>
        </div>

        <div class="row global_field">
            <?php echo CHtml::label(Yii::t('admin', 'Ca sỹ' . ' <span class="required">*</span>'), ""); ?>
            <?php
			$this->widget('application.widgets.admin.artist.Feild', array(
					'fieldId' => 'artist_id',
					'fieldIdVal' => $this->videoArtist,
				)
			);

            ?>

            <?php echo $form->error($model, 'artist_name'); ?>
        </div>

        <div class="row global_field">
            <?php echo CHtml::label(Yii::t('admin', 'Nhạc sĩ'), ""); //$form->labelEx($model,'Sáng tác');  ?>
            <?php
            $composer_name = ($model->composer_id) ? AdminArtistModel::model()->findByPk($model->composer_id)->name : null;
			$this->widget('application.widgets.admin.ArtistAuto', array(
					'fieldId' => 'AdminVideoModel[composer_id]',
					'fieldName' => 'AdminVideoModel[composer_name]',
					'fieldIdVal' => $model->composer_id,
					'fieldNameVal' => $composer_name,
			)
			);
            ?>
            <?php echo $form->error($model, 'composer_id'); ?>
        </div>
        <?php if ($this->cpId == 0): ?>
        <div class="row global_field">
            <?php echo $form->label($model, 'cp_id'); ?>
        <?php
        $cp = CHtml::listData($cpList, 'id', 'name');
        echo CHtml::dropDownList("AdminVideoModel[cp_id]", $model->cp_id, $cp)
        ?>
        </div>
        <?php endif; ?>

		<?php if($this->canEditPrice()):?>
		<div class="row global_field">
            <?php echo $form->labelEx($model, 'listen_price'); ?>
            <?php echo $form->textField($model, 'listen_price', array('size' => 11, 'maxlength' => 11, 'value'=>($model->isNewRecord)?'2000':$model->listen_price)); ?>
        </div>

		<div class="row global_field">
            <?php echo $form->labelEx($model, 'allow_download'); ?>
            <?php echo $form->dropDownList($model, 'allow_download', array('1' => 'Yes', '0' => 'No'), array('id'=>'allow_download', 'onChange'=>'changeDownloadOption(this);')); ?>
        </div>

		<div class="row global_field" id="download_price_row">
            <?php echo $form->labelEx($model, 'download_price'); ?>
            <?php echo $form->textField($model, 'download_price', array('size' => 11, 'maxlength' => 11, 'value'=>($model->isNewRecord)?'3000':$model->download_price)); ?>
        </div>
		<?php endif;?>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'owner'); ?>
            <?php echo $form->textField($model, 'owner', array('size' => 60, 'maxlength' => 255)); ?>
        </div>

        <?php /*
        <div class="row global_field">
            <?php echo CHtml::label('Tác quyền', 'song_', array('class' => 'fl lh35', 'style' => 'line-height: 20px;')); ?>

            <a href="javascript:void(0)" onclick='slcopy("0");'>Chọn từ danh sách</a>
            <br/>
            <div class="appendix_list" id="appendix_no0">
                <?php
                $ids = array();
                if(isset($copyright) && count($copyright)>0):
                foreach ($copyright as $itcp):
                    ?>
                    <?php
                    if ($itcp['type'] == 0):
                        $ids[] = $itcp['copyr']['id'];
                        ?>
                        <p id="<?php echo $itcp['copyr']['id']; ?>"><span style="float:left; margin:5px 5px 0px 0px; width: 80px;"><?php echo $itcp['copyr']['appendix_no']; ?></span><input type="radio" name="cpy0" value="<?php echo $itcp['copyr']['id']; ?>" style="float:left;" <?php if ($itcp['active'] == 1): ?> checked="true" <?php endif; ?> class="val-cpy0"><span style="float:left; margin-top:4px;">active</span><span style="float:left; margin:5px 5px 0px 5px;">Từ</span><input type="text" style="width:85px;" value="<?php echo $itcp['from_date']; ?>" name="start_date_<?php echo $itcp['copyr']['id']; ?>"><span style="float:left; margin:5px 5px 0px 5px;">Đến</span><input type="text" style="width:85px;" value="<?php echo $itcp['due_date']; ?>" name="due_date_<?php echo $itcp['copyr']['id']; ?>"><select style="width:120px; height: 23px; margin-left:5px;" name="copy_type_<?php echo $itcp['copyr']['id']; ?>"><option value="0" <?php if($itcp['copyright_method']==0):?>selected<?php endif;?>>Không độc quyền</option><option value="1" <?php if($itcp['copyright_method']==1):?>selected<?php endif;?>>Độc quyền</option></select><span onclick='remove_copy("<?php echo $itcp['copyr']['id']; ?>");' class="remove-artist" style="margin-top:5px;">Remove</span></p>
                    <?php endif; ?>
                <?php endforeach;
                endif;
                ?>
                <input type="hidden" value="<?php echo implode(',', $ids); ?>" name="valcopy0" id="valcopy0"/>
            </div>

        </div>

        <div class="row global_field">
            <?php echo CHtml::label('Quyền liên quan', 'song_', array('class' => 'fl lh35', 'style' => 'line-height: 20px;')); ?>

            <a href="javascript:void(0)" onclick='slcopy("1");'>Chọn từ danh sách</a>
            <br/>
            <div class="appendix_list" id="appendix_no1">
                <?php
                $ids = array();
                if(isset($copyright) && count($copyright)>0):
                foreach ($copyright as $itcp): ?>
                    <?php
                    if ($itcp['type'] == 1):

                        $ids[] = $itcp['copyr']['id'];
                        ?>
                <p id="<?php echo $itcp['copyr']['id']; ?>"><span style="float:left; margin:5px 5px 0px 0px; width: 80px;"><?php echo $itcp['copyr']['appendix_no']; ?></span><input type="radio" name="cpy1" value="<?php echo $itcp['copyr']['id']; ?>" style="float:left;" <?php if ($itcp['active'] == 1): ?> checked="true" <?php endif; ?> class="val-cpy1"><span style="float:left; margin-top:4px;">active</span><span style="float:left; margin:5px 5px 0px 5px;">Từ</span><input type="text" style="width:85px;" value="<?php echo $itcp['from_date']; ?>" name="start_date_<?php echo $itcp['copyr']['id']; ?>"><span style="float:left; margin:5px 5px 0px 5px;">Đến</span><input type="text" style="width:85px;" value="<?php echo $itcp['due_date']; ?>" name="due_date_<?php echo $itcp['copyr']['id']; ?>"><select style="width:120px; height: 23px; margin-left:5px;" name="copy_type_<?php echo $itcp['copyr']['id']; ?>"><option value="0" <?php if($itcp['copyright_method']==0):?>selected<?php endif;?>>Không độc quyền</option><option value="1" <?php if($itcp['copyright_method']==1):?>selected<?php endif;?>>Độc quyền</option></select><span onclick='remove_copy("<?php echo $itcp['copyr']['id']; ?>");' class="remove-artist" style="margin-top:5px;">Remove</span></p>
                    <?php endif; ?>
                <?php endforeach;
                endif;
                ?>
                <input type="hidden" value="<?php echo implode(',', $ids); ?>" name="valcopy1" id="valcopy1"/>
            </div>
        </div>
*/?>
        
        
        
        <div class="row global_field">
            <?php echo $form->labelEx($model, 'source'); ?>
            <?php echo $form->textField($model, 'source', array('size' => 60, 'maxlength' => 255)); ?>
        </div>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'source_link'); ?>
            <?php echo $form->textField($model, 'source_link', array('size' => 60, 'maxlength' => 255)); ?>
        </div>

        <div class="row global_field">
            <?php echo CHtml::label(Yii::t('admin', 'Tag'), ''); ?>
            <div>
				<a href="<?php echo Yii::app()->createUrl('tag/index')?>" class="show-pop">Chọn tag từ danh sách</a>
		       	<div id="tags" class="artist-zone">
		       	</div>            
            </div>
        </div> 
        
        <div class="row global_field">
        <?php echo CHtml::label(Yii::t('admin', 'Lời bài hát'), ""); ?>
        <?php
            /* $this->widget('application.extensions.tinymce.ETinyMce', array(
                'model' => $model,
                'attribute' => 'lyrics',
                'width' => '75%',
            )); */

		//echo $form->textArea($model, 'lyrics', array('cols' => 50, 'rows' => 10));
//		echo $form->textArea($model, 'lyrics', array('cols' => 50, 'rows' => 10));
		$lyric = html_entity_decode($model->lyrics);		
		echo CHtml::textArea('AdminVideoModel[lyrics]', $lyric, array('cols' => 50, 'rows' => 10));

        ?>
        <?php
//        $videoExtra = AdminVideoExtraModel::model()->findByPk($model->id);
//        $description = ($videoExtra) ? ($videoExtra->description) : "";
//        echo CHtml::textArea('AdminVideoModel[description]', $description, array('cols' => 50, 'rows' => 10));
        ?>
        </div>


            <?php
            if (isset($model->id) && $this->cpId == 0 &&
                    ($model->videostatus->convert_status == AdminVideoStatusModel::CONVERT_FAIL ||
                    $model->status == VideoModel::ACTIVE )) :
                ?>
            <div class="row global_field">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php
            if ($model->videostatus->convert_status == AdminVideoStatusModel::CONVERT_FAIL) {
                $videoStatus = AdminSongModel::CONVERT_FAIL;
                $status = array(
                    AdminVideoModel::NOT_CONVERT => "Chưa convert",
                    AdminVideoModel::CONVERT_FAIL => "Convert lỗi",
                );
            }
            if ($model->status == VideoModel::ACTIVE) {
                $videoStatus = AdminVideoModel::ACTIVE;
                $status = array(
                    AdminVideoModel::ACTIVE => "Đã duyệt",
                    AdminVideoModel::NOT_CONVERT => "Chưa convert",
                    AdminVideoModel::WAIT_APPROVED => "Chờ duyệt"
                );
            }
            echo CHtml::dropDownList("AdminVideoModel[status]", $videoStatus, $status)
            ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
            <?php endif; ?>
        <?php
/*        $metaData = array();
        if($videoMeta){
            foreach($videoMeta as $meta){
                $metaData[$meta->meta_key] = $meta->meta_value;
            }
        }
        */?><!--
        <fieldset>
            <legend>SEO Meta Data</legend>
            <div class="row meta_field">
                <?php /*echo CHtml::label("Tiêu đề", ""); */?>
                <?php /*echo CHtml::textField("videoMeta[title]", isset($metaData['title']) ? $metaData['title'] : "", array('style' => 'width:400px;', 'maxlength' => 100)); */?>
            </div>
            <div class="row meta_field">
                <?php /*echo CHtml::label("Từ khóa", ""); */?>
                <?php /*echo CHtml::textArea("videoMeta[keywords]", isset($metaData['keywords']) ? $metaData['keywords'] : "", array('style' => 'width:400px;height: 100px;', 'maxlength' => 500)); */?>
            </div>
            <div class="row meta_field">
                <?php /*echo CHtml::label("Mô tả", ""); */?>
                <?php /*echo CHtml::textArea("videoMeta[description]", isset($metaData['description']) ? $metaData['description'] : "", array('style' => 'width:400px;height: 100px;', 'maxlength' => 255)); */?>
            </div>

        </fieldset>-->

        <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>

            <?php $this->endWidget(); ?>

    </div><!-- form -->

    <div class="form" id="fav-zone" style="display: none;">
    </div>
</div>
<script type="text/javascript">
//<!--
        var checked_ok = 0;
	function validate_form()
	{
        var artists = [];
        var  i= 0;
        $("#artist_id input").each(function(){
        	artists[i++] = $(this).val();
     	});
     	if(artists.length < 1){
         	alert("Cần chọn ít nhất 1 ca sỹ");
         	return false;
        }
		return true;
	}

	$(".crop_img").live("click",function(){
		var val = $("input[type='radio']",$(this).parent()).val();
		$("input[type='radio']", $(this).parent()).attr('checked',true);
		var url = "<?php echo Yii::app()->createUrl("image/crop")?>";
		var params = {"img_type":"video",obj_id:<?php echo $model->id?>,item_id:val};
		displayPop(url,params);

	})
	
	var tags = [];
	tags = [<?php foreach ($this->tags as $tag):?>
	{id:<?php echo $tag->tag_id?>,name:'<?php echo $tag->tag_name?>'},
	<?php endforeach;?>];

	displayTag(tags,"#tags");

//-->
</script>