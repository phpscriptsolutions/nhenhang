<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
            ));
    ?>
    <div class="row">
<?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 50)); ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'channel'); ?>
        <?php
        $channel = Yii::app()->params['bannerChannel'];
        echo CHtml::dropDownList("BannerModel[channel]", 'web', $channel)
        ?>
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
    <div class="row buttons">
<?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->