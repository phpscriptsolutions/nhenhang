<div class="content-body">
	<div class="form">
	
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'admin-radio-model-form',
		'enableAjaxValidation'=>false,
	)); ?>
	
	
		<?php echo $form->errorSummary($model); ?>
<table>
	<tr>
		<td valign="top">
		<?php //if(!$model->isNewRecord):?>
		<div class="row">
		<label>Icon cho Kênh</label>
		<div id="files-x">
		<?php
		/*$avatarPath = RadioModel::model()->getAvatarPath($model->id);
		if(!file_exists($avatarPath)){
			$fileSource = Yii::app()->params['storage']['radioDir'].DS.$model->id.".png";
			$pathUpload = _APP_PATH_.DS."data".DS."tmp".DS;
			$filePath = $pathUpload.$model->id.".png";
			$fileSystem = new Filesystem();
			$fileSystem->copy($fileSource, $filePath);
			AvatarHelper::processAvatar($model, $filePath);
		}*/
		$avatarUrl = RadioModel::model()->getAvatarUrl($model->id,'s3');?>
			<img width="150" id="image_uploaded" src="<?php echo $avatarUrl;//echo Common::getLinkIconsRadio($model->id, 'channel');?>?v=<?php echo time();?>" />
		</div>
		<?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
					array(
					        'id'=>'uploadFile',
					        'config'=>array(
					               'action'=>Yii::app()->createUrl('/upload/uploadFile', array('allowedExtensions'=>'jpg,jpeg,png')),
					               'allowedExtensions'=>array("png","jpg","jpeg"),//array("jpg","jpeg","gif","exe","mov" and etc...
					               'sizeLimit'=>100*1024*1024,// maximum file size in bytes
					               'minSizeLimit'=>1,// minimum file size in bytes
					               'onComplete'=>"js:function(id, fileName, responseJSON){
					        			if(responseJSON.success){
						 					$('#image_uploaded').attr('src','/data/tmp/'+responseJSON.filename);
					        				$('#tmp_file_path').attr('value',responseJSON.filename);	
					        			}else{
											alert(responseJSON.data);
										}
									}",
					              )
					));
		//echo CHtml::hiddenField("tmp_mp3_path", $mp3Tmp);
		?>
		<input type="hidden" name="tmp_file_path" id="tmp_file_path" value="" />
		</div>
		<?php //endif;?>
		<div class="row">
			<label for="AdminRadioModel_name">Tên kênh</label>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	
			<div class="row">
			<label for="AdminRadioModel_parent_id">Kênh cha</label>
			<?php
				if(!$model->isNewRecord){
					$allSubRadio = AdminRadioModel::model()->getAllSub($model->id);
				}else{
					$allSubRadio = array();
				}
				$meid = ($model->id>0)?$model->id:0;
				$items = CHtml::listData(AdminRadioModel::model()->findAll('status=1'), 'id', 'name');
				echo '<select name="AdminRadioModel[parent_id]" id="AdminRadioModel_parent_id">';
				echo '<option value="0">--None--</option>';
				foreach($items as $key => $item):
					if($key==$meid || in_array($key, $allSubRadio)){
						echo "<option disabled='disabled'>$item</option>";
					}else{
						if($model->parent_id==$key){
							$selected = "selected";
						}else{
							$selected="";
						}
						echo "<option value='$key' $selected>$item</option>";
					}
					
				endforeach;
				echo '</select>';
			?>
			<?php echo $form->error($model,'parent_id'); ?>
		</div>
			<div class="row">
			<label for="AdminRadioModel_type">Loại</label>
			<?php if($model->isNewRecord): ?>
				<?php 
				$data = array(
						'channel'=>'Channel',
						'artist'=>'Artist',
						'genre'=>'Genre',
						'playlist'=>'Playlist',
						'album'=>'Album',
				);
					echo $form->dropDownList($model, 'type', $data);
				?>
				<?php echo $form->error($model,'type'); ?>
			<?php else:?>
			<?php echo $model->type;?>
			<?php endif;?>
			</div>
			<div class="row">
			<label for="AdminRadioModel_time_point">Thời điểm</label>
			<?php 
			if($model->time_point && !is_array($model->time_point)){
				$timePoint = explode(',', $model->time_point);
			}else{
				$timePoint = array();
			}
			?>
			<div id="AdminRadioModel_time_point" style="margin-left: 120px">
				<input id="AdminRadioModel_time_point_0" value="1" type="checkbox" name="AdminRadioModel[time_point][]" <?php if(in_array(1, $timePoint)) echo 'checked="checked"';?>> <span>Buổi sáng</span><br>
				<input id="AdminRadioModel_time_point_1" value="2" type="checkbox" name="AdminRadioModel[time_point][]" <?php if(in_array(2, $timePoint)) echo 'checked="checked"';?>> <span>Buổi chiều</span><br>
				<input id="AdminRadioModel_time_point_2" value="3" type="checkbox" name="AdminRadioModel[time_point][]" <?php if(in_array(3, $timePoint)) echo 'checked="checked"';?>> <span>Buổi tối</span>
			</div>
			<?php echo $form->error($model,'time_point'); ?>
		</div>
	
			<div class="row">
			<label for="AdminRadioModel_day_week">Ngày trong tuần</label>
			<?php 
			if($model->day_week &&  !is_array($model->day_week)){
				$day_week = explode(',', $model->day_week);
			}else{
				$day_week = array();
			}
			?>
			<div id="AdminRadioModel_day_week" style="margin-left: 120px">
				<?php 
					$dayOfWeek = array(
							1=>'Thứ Hai',
							2=>'Thứ Ba',
							3=>'Thứ Tư',
							4=>'Thứ Năm',
							5=>'Thứ Sáu',
							6=>'Thứ Bảy',
							7=>'Chủ Nhật'
					);
					$dayToTime = !empty($model->day_to_time)?$model->day_to_time:array();
					if(!empty($dayToTime)){
						$dayToTime = json_decode($dayToTime);
						//echo '<pre>';print_r($dayToTime);
					}
				?>
				<?php foreach ($dayOfWeek as $key => $value):?>
				<input id="AdminRadioModel_day_week_<?php echo $key;?>" class="day_select" value="<?php echo $key;?>" type="checkbox" name="AdminRadioModel[day_week][]" <?php if(in_array($key, $day_week)) echo 'checked="checked"';?>> <span><?php echo $value;?></span><br>
				<div class="sub_time" id="day_<?php echo $key;?>" style="display: block">
					<ul>
						<li><input class="time_select" type="checkbox" name="AdminRadioModel[daytotime][<?php echo $key?>][]" value="1" <?php if(in_array(1, $dayToTime->$key)) echo 'checked="checked"';?>/><span>Sáng</span></li>
						<li><input class="time_select" type="checkbox" name="AdminRadioModel[daytotime][<?php echo $key?>][]" value="2" <?php if(in_array(2, $dayToTime->$key)) echo 'checked="checked"';?>/><span>Chiều</span></li>
						<li><input class="time_select" type="checkbox" name="AdminRadioModel[daytotime][<?php echo $key?>][]" value="3" <?php if(in_array(3, $dayToTime->$key)) echo 'checked="checked"';?>/><span>Tối</span></li>
					</ul>
				</div>
				<?php endforeach;?>
				<!--<input id="AdminRadioModel_day_week_0" class="day_select" value="1" type="checkbox" name="AdminRadioModel[day_week][]" <?php if(in_array(1, $day_week)) echo 'checked="checked"';?>> <span>Thứ Hai</span><br>
				<div class="sub_time" id="day_1" style="display: none">
					<ul>
						<li><input type="checkbox" name="" value="1" /><span>Sáng</span></li>
						<li><input type="checkbox" name="" value="2" /><span>Chiều</span></li>
						<li><input type="checkbox" name="" value="3" /><span>Tối</span></li>
					</ul>
				</div>
				<input id="AdminRadioModel_day_week_1" value="2" type="checkbox" name="AdminRadioModel[day_week][]" <?php if(in_array(2, $day_week)) echo 'checked="checked"';?>> <span>Thứ Ba</span><br>
				<input id="AdminRadioModel_day_week_2" value="3" type="checkbox" name="AdminRadioModel[day_week][]" <?php if(in_array(3, $day_week)) echo 'checked="checked"';?>> <span>Thứ Tư</span><br>
				<input id="AdminRadioModel_day_week_3" value="4" type="checkbox" name="AdminRadioModel[day_week][]" <?php if(in_array(4, $day_week)) echo 'checked="checked"';?>> <span>Thứ Năm</span><br>
				<input id="AdminRadioModel_day_week_4" value="5" type="checkbox" name="AdminRadioModel[day_week][]" <?php if(in_array(5, $day_week)) echo 'checked="checked"';?>> <span>Thứ Sáu</span><br>
				<input id="AdminRadioModel_day_week_5" value="6" type="checkbox" name="AdminRadioModel[day_week][]" <?php if(in_array(6, $day_week)) echo 'checked="checked"';?>> <span>Thứ Bảy</span><br>
				<input id="AdminRadioModel_day_week_6" value="7" type="checkbox" name="AdminRadioModel[day_week][]" <?php if(in_array(7, $day_week)) echo 'checked="checked"';?>> <span>Chủ Nhật</span><br>
				-->
			</div>
			<?php echo $form->error($model,'day_week'); ?>
		</div>
		<div class="row">
			<label for="AdminRadioModel_ordering">Thứ tự</label>
			<?php echo $form->textField($model,'ordering'); ?>
			<?php echo $form->error($model,'ordering'); ?>
		</div>
		<div class="row">
			<label for="AdminRadioModel_status">Trạng thái</label>
			<?php 
				$data = array(
						'1'=>'Kích hoạt',
						'0'=>'Không kích hoạt',
				);
				echo $form->dropDownList($model,'status',$data);
			?>
			<?php echo $form->error($model,'status'); ?>
		</div>
		<div class="row buttons">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create & Continue' : 'Save & Continue'); ?>
		</div>
			</td>
			<td valign="top" style="vertical-align: top">
				<div class="row">
					<div><strong>Thời tiết</strong></div>
					<div id="AdminRadioModel_weather">
						<?php 
						$wSelected = array();
						
						
						if(!$model->isNewRecord){
							$criteria = new CDbCriteria();
							$criteria->condition = "t.radio_id=:radio_id";
							$criteria->params = array(':radio_id'=>$model->id);
							$res = AdminRadioWeatherModel::model()->findAll($criteria);
							
							if($res){
								foreach ($res as $w){
									$wSelected[] = $w->weather_id;
								}
							}
						}
						$iddf = $model->isNewRecord?0:$model->id;
						$sql = "select DISTINCT weather_id
									from radio_weather
									where radio_id<>$iddf";
						$wNotAvail = Yii::app()->db->createCommand($sql)->queryAll();
						$vA = array();
						if($wNotAvail){
							foreach ($wNotAvail as $value){
								$vA[]=$value['weather_id'];
							}
						}
						$weather = AdminWeatherModel::model()->findAll();
						//$listData = CHtml::listD;ata($weather, 'code', 'description');
						?>
						<?php foreach ($weather as $w){?>
						<input <?php if(in_array($w->id, $vA)) echo 'disabled="disabled"'?> id="AdminRadioModel_weather_id_<?php echo $w->id?>" value="<?php echo $w->id?>" type="checkbox" name="AdminRadioModel[weather_id][]" <?php if(in_array($w->id, $wSelected)) echo 'checked="checked"';?>> <span><?php echo $w->description?>&nbsp;(<?php echo $w->vi_vn?>)</span><br>
						<?php }?>
					</div>
				</div>
			</td>
			</tr>
		</table>
	<?php $this->endWidget(); ?>
	
	</div><!-- form -->
</div>
<div id="arttt"></div>
<script>
function addCollection(){
	$.ajax({
        onclick: '$("#arttt").dialog("open"); return false;',
        url: "/admin.php?r=radio/channel/popupCollection&type=2&index=",
        cache:false,
        success: function(html) {
            $('#arttt').html(html);
        }
    });
}
$(function(){
	$(".day_select").live("click", function(){
		var value = $(this).val();
		var isCheck = $(this).attr('checked');
		/* if(isCheck=='checked'){
			$('#day_'+value).show();
		}else{
			$('#day_'+value).hide();
		} */
		if(isCheck=='checked'){
			$("#day_"+value).find("input.time_select").attr("checked", "checked");
		}else{
			$("#day_"+value).find("input.time_select").removeAttr("checked");
		}
	})
})
</script>