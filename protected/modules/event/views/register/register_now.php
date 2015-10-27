<div id="event">
<?php 
if($register->errorCode==0 || $register->errorCode==404):?>
<div class="success"></div>
	<?php if($countPlayByDate>0)://da choi xong?>
	<p class="red" style="text-align: center">Chúc mừng Quý Khách đã đăng ký thành công!</p>
	<p class="bold" style="text-align: center;">Chúc Quý Khách nhận được giải độc đắc của chương trình!</p>
	<div class="clear" style="text-align: center;"><a class="btn-event" href="/">Thoát</a></div>
	<?php else:?>
	<p style="text-align: center">Chúc mừng Quý Khách đã đăng ký thành công!</p>
	<div class="clear" style="text-align: center;"><a class="btn-event" href="<?php echo Yii::app()->createUrl('/event/play')?>">Chơi ngay</a></div>
	<?php endif;?>
<?php else:?>
<p class="e_title">Cảm ơn Qúy Khách!</p>
<?php echo $register->msg;?>
<div class="clear"></div>
<a class="btn-event" href="<?php echo Yii::app()->createUrl('/event/play')?>">Tiếp tục</a>
<a href="<?php echo Yii::app()->createUrl('/event')?>" class="btn-event-gray">Thoát</a>
<?php endif;?>
</div>