<?php
Yii::app()->clientScript->registerScript('editCollection', "
window.changeCollectionMode = function(e)
{
    if($(e).val() == 0)
    {
        \$('#CollectionModel_sql_query').attr('disabled', true);
    }
    else
    {
        \$('#CollectionModel_sql_query').removeAttr('disabled');
    }
}
");

$action = Yii::app()->controller->getAction()->getId();
if($action == "create")
    Yii::app()->clientScript->registerScript('requireGenreId', "
        $('form').submit(function(){
            var genre = $('#genre_ids').val();
//            if(genre == null){
//                alert('Bạn phải chọn ít nhất 1 thể loại cho bộ sưu tập');
//                return false;
//            }        

        });
    ");


?>
<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'collection-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
        <p style="color:red;margin: 10px;"><?php if($msg != "") echo $msg?></p>
		<p class="note">Fields with <span class="required">*</span> are required.</p>
	
		<?php echo $form->errorSummary($model); ?>
		<?php if(!$model->isNewRecord):?>
		<div class="row">
		<label>Icon cho Radio</label>
		<div id="files-x">
			<img src="<?php echo Common::getLinkIconsRadio($model->id, 'collection');?>" />
		</div>
		<?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
					array(
					        'id'=>'uploadFile',
					        'config'=>array(
					               'action'=>Yii::app()->createUrl('/radio/default/uploadAvartar', array('id'=>$model->id, 'type'=>'collection')),
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
        <div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		</div>
	
        <div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php echo $form->textField($model,'code',array('size'=>20,'maxlength'=>20,"disabled" => $model->getIsNewRecord()?"":"disabled")); ?>
		</div>
	
        <div class="row">
			<?php echo $form->labelEx($model,'type'); ?>
            <?php echo $form->dropDownList($model,'type', CollectionModel::getTypeArray());?>
		</div>
	
        <div class="row">
			<?php echo $form->labelEx($model,'mode'); ?>
			<?php echo $form->dropDownList($model,'mode', CollectionModel::getModeArray(), array("onchange" => "changeCollectionMode(this)")); ?>
		</div>
        
        <div class="row">
			<label for="CollectionModel_mode"><?php echo 'SL hiển thị trên trang top'; ?></label>
			<?php echo $form->textField($model,'limit_items_toppage',array('size'=>2,'maxlength'=>2)); ?>
		</div>
        
        <div class="row">
			<?php echo $form->labelEx($model,'sql_query'); ?>
			<?php echo $form->textArea($model,'sql_query',array('rows'=>6, 'cols'=>50, "disabled" => ($model->mode == CollectionModel::MODE_AUTO)?"":"disabled")); ?>
		</div>
        <div class="row">
            <label>&nbsp;</label>
            <p><?php echo "Ex: ".json_encode(array("WHERE" => "true", "ORDER BY" => "id DESC")); ?></p>
        </div>
        
	
        <div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
		</div>
	
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>