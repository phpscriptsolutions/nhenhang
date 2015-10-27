<?php

$this->menu=array(
	array('label'=>yii::t('admin', 'Kết thúc'), 'url'=>array('video/returnApproved')),
);
$this->pageLabel = Yii::t("admin","Duyệt video {name}",array('{name}'=>": ".$video->name));


$this->widget('zii.widgets.CDetailView', array(
	'data'=>$video,
	'attributes'=>array(
		'id',
		'code',
		'name',
		'url_key',
		'duration',
		'song_id',
		'genre_id',
		'composer_id',
		'artist_name',
		'created_by',
		'approved_by',
		'updated_by',
		'cp_id',
		'source_path',
		'download_price',
		'listen_price',
		'max_bitrate',
		'created_time',
		'updated_time',
		'sorder',
		'status',
	),
)); ?>
<form method="post" class="approve-form">
<?php if(!empty($userSession) && $userSession->id != $this->userId ):?>
	<div class="wrr">
		<?php echo Yii::t("admin", "Video này đang được duyệt bởi {user} Từ {time}",array('{user}'=>"<b>".$userSession['username']."</b>",'{time}'=>"<b>".date("h:i:s d-m-Y",strtotime($checkout['created_time']))."</b>"))?>
		<input type="submit" name="next" value="<?php echo yii::t("admin","Bài tiếp theo")?>" />
	</div>
<?php else:?>
	<input type="submit" name="approved" value="<?php echo yii::t("admin","Duyệt")?>" />
	<?php /*<input type="submit" name="reject" value="<?php echo yii::t("admin","Từ chối")?>" /> */?>
	<?php
		echo CHtml::link(Yii::t("admin","Từ chối"), '#', array(
		   'onclick'=>'$("#reason-reject").dialog("open"); return false;',
		   'class'=>'button ui-corner-all'
		));
	?>
	<input type="submit" name="next" value="<?php echo yii::t("admin","Bỏ qua")?>" />
<?php endif;?>
</form>

<?php
	$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
				    'id'=>'reason-reject',
				    'options'=>array(
				        'title'=>'Lý do từ chối (xóa) video?',
				        'autoOpen'=>false,
						'modal'=>'true',
	                    'width'=>'400px',
	                    'height'=>'auto',
				    ),
				));

	$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl('/video/Approved',array('id'=>$video->id)),
		'method'=>'post',
		'htmlOptions'=>array(),
	));
    echo CHtml::textArea("reason","Chất lượng kém",array('class'=>'w300 h150'));
    echo '<div class="row buttons pl50">';
    echo CHtml::hiddenField("reject",'1');
    echo '<input type="submit" name="reject" value="'.Yii::t('admin','Từ chối').'" />';
   	echo " ";
    echo CHtml::button(Yii::t('admin','Đóng lại'),
    					array(
    						"onclick"=>'$("#reason-reject").dialog("close");',
    						"class"=>"ui-button ui-widget ui-state-default ui-corner-all"
    					));
    echo '</div>';
	$this->endWidget();

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

