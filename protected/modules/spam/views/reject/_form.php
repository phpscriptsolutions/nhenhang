<?php
Yii::app()->clientScript->registerScript('Reject', "
window.create = function(){
	jQuery.ajax({
	  'onclick':'$(\"#jobDialog\").dialog(\"open\"); return false;',
	  'url':'" . $this->createUrl("Reject/create") . "',
          'data': {phone: $('#phonenum').val() },
	  'type':'GET',
	  'cache':false,
	  'success':function(data){
	      $('.msg:first').html(data);
              $('.msg:first').css('color','red');
              $('.msg:first').css('font-size','15pt');
            }
	});
    return;
}
");
?>
<div class="content-body">
    <div class="form">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'spam-sms-reject-phone-model-form',
            'enableAjaxValidation' => false,
                ));
        ?>
        <p class="note">THÊM MỚI</p>
        
            <?php echo $form->errorSummary($model); ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'phone'); ?>
            <input type="text" id ="phonenum"/>
            <?php echo $form->error($model, 'phone'); ?>
        </div>
        <div class="row buttons">
        <?php echo CHtml::submitButton('Create', array('onclick' => 'create()')); ?>
        </div>
        <?php $this->endWidget(); ?>
        <p class="msg"></p>
    </div><!-- form -->
</div>