<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <div class="fl">
	    <div class="row">
	        <?php echo $form->label($model,'name'); ?>
	        <?php echo $form->textField($model,'name', array('size'=>30)); ?>
	    </div>
	    <div class="row">
			<?php echo $form->label($model,'max_bitrate'); ?>
			<?php
			 	$bitrate = array('128'=>'128','192'=>'192','256'=>'256','320'=>'320');
				echo $form->dropDownList($model, 'max_bitrate', $bitrate, array('prompt'=>'Tất cả'));
			?>
		</div>
		<div class="row">
            <label for="lyric">Lyric</label>
            <select id="lyric" name="lyric">
                <option value="2" <?php if($lyric==2) echo "selected";?>>Tất cả</option>
                <option value="1" <?php if($lyric==1) echo "selected";?>>Có</option>
                <option value="0" <?php if($lyric==0) echo "selected";?>>Không</option>
            </select>
        </div>
    </div>
    <div class="fl">
   	 	<div class="row">
	        <?php echo $form->label($model,'artist_name'); ?>
	        <?php echo $form->textField($model,'artist_name', array('size'=>30)); ?>
	    </div>
	    <div class="row">
	        <?php echo $form->label($model,'cp_id'); ?>
	        <?php #echo $form->textField($model,'cp_id', array('size'=>30)); ?>
	        <?php
	           $cp = CMap::mergeArray(
                                    array(''=> "Tất cả"),
                                       CHtml::listData($cpList, 'id', 'name')
                                    );
                echo CHtml::dropDownList("AdminSongModel[cp_id]", $model->cp_id, $cp )
	        ?>
	    </div>
	    <div class="row">
	        <?php echo $form->label($model,'genre_id'); ?>
	        <?php
				$category = CMap::mergeArray(
									array(''=> "Tất cả"),
									   CHtml::listData($categoryList, 'id', 'name')
									);
                echo CHtml::dropDownList("AdminSongModel[genre_id]", $model->genre_id, $category )
             ?>

	    </div>

    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->