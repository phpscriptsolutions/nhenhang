
<div class="content-body">
	<div class="wide form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
	)); ?>
	<div class="fl">
		<div class="row">
			<?php echo CHtml::label(Yii::t('admin','Name'), "") ?>
			<?php echo CHtml::textField("video_name",isset($options["video_name"])?$options["video_name"]:"",array('style' => 'width:200px')); ?>
		</div>
		
		<div class="row">
			<?php echo CHtml::label(Yii::t('admin','Artist'), "") ?>
			<?php echo CHtml::textField("artist_name",isset($options["artist_name"])?$options["artist_name"]:"",array('style' => 'width:200px')); ?>
		</div>
	
		<div class="row">
			<?php echo CHtml::label(Yii::t('admin','Date'), "") ?>
			<div style="float: left">
			<?php 
		       $this->widget('ext.daterangepicker.input',array(
		            'name'=>'date',
		       		'value'=>isset($_GET['date'])?$_GET['date']:'',
		        ));
		     ?>
		     </div>
		</div>	
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

	<?php $this->endWidget(); ?>
	</div><!-- search-form -->
	<div class="content-body grid-view" style="overflow: auto; clear: both; padding-top: 20px;">
		<table width="100%" class="items">
			<tr>
				<th><?php echo Yii::t('admin','Name'); ?></th>
				<th><?php echo Yii::t('admin','VideoID'); ?></th>
				<th><?php echo Yii::t('admin','Artist'); ?></th>
				<th><?php echo Yii::t('admin','Play web'); ?></th>
				<th><?php echo Yii::t('admin','Play wap'); ?></th>
				<th><?php echo Yii::t('admin','Total'); ?></th>
				
			</tr>
			<?php foreach ($data as $key => $value){?>
			<tr>
				<td ><?php echo $value['video_name']?></td>
				<td ><?php echo $value['video_id']?></td>
				<td ><?php echo $value['artist_name']?></td>
				<td ><?php echo $value['played_count_web']?></td>
				<td ><?php echo $value['played_count_wap']?></td>
				<td ><?php echo $value['played_count']?></td>
			</tr>
			<?php }?>
		</table>
	</div>
</div>