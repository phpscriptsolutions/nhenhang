<?php
$this->pageTitle="Chia sẻ";
?>
<div id="event">
	<?php if($isShare):?>
	<p>Bạn đã thực hiện chia sẽ điểm trong ngày hôm nay rồi.</p>
	<?php else:?>
		<?php if($error==1):?>
		<p class="red">Nhập ít nhất 1 số điện thoại trước khi chia sẻ!</p>
		<?php elseif($isSend===0):?>
		<p class="red">Số điện thoại không hợp lệ hoặc không phải thuê bao Vinaphone!</p>
		<?php endif;?>
		<p>Nhập các số điện thoại muốn chia sẻ:</p>
		<form action="" method="post">
		<div style="text-align: center"><input style="width: 80%" type="text" name="phone_list" value="" /></div>
		<div class="clear" style="text-align: center"><button class="btn-event" type="submit" >Gửi chia sẻ</button></div>
		</form>
		<div>
		<span class="red">*Lưu ý:</span> Mỗi thuê bao cách nhau bằng một dấu phẩy. Quý khách được nhập tối đa 10 thuê bao Vinaphone.
		</div>
	<?php endif;?>
</div>