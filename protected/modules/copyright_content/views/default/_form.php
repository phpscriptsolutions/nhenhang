<?php
/* @var $this DefaultController */
/* @var $model CopyrightSongFileModel */
/* @var $form CActiveForm */
?>

<div class="content-body">
    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'copyright-song-file-model-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data')
                ));
        ?>
        <?php echo $form->errorSummary($model); ?>
        <div class="row">
            <input type="radio" name="content_type" value="song" <?php echo ($model->content_type=='song')?'checked':'';?>> song<br>
            <input type="radio" name="content_type" value="video" <?php echo ($model->content_type=='video')?'checked':'';?>> video<br>
        </div>
        <div class="row">
            <input type="file" name="file" id="file" />
        </div>
		Template Import mẫu <a href="media/template.xls">download</a>
        <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Upload' : 'Save'); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>