<script>
function findItem(){
	$.ajax({
		onclick: '$("#find_artist").dialog("open"); return false;',
		url: '<?php echo Yii::app()->createUrl('ads/AdsSource/popupList')?>',
		//data: "type=" + type,
		beforeSend: function(){
			//$("#loading").html("<img src='".Yii::app()->theme->baseUrl."/ajax-loader.gif' />")
			$("#load").html("<img width='20' src='<?php echo Yii::app()->theme->baseUrl;?>/images/ajax-loader.gif' />")
		},
		success: function(html) {
			$("#load").html("");
			$('#jobDialog').html(html);
		}
	});
}
function putItem(value,name){
	$("#AdminAdsMarketingModel_code").attr("value",name);
}
</script>
<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-ads-marketing-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
	
			<div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class'=>'txtchange')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'url_key'); ?>
			<?php echo $form->textField($model,'url_key',array('size'=>60,'maxlength'=>255, 'class'=>'txtrcv')); ?>
			<?php echo $form->error($model,'url_key'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php echo $form->textField($model,'code',array('readonly'=>'readonly','size'=>60,'maxlength'=>100, 'style'=>'width: 200px')); ?>
            <a href="javascript:void(0)" onclick='findItem();'>
            	<img width="20" src="<?php echo Yii::app()->theme->baseUrl?>/images/find.png" />
            </a>
            <span id="load"></span>
			<?php echo $form->error($model,'code'); ?>
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'action'); ?>
			<?php 
				$data = array('not_subscribe'=>'Không đăng ký', 'subscribe'=>'Đăng ký');
				echo $form->dropDownList($model, 'action', $data);
			?>
			<?php echo $form->error($model,'action'); ?>
			<div id="package">
			<?php echo $form->labelEx($model,'package_id', array('style'=>'margin-left: 10px; width: 60px;')); ?>
			<?php 
				$data = CHtml::listData(PackageModel::model()->findAll(), 'id', 'name');
				echo $form->dropdownList($model,'package_id',$data, array('prompt'=>'---Chọn gói cước---'));
			?>
			</div>
			
		</div>
	
			<div class="row">
			<?php echo $form->labelEx($model,'domain'); ?>
			<?php 
				//$data = array('http://mobiclip.vn/music'=>'http://mobiclip.vn/music');
				$data = array('http://192.168.42.89:3131'=>'http://192.168.42.89:3131');
				echo $form->dropDownList($model, 'domain', $data);
			?>
			<?php echo $form->error($model,'domain'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'dest_link'); ?>
			<?php echo $form->textField($model,'dest_link',array('style'=>'width: 500px;','maxlength'=>255)); ?>
			<?php echo $form->error($model,'dest_link'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'short_link'); ?>
			<?php echo $form->textField($model,'short_link',array('style'=>'width: 500px;','maxlength'=>255,'readonly'=>'readonly')); ?>
			<?php echo $form->error($model,'short_link'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
	
		<div class="row">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php 
				$data = array(AdsMarketingModel::ACTIVE=>'Kích hoạt',
						AdsMarketingModel::DEACTIVE=>'Chưa kích hoạt'
				);
				echo $form->dropDownList($model,'status',$data);
			?>
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
        str= $("#AdminAdsMarketingModel_domain").val()+"/sl/"+str;
        $('#AdminAdsMarketingModel_short_link').attr("value",str);
    }
	
	$('#AdminAdsMarketingModel_name').keypress(function(){
        var _self = this;
        setTimeout(function(){
        	nice_url(_self);
        },100);
    });
	$('#AdminAdsMarketingModel_url_key').keypress(function(){
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