<a href="<?php echo yii::app()->createUrl('/event/play');?>"><img width="100%" src="<?php echo Yii::app()->getModule('event')->_assetsUrl?>/images/bg_event.jpg" /></a>
<div id="event">
<?php $phone = yii::app()->user->getState('msisdn');?>
<?php if($phone && !$userSub):?>
<div class="clear"></div>
<div class="clear">
<a class="btn-event-pink" href="<?php echo yii::app()->createUrl('/event/register/registerNow');?>">Đăng Ký</a>
<a class="btn-event-gray" href="<?php echo yii::app()->createUrl('/event/play');?>">Tiếp Tục</a>
</div>
<?php elseif($phone && $userSub):?>
<div class="clear">
	<a class="btn-event-pink" href="<?php echo yii::app()->createUrl('/event/play');?>">Tham Gia Ngay</a>
</div>
<?php else:?>
<div class="clear">
<a class="btn-event-pink" href="<?php echo yii::app()->createUrl('/event/register');?>">Đăng Nhập</a>
</div>
<?php endif;?>

<div style="clear: both; height: 10px; margin-top: 10px;" ></div>
<p class="bold"><span class="red">Lưu ý:</span> Chỉ thuê bao đăng ký mới có cơ hội trúng giải.</p>
<div class="clear"></div>
	<div class="clear">
		<a class="btn-event" href="<?php echo yii::app()->createUrl('/event/default/bonus');?>">DS Trúng Thưởng</a>
		<a class="btn-event" href="<?php echo yii::app()->createUrl('/event/default/rules');?>">Thể Lệ</a>
		<a class="btn-event" href="<?php echo yii::app()->createUrl('/event/default/rank');?>">Top Điểm Cao</a>
	</div>
<div class="line"></div>
</div>