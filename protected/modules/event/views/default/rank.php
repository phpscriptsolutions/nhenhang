<div id="event">
<a href="<?php echo yii::app()->createUrl('/event/play');?>"><img width="100%" src="<?php echo Yii::app()->getModule('event')->_assetsUrl?>/images/topdiemcao.jpg" /></a>
<div id="event">
<h3 class="qt_bg">Top điểm cao</h3>
<?php if($rank):?>
<table class="rank" rules="rows">
<tr>
	<th>Thuê bao</th>
	<th>Điểm</th>
	<th>Thời gian chơi</th>
	<th>Bộ câu hỏi</th>
</tr>
<?php foreach ($rank as $value):?>
<tr>
	<td><?php echo $value['user_phone']?></td>
	<td><?php echo $value['point']?></td>
	<td><?php echo $value['time_play'];?></td>
	<td><?php echo $value['thread_id'];?></td>
	</tr>
<?php endforeach;?>
</table>
<?php endif;?>
<div class="clear"></div>
<p class="red">Danh sách Top Điểm Cao tính đến ngày <?php echo date('Y-m-d', time() - 60 * 60 * 24);?></p>
<div class="clear">
		<a class="btn-event" href="<?php echo yii::app()->createUrl('event/default/rules');?>">Thể Lệ</a>
		<a class="btn-event" href="<?php echo yii::app()->createUrl('/event/default/bonus');?>">DS Trúng Thưởng</a>
		<a class="btn-event-gray" href="<?php echo yii::app()->createUrl('/event');?>">Quay Lại</a>
	</div>
</div>
</div>