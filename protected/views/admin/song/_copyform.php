<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/admin/common.js"); ?>
<div class="form">
    <div class="row upload-file">
    <?php
        $this->widget('ext.xupload.XUploadWidget', array(
                            'url' => $this->createUrl("song/upload", array("parent_id" => 'tmp')),
                            'model' => $uploadModel,
                            'attribute' => 'file',
                            'options' => array(
                                           'onComplete' => 'js:function (event, files, index, xhr, handler, callBack) {
                                                               $("#XUploadForm_form").remove();
                                                               //alert(files[index].name);
                                                               $("#AdminSongModel_source_path").val(handler.response.name);
                                                            }'
                                        )
        ));
    ?>
    </div>

	<?php $form=$this->beginWidget('CActiveForm', array(
	    'id'=>'admin-song-model-form',
	    'enableAjaxValidation'=>false,
	));
	 ?>



	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    <?php echo CHtml::hiddenField("AdminSongModel[source_path]", 0) ?>
    <?php /*
	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code'); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>
	*/ ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class'=>'txtchange')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url_key'); ?>
		<?php echo $form->textField($model,'url_key',array('size'=>60,'maxlength'=>255,'class'=>'txtrcv')); ?>
		<?php echo $form->error($model,'url_key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Thể loại'); ?>
		<?php //echo $form->textField($model,'genre_id'); ?>
        <?php
            echo CHtml::dropDownList("AdminSongModel[genre_id]", $model->genre_id, CHtml::listData($categoryList, 'id', 'name') )
        ?>

		<?php echo $form->error($model,'genre_id'); ?>
	</div>

<?php /*
	<div class="row">
		<?php echo $form->labelEx($model,'artist_id'); ?>
		<?php //echo $form->textField($model,'artist_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'artist_id'); ?>
	</div>
*/
?>

	<div class="row">
		<?php echo $form->labelEx($model,'Ca sỹ'); ?>
		<?php //echo $form->textField($model,'artist_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php
             $this->widget('application.widgets.admin.ArtistFeild',
                            array(
                             'fieldId'=>'AdminSongModel[artist_id]',
                             'fieldName'=>'AdminSongModel[artist_name]',
                             'fieldIdVal'=>$model->artist_id,
                             'fieldNameVal'=>$model->artist_name
                            )
                        );

        ?>

		<?php echo $form->error($model,'artist_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Sáng tác'); ?>
		<?php
		     $composer_name = ($model->composer_id)?AdminArtistModel::model()->findByPk($model->composer_id)->name:null;
             $this->widget('application.widgets.admin.ArtistFeild',
                            array(
                             'fieldId'=>'AdminSongModel[composer_id]',
                             'fieldName'=>'AdminSongModel[composer_name]',
                             'fieldIdVal'=>$model->composer_id,
                             'fieldNameVal'=> $composer_name,
                             'dialogZone'=>'composer-zone'
                            )
                        );

        ?>
		<?php echo $form->error($model,'artist_name'); ?>
	</div>

    <div class="row global_field">
        <?php echo $form->labelEx($model, 'source'); ?>
        <?php echo $form->textField($model, 'source', array('size' => 60, 'maxlength' => 255)); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'Lời bài hát'); ?>
		<?php
		    $songExtra = AdminSongExtraModel::model()->findByPk($model->id);
            $lyrics = ($songExtra)?($songExtra->lyrics) :"";
		    echo CHtml::textArea('AdminSongModel[lyrics]',$lyrics,array('cols'=>50,'rows'=>10));
		 ?>

	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('onclick'=>'return checkSubmit()')); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
//<!--
function checkSubmit()
{
    var val = $('#AdminSongModel_source_path').val();
    if(val == 0){
        alert('Chưa upload file');
        return false;
    }
    return true;
}
//-->
</script>