<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-shortlink-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'prefix'); ?>
			<?php echo $form->textField($model,'prefix',array('size'=>60,'maxlength'=>255, 'class'=>'txtchange')); ?>
			<?php echo $form->error($model,'prefix'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'url_key'); ?>
			<?php echo $form->textField($model,'url_key',array('size'=>60,'maxlength'=>255, 'class'=>'txtrcv')); ?>
			<?php echo $form->error($model,'url_key'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'domain'); ?>
			<?php 
				echo $form->dropDownList($model, 'domain', array(
										'http://mobiclip.vn/music'=>'http://mobiclip.vn/music',
						));
			?>
			<?php echo $form->error($model,'domain'); ?>
		</div>
	
		<?php if(!$model->isNewRecord):?>
		<div class="row">
			<?php echo $form->labelEx($model,'shortlink');?>
			<div id="shortlink"><?php echo $model->shortlink;?></div>
			<?php echo $form->hiddenField($model,'shortlink',array('readonly'=>'readonly','style'=>'width: 500px','maxlength'=>500)); ?>
			<?php echo $form->error($model,'shortlink'); ?>
		</div>
		<?php endif;?>
		<div class="row">
			<?php echo $form->labelEx($model,'dest_link'); ?>
			<?php echo $form->textField($model,'dest_link',array('style'=>'width: 500px','maxlength'=>500)); ?>
			<?php echo $form->error($model,'dest_link'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php //echo $form->textField($model,'status'); ?>
			<?php echo $form->checkBox($model, 'status');?>
			<?php //echo CHtml::checkBox($name)?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	
			<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	</div><!-- form -->
</div>
<script>
jQuery(function(){
	var nice_url = function(el){
		str= el.value;
        str= str.toLowerCase();
        str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
        str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
        str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
        str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
        str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
        str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
        str= str.replace(/đ/g,"d");
        str= str.replace(/\W/g,"-");
        str= $("#AdminShortlinkModel_domain").val()+"/sl/"+str;
        $('#AdminShortlinkModel_shortlink').attr("value",str);
    }
	
	$('#AdminShortlinkModel_prefix').keypress(function(){
        var _self = this;
        setTimeout(function(){
        	nice_url(_self);
        },100);
    });

    
	/* $("#AdminShortlinkModel_prefix").live("keypress", function(event){
		var url_dest = $("#AdminShortlinkModel_domain").val();
		url_dest =url_dest+"/sl/";
		$("#AdminShortlinkModel_dest_link").attr("value", url_dest)
		setTimeout(function(){
			elva = $("#AdminShortlinkModel_prefix").val();
			nice_url(elva);
        },100);
        
		
		console.log(String.fromCharCode(event.which))
	}) */
})
</script>