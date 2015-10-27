<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<div class="fl">
	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>160)); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php 
			$dataList = CHtml::listData(BaseAdminUserModel::model()->findAll('status=1'), 'id', 'username');
			echo $form->dropDownList($model,'created_by', $dataList, array('prompt'=>'Tất cả'));
		?>
	</div>	
	<div class="row">
		<label>Trạng thái</label>
		<?php 
			$dataList = array(
					-1=>'Tất cả',
					0=>'Chờ duyệt',
					1=>'Đã duyệt',
					2=>'Đã xóa'
			);
			echo $form->dropDownList($model,'status', $dataList);
		?>
	</div>	
</div>
<div class="fl">
	<div class="row">
		<?php echo $form->label($model,'genre_id'); ?>
        <?php
			$category = CMap::mergeArray(
							array(''=> Yii::t('admin','Tất cả')),
							CHtml::listData($categoryList, 'id', 'name')
						);
			echo CHtml::dropDownList("AdminAlbumModel[genre_id]", $model->genre_id, $category ) 
		?>
                  
                  		
	</div>
	<div class="row">
		<?php echo $form->label($model,'artist_name'); ?>
		<?php echo $form->textField($model,'artist_name',array('size'=>60,'maxlength'=>160)); ?>
	</div>	
	<div class="row">
		<label>Kiểu</label>
		<?php 
			$dataList = array(
					''=>'Tất cả',
					'album'=>'Album',
					'playlist'=>'Playlist',
					'user_playlist'=>'User Playlist',
			);
			echo $form->dropDownList($model,'type', $dataList);
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
                echo CHtml::dropDownList("AdminAlbumModel[cp_id]", $model->cp_id, $cp )
	        ?>
	    </div>
	    <div class="row">
			<?php echo $form->label($model,'description'); ?>
			<select name="description" id="description">
		    	<option value=""  <?php if($description=='') echo 'selected';?>>Tất cả</option>
		    	<option value="1" <?php if($description=='1') echo 'selected';?>>Có</option>
		    	<option value="2" <?php if($description=='2') echo 'selected';?>>Không</option>
		    </select>
		</div>
    </div>




	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->