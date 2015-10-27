<div class="wide form">
    <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
                ));
    ?>
    <div class="fl">
        <div class="row">
            <?php echo $form->label($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 160)); ?>
        </div>
    </div>
    <div class="fl">
        <div class="row">
            <?php echo $form->label($model, 'genre_id'); ?>
            <?php
                $category = CMap::mergeArray(
                    array('' => Yii::t('admin', 'Tất cả')), CHtml::listData($categoryList, 'id', 'name')
                );
                echo CHtml::dropDownList("AdminVideoPlaylistModel[genre_id]", $model->genre_id, $category);
            ?>
        </div>
    </div>
    <div class="fl">
        <div class="row">
            <?php echo $form->label($model, 'artist_name'); ?>
            <?php echo $form->textField($model, 'artist_name', array('size' => 60, 'maxlength' => 160)); ?>
        </div>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->