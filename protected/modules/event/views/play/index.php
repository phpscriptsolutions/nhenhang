<div id="event">
<?php
if(YII_DEBUG) echo $completed;
if($completed>0):?>
	<?php if($sharePoint):?>
	<div class="conga"></div>
	<h3 class="red">BẠN THẬT XUẤT SẮC!</h3>
	<p>SỐ ĐIỂM HIỆN TẠI CỦA BẠN LÀ: <span class="red"><?php echo $point['total'];?> Điểm (<?php echo $point['time_play'];?>)</span></p>
		<?php if($userSub):?>
		<p>HÃY CHIA SẺ ĐIỀU NÀY CHO BẠN BÈ NÀO!!!</p>
		<div class="btn-gr">
			<a class="btn-share" href="<?php echo Yii::app()->createUrl('/event/play/share')?>"></a>
			<a class="btn-exit" href="/"></a>
		</div>
		<div class="top_player">
			<h3>________TOP ĐIỂM CAO NHẤT________</h3>
			<?php
			 	//$rank = GameEventReportDayModel::model()->getRankByThread($threadId);
			?>
			<?php if($rankThread):?>
			<?php foreach ($rankThread as $value):?>
			<p>Thuê bao <?php echo $value['user_phone']?>: <?php echo $value['total_point']?> điểm (<?php echo $value['time_play']?>)</p>
			<?php endforeach;?>
			<!-- <p><a href="<?php echo Yii::app()->createUrl('/event/default/rank')?>">Xem thêm</a></p>-->
			<?php endif;?>
		</div>
		<?php else://yeu cau dk khi chua dk?>
		<div class="line"></div>
		<p>Chỉ những thuê bao đăng ký mới có cơ hội sở hữu những phần quà hấp dẫn của chương trình!</p>
		<div class="clear">
			<a class="btn-event" href="<?php echo yii::app()->createUrl('/event/register/registerNow');?>">Đăng Ký</a>
			<a class="btn-event-gray" href="/">Thoát</a>
		</div>
		<?php endif;?>
	<?php else:?>
	<p><?php echo $msg;?></p>
	<?php endif;?>
<?php else:?>
<div>
<div class="clear">
<p style="color: #F00;font-weight: bold;font-size: 14px;text-align: center">"VUI CÙNG CHACHA - NHẬN QUÀ NHƯ Ý"</p>
<p style="color: #777; font-size: 12px;text-align: center">Trả lời câu hỏi để có cơ hội rinh quà độc đắc nhé!</p>
</div>
</div>
	<!-- 3 -->
	<?php if($question && $answer):?>
		<form action="<?php echo Yii::app()->createUrl('/event/play/answer');?>" method="post">
			<h3 class="qt_bg"><span>Câu hỏi <?php echo $_SESSION['count'];?>: </span><?php echo $question->name;?></h3>
			<div class="qt_list">
			<?php foreach ($answer as $key => $value):?>
			<p><input type="radio" id="<?php echo $value->id;?>" name="answer" value="<?php echo $value->id;?>" /> <label for="<?php echo $value->id;?>"><?php echo $value->name;?></label></p>
			<?php endforeach;?>
			</div>
		
		<input type="hidden" name="askid" value="<?php echo $question->id;?>" />
		<div class="clear">
		<?php if(isset($_GET['notrep']) && $_GET['notrep']==1 && isset($_GET['askid']) && $_GET['askid']>0):?>
		<p class="red">Bạn phải chọn câu trả lời để chơi tiếp!</p>
		<?php endif;?>
		<p></p></div>
		
		<button type="submit" class="btn-tiep"></button>
		</form>
	<?php endif;?>
	<!-- 3 -->
<?php endif;?>
</div>