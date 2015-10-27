<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <div class="fl">
	    <div class="row">
	        <?php echo $form->label($model,'name'); ?>
	        <?php 
	        echo CHtml::textField('AdminSongModel[name]', $_GET['AdminSongModel']['name']);
	        ?>
	    </div>
		<div class="row">
			<label>Nhạc sỹ</label>
	    	<select name="is_composer" id="is_composer">
	    		<option value=""  <?php if($is_composer=='') echo 'selected';?>>Tất cả</option>
	    		<option value="1" <?php if($is_composer=='1') echo 'selected';?>>Có</option>
	    		<option value="2" <?php if($is_composer=='2') echo 'selected';?>>Không</option>
	    	</select>
		</div>
		<div class="row">
			<?php echo $form->label($model,'max_bitrate'); ?>
			<?php
			 	$bitrate = array('128'=>'128','192'=>'192','256'=>'256','320'=>'320');
			 	echo CHtml::dropDownList('AdminSongModel[max_bitrate]', $_GET['AdminSongModel']['max_bitrate'], $bitrate, array('prompt'=>'Tất cả'));
			?>
		</div>
		<div class="row">
			<?php echo $form->label($model,'copyright'); ?>
			<!--<select name="copyright" id="copyright">
	    		<option value=""  <?php if($copyright=='') echo 'selected';?>>Tất cả</option>
	    		<option value="1" <?php if($copyright=='1') echo 'selected';?>>Có</option>
	    		<option value="2" <?php if($copyright=='2') echo 'selected';?>>Không</option>
	    	</select>-->
	    	<?php 
				$data = array(0=>'Tác Quyền', 1=>'Quyền Liên Quan');
				echo CHtml::dropDownList('ccp_type', $copyrightType, $data, array('prompt'=>'Tất cả'));
			?>
		</div>

	    <div class="row">
	        <?php echo $form->label($model,'artist_name'); ?>
	        <?php
	        	echo CHtml::textField('AdminSongModel[artist_name]', $_GET['AdminSongModel']['artist_name']);
	        ?>
	    </div>

        <?php /*
        <div class="row">
	        <?php echo $form->label($model,'artist_id');?>
	        <?php echo $form->textField($model,'artist_id', array('size'=>30)); ?>
                <p><i>(Gõ 0 để tìm những bài hát cần cập nhật ca sĩ)</i></p>
	    </div>
	    */?>


    </div>
    <div class="fl">
	    <div class="row">
	        <?php echo $form->label($model,'cp_id'); ?>
	        <?php #echo $form->textField($model,'cp_id', array('size'=>30)); ?>
	        <?php
	           $cp = CMap::mergeArray(
                                    array(''=> "Tất cả"),
                                       CHtml::listData($cpList, 'id', 'name')
                                    );
                echo CHtml::dropDownList("AdminSongModel[cp_id]", $_GET['AdminSongModel']['cp_id'], $cp )
	        ?>
	    </div>
	    <div class="row">
	        <?php echo $form->label($model,'genre_id'); ?>
	        <?php
				$category = CMap::mergeArray(
									array(''=> "Tất cả"),
									   CHtml::listData($categoryList, 'id', 'name')
									);
                echo CHtml::dropDownList("AdminSongModel[genre_id]", $_GET['AdminSongModel']['genre_id'], $category )
             ?>

	    </div>

	    <?php $style = ($this->type == AdminSongModel::ALL)?"display:block":"display:none"; ?>
	    <div class="row" style="<?php echo $style?>">
	        <?php echo $form->label($model,'status'); ?>
            <?php
               $status = array(
                                AdminSongModel::ACTIVE=> "Đã duyệt",
                            );
                echo CHtml::dropDownList("AdminSongModel[status]",  $_GET['AdminSongModel']['status'], $status )
            ?>
	    </div>

		<div class="row">
            <?php echo $form->label($model,'created_time'); ?>
            <?php
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'AdminSongModel[created_time]',
		       		'value'=>isset($_GET['AdminSongModel']['created_time'])?$_GET['AdminSongModel']['created_time']:'',
		        ));
		     ?>
        </div>

    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
		<?php echo CHtml::resetButton('Reset') ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->