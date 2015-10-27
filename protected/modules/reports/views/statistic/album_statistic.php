
<div class="content-body">
	<div class="wide form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'get',
	)); ?>
	
		<div class="row">
			<?php echo CHtml::label(Yii::t('admin','Name'), "") ?>
			<?php echo CHtml::textField("album_name",isset($options["album_name"])?$options["album_name"]:"",array('style' => 'width:200px')); ?>
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
		       		//'value'=>isset($_GET['report']['date'])?urldecode($options['date']):($fromDate. ' - ' .$toDate),
		        ));
		     ?>
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
				<th><?php echo Yii::t('admin','Ngày'); ?></th>
				<th><?php echo Yii::t('admin','Play web'); ?></th>
				<th><?php echo Yii::t('admin','Play wap'); ?></th>
				<th><?php echo Yii::t('admin','Total'); ?></th>
			</tr>
			<?php foreach ($data as $key => $value){?>
			<tr>
				<td ><?php echo $value['date']?></td>
				<td ><?php echo $value['played_count_web']?></td>
				<td ><?php echo $value['played_count_wap']?></td>
				<td ><?php echo $value['played_count']?></td>
			</tr>
			<?php }?>
		</table>
	</div>
</div>