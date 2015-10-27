<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<div class="fl">
		<div class="row">
			<?php echo $form->label($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>30,'maxlength'=>160)); ?>
		</div>

	    <div class="row">
			<?php echo $form->label($model,'Nhạc chờ'); ?>
			<?php
	                $val = (isset($_GET['has_rbt']))? $_GET['has_rbt']:'';
	                echo CHtml::dropDownList('has_rbt', $val , array('' => '' ,'-1'=>'Chưa có nhạc chờ','1'=>'Đã có nhạc chờ'))?>
		</div>

	    <div class="row">
			<?php echo $form->label($model,'artist_key'); ?>
			<?php echo $form->textField($model,'artist_key',array('size'=>60,'maxlength'=>160)); ?>
		</div>
	</div>
	<div class="fl">
		<div class="row">
			<?php echo $form->label($model,'description'); ?>
			<select name="description" id="description">
		    	<option value=""  <?php if($description=='') echo 'selected';?>>Tất cả</option>
		    	<option value="1" <?php if($description=='1') echo 'selected';?>>Có</option>
		    	<option value="2" <?php if($description=='2') echo 'selected';?>>Không</option>
		    </select>
		</div>
		<div class="row global_field">
			<?php echo $form->labelEx($model, 'Thể loại'); ?>
			<?php
				$genres = CMap::mergeArray(
					array(""=>"Tất cả"),
					CHtml::listData($categoryList, 'id', 'name')
					);
				echo CHtml::dropDownList("AdminArtistModel[genre_id]", $model->genre_id, $genres);
			?>
	        <?php echo $form->error($model, 'genre_id'); ?>
	   	</div>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->