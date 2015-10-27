<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="fl">
	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array()); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'artist_name'); ?>
		<?php echo $form->textField($model,'artist_name',array()); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'created_time'); ?>
        <?php
	       $this->widget('ext.daterangepicker.input',array(
	            'name'=>'AdminVideoModel[created_time]',
	       		'value'=>isset($_GET['AdminVideoModel']['created_time'])?$_GET['AdminVideoModel']['created_time']:'',
	        ));
	     ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php 
		$listData = CHtml::listData(AdminAdminUserModel::model()->findAll('status=1'), 'id', 'username');
		echo $form->dropDownList($model, 'created_by', $listData, array('prompt'=>'Tất cả'));
		?>
	</div>
</div>
<div class="fl">
	<div class="row">
		<?php echo $form->label($model,'cp_id'); ?>
	    <?php
	    	$cp = CMap::mergeArray(
            			array(''=> "Tất cả"),
                        			CHtml::listData($cpList, 'id', 'name')
							);
			if($this->cpId ==0)
				echo CHtml::dropDownList("AdminVideoModel[cp_id]", $model->cp_id, $cp );
			else
				echo CHtml::dropDownList("AdminVideoModel[cp_id]", $model->cp_id, $cp, array('disabled'=>'disabled') );

		?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'genre_id'); ?>
        <?php
				$category = CMap::mergeArray(
									array(''=> "Tất cả"),
									   CHtml::listData($categoryList, 'id', 'name')
									);
        $selectedGenre = isset($_GET['AdminVideoModel']['genre_id'])?$_GET['AdminVideoModel']['genre_id']:null;
                echo CHtml::dropDownList("AdminVideoModel[genre_id]", $selectedGenre, $category )
		?>

	</div>
	<?php $style = ($this->type == AdminVideoModel::ALL)?"display:block":"display:none"; ?>
    <div class="row" style="<?php echo $style?>">
		<?php echo $form->label($model,'status'); ?>
        <?php
               $status = array(
                                ''=> Yii::t('admin',"Tất cả"),
                                AdminVideoModel::NOT_CONVERT => Yii::t('admin',"Chưa convert"),
                                AdminVideoModel::WAIT_APPROVED=> Yii::t('admin',"Chờ duyệt"),
                                AdminVideoModel::ACTIVE=> Yii::t('admin',"Đã duyệt"),
                                AdminVideoModel::CONVERT_FAIL=> Yii::t('admin',"Convert lỗi"),
                                AdminVideoModel::DELETED=> Yii::t('admin',"Đã xóa"),
                            );
                echo CHtml::dropDownList("AdminVideoModel[status]",  $model->status, $status )
        ?>
	</div>

    <div style="display:block" class="row">
            <label for="lyrics">Lyric</label>
            <select id="lyrics" name="lyrics">
                <option value="2" <?php if($lyric==2) echo "selected";?>>Tất cả</option>
                <option value="1" <?php if($lyric==1) echo "selected";?>>Có</option>
                <option value="0" <?php if($lyric==0) echo "selected";?>>Không</option>
            </select>
        </div>

</div>

<div class="row buttons">
	<?php echo CHtml::submitButton('Search'); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->