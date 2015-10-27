<img width="100%" src="<?php echo Yii::app()->getModule('event')->_assetsUrl?>/images/tl_header.png" />
<div id="event">
<?php if ($rules) : ?>
    <hr style="color: #EEEEEE;">
	<div class="padL5"><?php echo $rules[0]->content ?></div>
	<div class="clear"></div>
	
<?php endif; ?>
	<div class="clear">
		<a class="btn-event" href="<?php echo yii::app()->createUrl('event/default/rules');?>">Thể Lệ</a>
		<a class="btn-event" href="<?php echo yii::app()->createUrl('/event/default/bonus');?>">DS Trúng Thưởng</a>
		<a class="btn-event-gray" href="<?php echo yii::app()->createUrl('/event');?>">Quay Lại</a>
	</div>
</div>