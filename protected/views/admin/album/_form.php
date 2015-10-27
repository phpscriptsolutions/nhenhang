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
		    	if(isset($_POST['AdminAlbumModel']['source_path']) && $_POST['AdminAlbumModel']['source_path'] != 0){
		    		$url = Yii::app()->params['storage']['staticUrl']."/tmp/".$_POST['AdminAlbumModel']['source_path'];
		    	}else{
		    		$url = $model->getAvatarUrl();
		    	}
		        echo CHtml::image($url,"avatar",array("id"=>"img-display", "width"=>150,"height"=>150,"style"=>"margin-left:10px"));
		        $this->widget('ext.xupload.XUploadWidget', array(
		                            'url' => $this->createUrl("album/upload", array("parent_id" => 'tmp')),
		                            'model' => $uploadModel,
		                            'attribute' => 'file',
		                            'options' => array(
		                                           'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
		                                           						if(handler.response.error){
		                                           							alert(handler.response.msg);
		                                           						}else{
		                                           							$("#img-display").attr("src","'.Yii::app()->params['storage']['staticUrl']."/tmp/".'"+handler.response.name+"?rand='.time().'");
		                                                               		$("#AdminAlbumModel_source_path").val(handler.response.name);
		                                           						}

		                                                            }'
		                                        )
		        ));
		    ?>
		    </div>
	    </div>

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-album-model-form',
		'enableAjaxValidation'=>false,
	)); ?>


		<?php echo $form->errorSummary($model); ?>
		<?php if(!$model->isNewRecord):?>
		<div class="row">
		<label>Icon cho App Radio</label>
		<div id="files-x">
			<img src="<?php echo Common::getLinkIconsRadio($model->id, 'album');?>" />
		</div>
		<?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
					array(
					        'id'=>'uploadFile',
					        'config'=>array(
					               'action'=>Yii::app()->createUrl('/radio/default/uploadAvartar', array('id'=>$model->id, 'type'=>'album')),
					               'allowedExtensions'=>array("png"),//array("jpg","jpeg","gif","exe","mov" and etc...
					               'sizeLimit'=>100*1024*1024,// maximum file size in bytes
					               'minSizeLimit'=>1,// minimum file size in bytes
					               'onComplete'=>"js:function(id, fileName, responseJSON){
					        			if(responseJSON.success){
						 					$('#files-x').html('<img src=\''+responseJSON.data+'\'/>');
					        				location.reload();
					        			}else{
											alert(responseJSON.data);
										}
									}",
					              )
					));
		?>
		</div>
		<?php endif;?>
		
	    <?php
	    	$fileTmp = 0;
	    	if(isset($_POST['AdminAlbumModel']['source_path'])){
	    		$fileTmp = $_POST['AdminAlbumModel']['source_path'];
	    	}
	    	echo CHtml::hiddenField("AdminAlbumModel[source_path]", $fileTmp);
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
			<?php //echo $form->textField($model,'genre_id'); ?>
	        <?php //echo CHtml::dropDownList("AdminAlbumModel[genre_id]", $model->genre_id, CHtml::listData($categoryList, 'id', 'name') ) ?>
            <select name="AdminAlbumModel[genre_id]" id="AdminAlbumModel_genre_id">
                <option value="">--Select genre--</option>
                <?php foreach($categoryList as $cat):?>
                    <option value="<?php echo $cat['id'];?>" <?php if($cat['id']==$model->genre_id) echo 'selected';?> <?php if($cat['parent_id']==0):?>disabled="disabled" <?php endif;?>><?php echo $cat['name'];?></option>
                <?php endforeach;?>
            </select>
			<?php echo $form->error($model,'genre_id'); ?>
		</div>

	    <div class="row global_field">
	        <?php echo $form->label($model,'cp_id'); ?>
	        <?php
		           $cp = CHtml::listData($cpList, 'id', 'name');
	               echo CHtml::dropDownList("AdminAlbumModel[cp_id]", $model->cp_id, $cp )
		        ?>
	    </div>
	    
		<div class="row global_field">
	        <?php echo $form->label($model,'type'); ?>
	        <?php
	        	$values = array(
	        			"album"=>"album",
	        			"playlist"=>"playlist",
	        			"user_playlist"=>"user_playlist",
	        	);
               echo $form->dropDownList($model,'type',$values);
	        ?>
	    </div>

		<div class="row global_field">
			<?php echo $form->labelEx($model,'artist_name'); ?>
            <?php
            $this->widget('application.widgets.admin.artist.Feild', array(
                'fieldId' => 'AdminAlbumModel[artist_id]', 				               
                'fieldIdVal' => $this->albumArtist,
                    )
            );
            ?>
		</div>


		<div class="row global_field">
			<?php echo $form->labelEx($model,'publisher'); ?>
			<?php echo $form->textField($model,'publisher',array('size'=>50,'maxlength'=>50)); ?>
			<?php echo $form->error($model,'publisher'); ?>
		</div>

		<div class="row global_field">
			<?php echo $form->labelEx($model,'published_date'); ?>
			<?php #echo $form->textField($model,'published_date'); ?>
			<?php
	        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
					    'name'=>'AdminAlbumModel[published_date]',
	        			'model'=>$model,
	        			'attribute'=>'published_date',
					    // additional javascript options for the date picker plugin
					    'options'=>array(
					        'showAnim'=>'fold',
	                        'changeMonth'=>true,
	                        'changeYear'=>true,
	                        'dateFormat'=>'yy-mm-dd',
	                        //'monthNamesShort'=>"['Một', 'Hai', 'Ba', 'Bốn', 'Năm', 'Sáu', 'Bảy', 'Tám', 'Chín', 'Mười', 'Mười một', 'Mười hai']",
	                        //'dayNamesMin'=>"['CN', 'Hai', 'Ba', 'Bốn', 'Năm', 'Sáu', 'Bảy']",
					    ),
					    'htmlOptions'=>array(
					        'style'=>'height:20px;'
					    ),
					));

			?>
			<?php echo $form->error($model,'published_date'); ?>
		</div>

		<?php //if($model->albumstatus->approve_status == AdminAlbumStatusModel::WAIT_APPROVED && $this->cpId == 0):?>
		<?php if($this->cpId == 0):?>
		<div class="row global_field">
			<?php echo $form->labelEx($model,'Trạng thái'); ?>			
			<?php
				$status = array(
								AdminAlbumStatusModel::WAIT_APPROVED=>Yii::t('admin','Chờ duyệt'),
								AdminAlbumStatusModel::APPROVED=>Yii::t('admin','Đã duyệt'),
								AdminAlbumStatusModel::REJECT=>Yii::t('admin','Đã xóa'),
							);
				echo CHtml::dropDownList("AdminAlbumModel[appstatus]", !$model->isNewRecord?AdminAlbumStatusModel::model()->findByPk($model->id)->approve_status:0, $status );
			?>
		</div>
		<?php endif; ?>

       <div class="row global_field">
            <?php echo CHtml::label(Yii::t('admin', 'Tag'), ''); ?>
            <div>
				<a href="<?php echo Yii::app()->createUrl('tag/index')?>" class="show-pop">Chọn tag từ danh sách</a>
		       	<div id="tags" class="artist-zone">
		       	</div>            
            </div>
        </div> 
        		
		<div class="row global_field">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php //echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
			<?php
			    $this->widget('application.extensions.tinymce.ETinyMce',
	            				array(
	            					'name'=>'AdminAlbumModel[description]',
	            					'model'=>$model,
	            					'attribute'=>'description',
	            					'width'=>'75%',
	            				));
			 ?>
			<?php echo $form->error($model,'description'); ?>
		</div>

		<?php
