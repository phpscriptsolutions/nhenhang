<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . "/js/admin/common.js"); ?>
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
<div class="form content-body">
    <div class="form" id="basic-zone">
    	<?php /*
        <div class="row global_field">
            <?php echo CHtml::label("Mp3 file", "") ?>
            <?php
            $this->widget('ext.xupload.XUploadWidget', array(
                'url' => $this->createUrl("song/upload", array("parent_id" => 'tmp')),
                'model' => $uploadModel,
                'attribute' => 'file',
                'text' => Yii::t('admin', 'Upload file'),
                'options' => array(
                    'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
		                                           						if(handler.response.error){
		                                           							alert(handler.response.msg);
		                                           							$("#files").html("<tr><td><label></label></td><td><div class=\'wrr\'>' . Yii::t('admin', 'Lỗi upload') . ': "+handler.response.msg+"</div></td></tr>");
		                                           						}else{
		                                           							$("#tmp_source_path").val(handler.response.name);
		                                           							$("#files").html("<tr><td><label></label></td><td><div class=\'success\'>' . Yii::t('admin', 'Upload thành công bài hát') . ': "+files[index].name+"</div></td></tr>");
		                                           							$(".errorSummary").hide();
		                                           						}
		                                                            }'
                )
            ));
            ?>

        </div>
        */?>
        
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'admin-song-model-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('onsubmit' => 'return validate_form();')
                ));
        ?>

        <?php echo $form->errorSummary($model); ?>
        <?php
        $fileTmp = (isset($_POST['tmp_source_path']) && $_POST['tmp_source_path'] != 0) ? $_POST['tmp_source_path'] : 0;
        echo CHtml::hiddenField("tmp_source_path", $fileTmp);
        ?>
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
            <div style="float: left;"><?php echo $form->label($model, 'active time'); ?></div>
            <div style="float: left; ">
                <?php
                $this->widget('ext.daterangepicker.input', array(
                    'name' => 'active_time',
                    'value' => (isset($activetime) && ($activetime[0] <> '01/01/1970')) ? $activetime[0] . ' - ' . $activetime[1] : '',
                ));
                ?>
            </div>
        </div>

        <div class="row global_field">
            <?php echo CHtml::label(Yii::t('admin', 'Thể loại'), ""); ?>
            <?php
            //echo CHtml::dropDownList("AdminSongModel[genre_id]", $model->genre_id, CHtml::listData($categoryList, 'id', 'name'))
            $selected = CHtml::listData($this->songCate, "genre_id", "genre_id");
            //echo CHtml::listBox("genre_ids", $selected, CHtml::listData($categoryList, 'id', 'name'), array('size' => 8, 'multiple' => 'multiple'));
            ?>
            <select size="8" multiple="multiple" name="genre_ids[]" id="genre_ids">
            <?php foreach($categoryList as $cat):?>
                <option value="<?php echo $cat['id'];?>" <?php if(in_array($cat['id'],$selected)) echo 'selected';?> <?php if($cat['parent_id']==0):?>disabled="disabled" <?php endif;?>><?php echo $cat['name'];?></option>
            <?php endforeach;?>
            </select>
            <?php echo $form->error($model, 'genre_id'); ?>
        </div>


        <div class="row global_field">
            <?php echo CHtml::label(Yii::t('admin', 'Ca sỹ') . ' <span class="required">*</span>', ""); ?>
            <?php
            $this->widget('application.widgets.admin.artist.Feild', array(
                'fieldId' => 'artist_id',
                'fieldIdVal' => $this->songArtist,
                    )
            );
            ?>
            <?php
                if(isset($hadsong) && $hadsong){
                    echo '<div class="hadsong">Xem chi tiết bài hát đã có trên hệ thống <a href="'.Yii::app()->createUrl('song/view', array('id'=>$hadsong['id'])).'">Tại đây</a></div>';
                }
            ?>
        </div>

        <div class="row global_field">
            <?php echo CHtml::label(Yii::t('admin', 'Nhạc sĩ'), ""); ?>
            <?php
            $composer_name = ($model->composer_id) ? AdminArtistModel::model()->findByPk($model->composer_id)->name : null;
            $this->widget('application.widgets.admin.ArtistAuto', array(
                'fieldId' => 'AdminSongModel[composer_id]',
                'fieldName' => 'AdminSongModel[composer_name]',
                'fieldIdVal' => $model->composer_id,
                'fieldNameVal' => $composer_name,
                    )
            );
            ?>


            <?php echo $form->error($model, 'composer_id'); ?>
        </div>
        
        <div class="row global_field">
            <?php echo $form->labelEx($model, 'video_id'); ?>
            <?php echo $form->textField($model, 'video_id'); ?>
        </div>
        
        <?php if (!$model->getIsNewRecord()): ?>
        <div class="row global_field">
            <?php echo $form->labelEx($model, 'video_name'); ?>
            <?php echo $form->textField($model, 'video_name', array("disabled" => "disabled")); ?>
        </div>
        <?php endif; ?>

        <div class="row global_field">
        	<?php echo $form->labelEx($model, 'cp_id'); ?>
            <?php
                $cp = CHtml::listData($cpList, 'id', 'name');
                echo CHtml::dropDownList("AdminSongModel[cp_id]", $model->cp_id, $cp)
            ?>
		</div>
        <?php /*    
		<div class="row global_field">
            <?php echo $form->labelEx($model, 'max_bitrate'); ?>
            <?php echo $form->textField($model, 'max_bitrate', array('size' => 11, 'maxlength' => 11)); ?>
        </div>
		<?php if($this->canEditPrice()):?>
		<div class="row global_field">
            <?php echo $form->labelEx($model, 'listen_price'); ?>
            <?php echo $form->textField($model, 'listen_price', array('size' => 11, 'maxlength' => 11)); ?>
        </div>

		<div class="row global_field">
            <?php echo $form->labelEx($model, 'allow_download'); ?>
            <?php echo $form->dropDownList($model, 'allow_download', array('1' => 'Yes', '0' => 'No'), array('id'=>'allow_download', 'onChange'=>'changeDownloadOption(this);')); ?>
        </div>

		<div class="row global_field" id="download_price_row">
            <?php echo $form->labelEx($model, 'download_price'); ?>
            <?php echo $form->textField($model, 'download_price', array('size' => 11, 'maxlength' => 11)); ?>
        </div>
		<?php endif;?>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'owner'); ?>
            <?php echo $form->textField($model, 'owner', array('size' => 60, 'maxlength' => 255)); ?>
        </div>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'copyright'); ?>
            <?php
            echo CHtml::dropDownList("AdminSongModel[copyright]", $model->copyright, array("Độc quyền", "Không độc quyền"));
            ?>
        </div>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'source'); ?>
            <?php echo $form->textField($model, 'source', array('size' => 60, 'maxlength' => 255)); ?>
        </div>

        <div class="row global_field">
            <?php echo $form->labelEx($model, 'source_link'); ?>
            <?php echo $form->textField($model, 'source_link', array('size' => 60, 'maxlength' => 255)); ?>
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
		        
        <div class="row global_field">
            <?php echo CHtml::label(Yii::t('admin', 'Lời bài hát'), ''); ?>
            <?php
            
            /* $this->widget('application.extensions.tinymce.ETinyMce', array(
                'model' => $model,
                'attribute' => 'lyrics',
                'width' => '75%',
            )); */

			$lyric = html_entity_decode($model->lyrics);
			echo CHtml::textArea('AdminSongModel[lyrics]', $lyric, array('cols' => 60, 'rows' => 15));

            ?>

        </div>

        <?php
        if (isset($model->id) && $this->cpId == 0 &&
                ($model->songstatus->convert_status == AdminSongStatusModel::CONVERT_FAIL ||
                $model->status == SongModel::ACTIVE )) :
            ?>
            <div class="row global_field">
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php
                if ($model->songstatus->convert_status == AdminSongStatusModel::CONVERT_FAIL) {
                    $songStatus = AdminSongModel::CONVERT_FAIL;
                    $status = array(
                        AdminSongModel::NOT_CONVERT => "Chưa convert",
                        AdminSongModel::CONVERT_FAIL => "Convert lỗi",
                    );
                }
                if ($model->status == SongModel::ACTIVE) {
                    $songStatus = AdminSongModel::ACTIVE;
                    $status = array(
                        AdminSongModel::ACTIVE => "Đã duyệt",
                        AdminSongModel::NOT_CONVERT => "Chưa convert",
                        AdminSongModel::WAIT_APPROVED => "Chờ duyệt"
                    );
                }
                echo CHtml::dropDownList("AdminSongModel[status]", $songStatus, $status)
                ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        <?php endif; ?>
        <?php
