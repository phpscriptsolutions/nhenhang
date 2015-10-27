<?php
	$cs=Yii::app()->getClientScript();
	$cs->registerCoreScript('jquery');
	$cs->registerCoreScript('bbq');

	$cs->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/form.js");
	$baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
	$cssFile=$baseScriptUrl.'/styles.css';
	$cs->registerCssFile($cssFile);
	$cs->registerScriptFile($baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);
?>

<div class="content-body">
	<div class="form" id="basic-zone" >
	    <div class="row global_field upload-avatar" style="position: relative; left: 0; top: 0 ">
	    <?php echo CHtml::label(yii::t('admin','Ảnh đại diện'), ""); ?>
		    <div class="thumb pl130">
		    <?php
		    	if(isset($_POST['AdminVideoPlaylistModel']['source_path']) && $_POST['AdminVideoPlaylistModel']['source_path'] != 0){
		    		$url = Yii::app()->params['storage']['staticUrl']."/tmp/".$_POST['AdminVideoPlaylistModel']['source_path'];
		    	}else{
		    		$url = $model->getAvatarUrl();
		    	}
		        echo CHtml::image($url,"avatar",array("id"=>"img-display", "width"=>150,"height"=>150,"style"=>"margin-left:10px"));
		        $this->widget('ext.xupload.XUploadWidget', array(
		                            'url' => $this->createUrl("videoPlaylist/upload", array("parent_id" => 'tmp')),
		                            'model' => $uploadModel,
		                            'attribute' => 'file',
		                            'options' => array(
		                                           'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
		                                           						if(handler.response.error){
		                                           							alert(handler.response.msg);
		                                           						}else{
		                                           							$("#img-display").attr("src","'.Yii::app()->params['storage']['staticUrl']."/tmp/".'"+handler.response.name+"?rand='.time().'");
		                                                               		$("#AdminVideoPlaylistModel_source_path").val(handler.response.name);
		                                           						}

		                                                            }'
		                                        )
		        ));
		    ?>
		    </div>
	    </div>

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-video-playlist-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
            <?php echo $form->errorSummary($model); ?>	
	    <?php
	    	$fileTmp = 0;
	    	if(isset($_POST['AdminVideoPlaylistModel']['source_path'])){
	    		$fileTmp = $_POST['AdminVideoPlaylistModel']['source_path'];
	    	}
	    	echo CHtml::hiddenField("AdminVideoPlaylistModel[source_path]", $fileTmp);
	    ?>
		<div class="row global_field">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>160,'class'=>'txtchange')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>

		<div class="row global_field">
			<?php echo $form->labelEx($model,'url_key'); ?>
			<?php echo $form->textField($model,'url_key',array('size'=>60,'maxlength'=>160,'class'=>'txtrcv')); ?>
			<?php echo $form->error($model,'url_key'); ?>
		</div>

		<div class="row global_field">
			<?php echo $form->labelEx($model,'genre_id'); ?>
                        <?php echo CHtml::dropDownList("AdminVideoPlaylistModel[genre_id]", $model->genre_id, CHtml::listData($categoryList, 'id', 'name') ) ?>
			<?php echo $form->error($model,'genre_id'); ?>
		</div>
            
		<div class="row global_field">
                    <?php echo $form->labelEx($model,'artist_name'); ?>
                    <?php
                    $this->widget('application.widgets.admin.artist.Feild', array(
                        'fieldId' => 'AdminVideoPlaylistModel[artist_id]', 				               
                        'fieldIdVal' => $this->videoPlaylistArtist,
                            )
                    );
                    ?>
		</div>
		<div class="row global_field">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php
			    $this->widget('application.extensions.tinymce.ETinyMce',
	            				array(
	            					'name'=>'AdminVideoPlaylistModel[description]',
	            					'model'=>$model,
	            					'attribute'=>'description',
	            					'width'=>'75%',
	            				));
			 ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
		<?php if($model->isNewRecord):?>
		<div class="row meta_field">
			<?php echo $form->hiddenField($model, 'created_by', array('value'=>Yii::app()->user->id))?>
		</div>
		<?php endif;?>
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div><!-- form -->

	<div class="form" id="inlist-zone" style="display: none;">
	</div>
	<div class="form" id="fav-zone" style="display: none;">
	</div>
</div>
<script type="text/javascript">
    //<!--
    var checked_ok = 0;
    function validate_form()
    {
        var artists = [];
        var  i= 0;
        $("#AdminVideoPlaylistModel[artist_id] input").each(function(){
            artists[i++] = $(this).val();
        });
        if(artists.length < 1){
            alert("Cần chọn ít nhất 1 ca sỹ");
            return false;
        }

        return true;
    }
    //-->
</script>