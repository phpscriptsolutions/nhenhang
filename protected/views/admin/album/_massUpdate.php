<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('job','Cập nhật album'),
                    'autoOpen'=>true,
                    'modal'=>'true',
                    'width'=>'400px',
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
            <?php echo CHtml::label('Genre','album_genre_id',array('class'=>'fl lh35 pr10')); ?>
            <?php
                $category = CMap::mergeArray(
                                    array(''=> Yii::t('admin','Không thay đổi')),
                                       CHtml::listData($categoryList, 'id', 'name')
                                    );
                echo CHtml::dropDownList("album[genre_id]", "", $category ) 
             ?>
                            
        </div>
        
        <div class="row ">
            <?php echo CHtml::label('Artist','album_artist_id',array('class'=>'fl lh35 pr10')); ?>
            <?php
               $artist = CMap::mergeArray(
                                    array(''=> Yii::t('admin','Không thay đổi')),
                                       CHtml::listData($artistList, 'id', 'name')
                                    );
                echo CHtml::dropDownList("album[artist_id]", "", $artist, array('class'=>'w200'));
             ?>
        </div>
        
        <div class="row ">
            <?php echo CHtml::label('Chọn lọc','album_status',array('class'=>'fl lh35 pr10')); ?>
            <?php 
            	echo CHtml::checkBox("album[feature]");
            ?>
        </div>
    
    <?php $suggestLists = MainContentModel::getSuggestList();
        foreach($suggestLists as $key=>$val):
        ?>
        <div class="row ">
            <?php echo CHtml::label($val,'album_'.$key,array('class'=>'fl lh35 pr10')); ?>
            <?php
               $suggest = array(
                        1 => "Yes",
                        0 => "No",
                    );     
                echo CHtml::dropDownList("album[$key]", 0, $suggest, array('class'=>'w200'));
             ?>
        </div>
    
        <?php endforeach; ?>
        
 
    <div class="row buttons pl50">
        <?php echo CHtml::hiddenField("popup", "1") ?>
        <?php echo CHtml::hiddenField("conten_id",$massList )?>
        <?php echo CHtml::hiddenField("is_all",$isAll )?>
        <?php echo CHtml::hiddenField("type",$type )?>
        <?php echo CHtml::ajaxSubmitButton(Yii::t('admin','Save'),CHtml::normalizeUrl(array('album/massUpdate','render'=>false)),array('success'=>'js: function(data) {
                        $.fn.yiiGridView.update("admin-album-model-grid");
                        $("#jobDialog").dialog("close");
                    }'),array('id'=>'closeJobDialog')); ?>
        <?php echo CHtml::button(Yii::t('admin','Cancel'),array("onclick"=>'$("#jobDialog").dialog("close");')) ?>
    </div>
 
<?php $this->endWidget(); ?>
 
</div>


<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>