/*        $songMetaData = array();
        if($songMeta){
            foreach($songMeta as $meta){
                $songMetaData[$meta->meta_key] = $meta->meta_value;
            }
        }
        */?><!--
        <fieldset>
            <legend>SEO Meta Data</legend>
            <div class="row meta_field">
                <?php /*echo CHtml::label("Tiêu đề", ""); */?>
                <?php /*echo CHtml::textField("songMeta[title]", isset($songMetaData['title']) ? $songMetaData['title'] : "", array('style' => 'width:400px;', 'maxlength' => 100)); */?>
            </div>

            <div class="row meta_field">
                <?php /*echo CHtml::label("Từ khóa", ""); */?>
                <?php /*echo CHtml::textArea("songMeta[keywords]", isset($songMetaData['keywords']) ? $songMetaData['keywords'] : "", array('style' => 'width:400px;height: 100px;', 'maxlength' => 500)); */?>
            </div>
            <div class="row meta_field">
                <?php /*echo CHtml::label("Mô tả", ""); */?>
                <?php /*echo CHtml::textArea("songMeta[description]", isset($songMetaData['description']) ? $songMetaData['description'] : "", array('style' => 'width:400px;height: 100px;', 'maxlength' => 255)); */?>
            </div>
        </fieldset>-->

        <div class="row buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
        </div>
        <?php $this->endWidget(); ?>

    </div>

    <div class="form" id="fav-zone" style="display: none;">
    </div>
