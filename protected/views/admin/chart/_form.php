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


?>
<div class="content-body">
	<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'collection-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
            <p style="color:red;margin: 10px;"><?php echo !empty($msg)?$msg:"";?></p>
		<p class="note">Fields with <span class="required">*</span> are required.</p>

		<?php echo $form->errorSummary($model); ?>

        <div class="row">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		</div>

        <div class="row">
			<?php echo $form->labelEx($model,'code'); ?>
			<?php echo $form->textField($model,'code',array('size'=>50,'maxlength'=>50,"disabled" => $model->getIsNewRecord()?"":"disabled")); ?>
		</div>

        <div class="row">
			<?php echo $form->labelEx($model,'type'); ?>
            <?php
            $types = array(
            		'song'  => Yii::t('admin', 'Song'),
            		'video' => Yii::t('admin', "Video"),
            		'album' => Yii::t('admin', "Album"),
            );
            	echo $form->dropDownList($model,'type', $types);
            ?>
		</div>

        <div class="row">
			<?php echo $form->labelEx($model,'cc_genre'); ?>
            <?php
            $cc_genre = array(
            		'VN'  => Yii::t('admin', 'Việt Nam'),
            		'KOR' => Yii::t('admin', "Hàn Quốc"),
            		'QTE' => Yii::t('admin', "Âu Mỹ"),
            );
            	echo $form->dropDownList($model,'cc_genre', $cc_genre);
            //$categoryList = AdminGenreModel::model()->gettreelist(2,false,0,1,false,'all');
            ?>
            <!--<select name="CollectionModel[cc_genre]" id="CollectionModel_cc_genre">
                <option value="">--Select genre--</option>
                <?php /*foreach($categoryList as $cat):*/?>
                    <option value="<?php /*echo $cat['id'];*/?>" <?php /*if($cat['id']==$model->cc_genre) echo 'selected';*/?> <?php /*if($cat['parent_id']==0):*/?>disabled="disabled" <?php /*endif;*/?>><?php /*echo $cat['name'];*/?></option>
                <?php /*endforeach;*/?>
            </select>-->
		</div>

        <div class="row">
			<?php echo $form->labelEx($model,'mode'); ?>
			<?php echo $form->dropDownList($model,'mode', CollectionModel::getModeArray(), array("onchange" => "changeCollectionMode(this)")); ?>
		</div>

        <div class="row">
			<?php echo $form->labelEx($model,'Tuần'); ?>
			<?php
				$curentWeek = date("W");
				$year =date("Y");
				$week_count = date('W', strtotime($year . '-12-31'));
				if ($week_count == '01'){
					$week_count = date('W', strtotime($year . '-12-24'));
				}
				for($i=($curentWeek-1); $i<=$week_count;$i++){
					$data[$i] = "Tuần $i Từ-".date("Y-m-d", Utils::getFirstDayOfWeek($year,$i));
				}
				if($model->isNewRecord) $model->cc_week_num = $curentWeek-1;
				echo $form->dropDownList($model,'cc_week_num', $data);
			?>
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