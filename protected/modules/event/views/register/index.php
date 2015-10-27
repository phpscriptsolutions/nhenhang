<div id="event">
<?php if($return['error']==2):?>
<div class="thank"></div>
<p class="red bold">Cảm ơn Quý Khách đã quan tâm tới chương trình!</p>
<p class="bold"><?php echo $return['msg'];?></p>
<p class="bold">Kính chúc Quý Khách một ngày lễ 8/3 vui vẻ!</p>
<div><a class="btn-event" href="/">Thoát</a></div>
<?php else:?>
<p>Quý Khách vui lòng nhập số điện thoại để tham gia chương trình</p>
<?php if($return['error']==1):?>
<p style="color: #ff0000"><?php echo $return['msg']?></p>
<?php endif;?>
<form action="" method="post">
<input type="text" name="phone" />
<div class="clear"></div>
<button type="submit" class="btn-event">Đăng Nhập</button>
</form>
<?php endif;?>
</div>