</div>
<script type="text/javascript">
    //<!--
    var checked_ok = 0;
    function validate_form()
    {
        var source_path = $('#tmp_source_path').val();
        var cats = $('#genre_ids').val();
<?php if ($model->isNewRecord): ?>
            if(!source_path || source_path == '' || source_path == 0){
                alert("Chưa upload file!");
                return false;
            }
<?php endif; ?>
        if(!cats || cats == null){
            alert("Chưa chọn thể loại!");
            return false;
        }

        var artists = [];
        var  i= 0;
        $("#artist_id input").each(function(){
            artists[i++] = $(this).val();
        });
        if(artists.length < 1){
            alert("Cần chọn ít nhất 1 ca sỹ");
            return false;
        }

<?php if ($model->isNewRecord): ?>
            var name = $('#AdminSongModel_name').val();
            if(!name || name == ''){
                alert("Hãy nhập tên bài hát!");
                return false;
            }
            var cp_id = $('#AdminSongModel_cp_id').val();
            if(!checked_ok)
                jQuery.ajax({
                    type: "POST",
                    url: "/admin.php?r=song/exits",
                    data: "name="+name+"&artist_name="+artist_name+"&cp_id="+cp_id,
                    cache:false,
                    success: function(html){
                        if(html){
                            jQuery('#jobDialog').html(html);
                            $("#jobDialog").css('height','auto');
                            $(".ui-dialog").css('top','150px');
                            $(".ui-dialog").css('position','fixed');
                        }else{
                            checked_ok++;
                            $("#admin-song-model-form").submit();
                        }
                }
            });
            if(checked_ok)
                return true;
            return false;
<?php endif; ?>

        return true;
    }

	var tags = [];
	tags = [<?php foreach ($this->tags as $tag):?>
	{id:<?php echo $tag->tag_id?>,name:'<?php echo $tag->tag_name?>'},
	<?php endforeach;?>];

	displayTag(tags,"#tags");
	
    //-->
</script>