<?php
$this->breadcrumbs = array(
    'Spam Sms Reject Phone Models' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'Update',
);
//
//$this->menu = array(
//    array('label' => Yii::t('admin', 'Danh sách'), 'url' => array('index'), 'visible' => UserAccess::checkAccess('spam-SpamSmsRejectPhoneModelIndex')),
//    array('label' => Yii::t('admin', 'Thêm mới'), 'url' => array('create'), 'visible' => UserAccess::checkAccess('spam-SpamSmsRejectPhoneModelCreate')),
//    array('label' => Yii::t('admin', 'Thông tin'), 'url' => array('view', 'id' => $model->id), 'visible' => UserAccess::checkAccess('spam-SpamSmsRejectPhoneModelView')),
//    array('label' => Yii::t('admin', 'Sao chép'), 'url' => array('copy', 'id' => $model->id), 'visible' => UserAccess::checkAccess('spam-SpamSmsRejectPhoneModelCopy')),
//);
$this->pageLabel = Yii::t('admin', "Cập nhật SpamSmsRejectPhone") . "Id =" . $model->id;
?>


<div class="content-body">
    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'spam-sms-reject-phone-model-form',
            'enableAjaxValidation' => false,
                ));
        ?>

        <p class="note">Cập nhật</p>

<?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'phone'); ?>
            <?php echo $form->textField($model, 'phone', array('size' => 60, 'maxlength' => 200)); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>  
        <div class="row buttons">
        <?php echo CHtml::submitButton('Save'); ?>
        </div>
        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>