/*		$metaData = array();
		if(!empty($albumMeta)){
			foreach($albumMeta as $meta){
				if($meta) {
					$metaData[$meta->meta_key] = $meta->meta_value;
				}
			}
		}
		*/?><!--
		<fieldset>
			<legend>SEO Meta Data</legend>
			<div class="row meta_field">
				<?php /*echo CHtml::label("Tiêu đề", ""); */?>
				<?php /*echo CHtml::textField("albumMeta[title]", isset($metaData['title']) ? $metaData['title'] : "", array('style' => 'width:400px;', 'maxlength' => 100)); */?>
			</div>
			<div class="row meta_field">
				<?php /*echo CHtml::label("Từ khóa", ""); */?>
				<?php /*echo CHtml::textArea("albumMeta[keywords]", isset($metaData['keywords']) ? $metaData['keywords'] : "", array('style' => 'width:400px;height: 100px;', 'maxlength' => 500)); */?>
			</div>
			<div class="row meta_field">
				<?php /*echo CHtml::label("Mô tả", ""); */?>
				<?php /*echo CHtml::textArea("albumMeta[description]", isset($metaData['description']) ? $metaData['description'] : "", array('style' => 'width:400px;height: 100px;', 'maxlength' => 255)); */?>
			</div>
		</fieldset>-->

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
        $("#AdminAlbumModel[artist_id] input").each(function(){
            artists[i++] = $(this).val();
        });
        if(artists.length < 1){
            alert("Cần chọn ít nhất 1 ca sỹ");
            return false;
        }

        return true;
    }

	var tags = [];
	tags = [<?php foreach ($this->tags as $tag):?>
	{id:<?php echo $tag->tag_id?>,name:'<?php echo $tag->tag_name?>'},
	<?php endforeach;?>];

	displayTag(tags,"#tags");
	
    //-->
</script>