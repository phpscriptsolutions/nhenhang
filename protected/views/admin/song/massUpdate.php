<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('job','Cập nhật bài hát'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'600px',
                    'height'=>'auto',
                ),
                ));

?>

<div class="form" id="jobDialogForm">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'job-form',
    'enableAjaxValidation'=>true,
));
?>

        <div class="row ">
            <?php echo CHtml::label('Thể loại','song_genre_id',array('class'=>'fl lh35 pr10')); ?>
            <?php
                $category = CMap::mergeArray(
                                    array(''=> Yii::t('admin','Không thay đổi')),
                                       CHtml::listData($categoryList, 'id', 'name')
                                    );
                echo CHtml::dropDownList("song[genre_id]", "", $category )
             ?>

        </div>

        <?php /*
        <div class="row ">
            <?php echo CHtml::label('Ca sỹ','song_artist_id',array('class'=>'fl lh35 pr10')); ?>
				<?php
		             $this->widget('application.widgets.admin.ArtistAuto',
		                            array(
		                             'fieldId'=>'song[artist_id]',
		                             'fieldName'=>'song[artist_name]',
		                             'fieldIdVal'=>'',
		                             'fieldNameVal'=>Yii::t('admin','Không thay đổi'),
		                            )
		                        );

		        ?>
        </div>
        */?>
        <div class="row ">
            <?php echo CHtml::label('Chọn lọc','song_feature',array('class'=>'fl lh35 pr10')); ?>
            <?php
            	echo CHtml::checkBox("song[feature]");
             ?>
        </div>

<!--
        <?php $suggestLists = MainContentModel::getSuggestList();
        foreach($suggestLists as $key=>$val):
        ?>
        <div class="row ">
            <?php echo CHtml::label($val,'song_'.$key,array('class'=>'fl lh35 pr10')); ?>
            <?php
               $suggest = array(
                        1 => "Yes",
                        0 => "No",
                    );
                echo CHtml::dropDownList("song[$key]", 0, $suggest, array('class'=>'w200'));
             ?>
        </div>

        <?php endforeach; ?>
    -->
        <div>
            <div style="float:left;">
                <div class="row fll">
                    <?php echo CHtml::label('Tác quyền','song_',array('class'=>'fl lh35')); ?>
                    <?php
                       $copy = CHtml::listData($copyright0, 'id', 'appendix_no');
                        echo CHtml::dropDownList("copyright0", 0, $copy, array('style'=>'width:190px!important;','multiple'=>'multiple'));
                     ?>
                </div>
                <div class="row fll">
                    <?php echo CHtml::label('Quyền liên quan','song_',array('class'=>'fl lh35')); ?>
                    <?php
                       $copy = CHtml::listData($copyright1, 'id', 'appendix_no');
                        echo CHtml::dropDownList("copyright1", 0, $copy, array('style'=>'width:190px!important;','multiple'=>'multiple'));
                     ?>
                </div>
            </div>
            <div class="btn" style="float: left; width: 70px; height: 144px; margin-left: 5px; text-align: center;">
                <button onclick="addcopy1();" type="button" style="margin-top: 25px;">>></button>
                <button onclick="removecopy();" type="button"><<</button>
                <button onclick="up();" type="button">Up</button>
                <button onclick="down();" type="button">Down</button>
            </div>
            <div style="float: right;">
                <select size ="5" id="slcopy0" style="width: 190px!important; height: 72px!important;">
                    
                </select>
                <br/>
                <select size ="5" id="slcopy1" style="width: 190px!important; height: 72px!important;">
                    
                </select>
            </div>
            <input type="hidden" name="valcopy0" id="valcopy0" value=""/>
            <input type="hidden" name="valcopy1" id="valcopy1" value=""/>
        </div>

        <?php /*
        <div class="row ">
            <?php echo CHtml::label('Status','song_status',array('class'=>'fl lh35 pr10')); ?>
            <?php
               $status = array(
                                ''=> Yii::t('admin','Không thay đổi'),
                                AdminSongModel::NOT_CONVERT => "Chưa convert",
                                adminsongmodel::WAIT_APPROVED=> "Chờ duyệt",
                                AdminSongModel::ACTIVE=> "Đã duyệt",
                                AdminSongModel::CONVERT_FAIL=> "Convert lỗi",
                                AdminSongModel::FEATURE=>"Chọn lọc"
                            );
                echo CHtml::dropDownList("song[status]",  "", $status )
            ?>
        </div>
        */?>

    <div class="row buttons pl50">
        <?php echo CHtml::hiddenField("popup", "1") ?>
        <?php echo CHtml::hiddenField("conten_id",$massList )?>
        <?php echo CHtml::hiddenField("is_all",$isAll )?>
        <?php echo CHtml::hiddenField("type",$type )?>
        <?php echo CHtml::ajaxSubmitButton(Yii::t('admin','Save'),CHtml::normalizeUrl(array('song/massUpdate','render'=>false)),array('success'=>'js: function(data) {
                        //$.fn.yiiGridView.update("admin-song-model-grid");
                        window.location.reload( true );
                        $("#jobDialog").dialog("close");
                    }'),array('id'=>'closeJobDialog')); ?>
        <?php echo CHtml::button(Yii::t('admin','Cancel'),array("onclick"=>'$("#jobDialog").dialog("close");')) ?>
    </div>

<?php $this->endWidget(); ?>

</div>


<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>