<div id="vg_nav" class="sidebar none">
	<div class="top_nav">
		<a href="/" class="logo fll"><img
			src="<?php echo Yii::app()->request->baseUrl;?>/images/logo.png"
			alt="logo" /></a>
			<?php if($this->userPhone):?>
				<?php if(!$this->isSub):?>
					<a href="<?php echo Yii::app()->createUrl('/account/package', array('id'=>3));?>" class="register flr"><i class="vg_icon icon_register"></i>Đăng ký</a>
				<?php endif;?>
			<?php else:?>
				<a href="<?php echo Yii::app()->createUrl('/account/login')?>" class="register flr"><i class="vg_icon icon_register"></i>Đăng nhập</a>
			<?php endif;?>
	</div>
	<div class="vg_menu">
		<?php if ($this->userPhone):?>
		<p class="menu_title">Chào mừng <?php echo $this->userPhone; ?></p>
		<ul class="menu">
			<li><a href="<?php echo Yii::app()->createUrl('/playlist/myPlaylist')?>"><i class="vg_icon icon_list"></i>Playlist cá nhân</a></li>
			<li><a href="<?php echo Yii::app()->createUrl('/favourite/index')?>"><i class="vg_icon icon_like"></i>Yêu thích</a></li>
			<li><a href="<?php echo Yii::app()->createUrl('/account/index')?>"><i class="vg_icon icon_time"></i>Tài khoản</a></li>
		</ul>
		<?php endif;?>
		<!-- <ul class="menu">
			<li><a href="#"><i class="vg_icon icon_headphone"></i>Nhạc trong máy</a></li>
			<li><a href="#"><i class="vg_icon icon_time"></i>Nghe gần đây</a></li>
			<li><a href="#"><i class="vg_icon icon_list"></i>Playlist cá nhân</a></li>
			<li><a href="#"><i class="vg_icon icon_like"></i>Yêu thích</a></li>
			<li><a href="#"><i class="vg_icon icon_download"></i>Nhạc đã tải</a></li>
			<li><a href="#"><i class="vg_icon icon_rbt"></i>Nhạc chờ</a></li>
		</ul> -->
		<div style="background: #3C3C3C;height: 1px"></div>
		<p class="menu_title">Nhạc trực tuyến - Amusic</p>
		<ul class="menu">
			<!-- <li><a href="#"><i class="vg_icon icon_mnusearch"></i>Tìm kiếm</a></li> -->
			<li><a href="<?php echo Yii::app()->createUrl('/video')?>"><i class="vg_icon icon_video"></i>Video</a></li>
			<li><a href="<?php echo Yii::app()->createUrl('/bxh')?>"><i class="vg_icon icon_bxh"></i>Bảng xếp hạng</a></li>
                        <!-- 
			<li><a href="<?php //echo Yii::app()->createUrl('/news')?>"><i class="vg_icon icon_news"></i>Tin tức</a></li>
                        -->
			<li><a href="<?php echo Yii::app()->createUrl('/song')?>"><i class="vg_icon icon_mnusong"></i>Bài hát</a></li>
			<li><a href="<?php echo Yii::app()->createUrl('/album')?>"><i class="vg_icon icon_album"></i>Album</a></li>
			<li><a href="<?php echo Yii::app()->createUrl('/ajax/getPopup', array('route'=>'/song/list'));?>" class="opt_genre ajax_popup"><i class="vg_icon icon_genre"></i>Thể loại</a></li>
			<li><a href="/genre/collection/the-gioi-co-gi,612.html"><i class="vg_icon icon_global"></i>Thế giới có gì</a></li>
		</ul>
		<p class="menu_title">Thông tin dịch vụ</p>
		<ul class="menu">
			<li><a href="<?php echo Yii::app()->createUrl('/account/guide', array('id'=>7))?>"><i class="vg_icon icon_about"></i>Giới thiệu</a></li>
			<li><a href="<?php echo Yii::app()->createUrl('/account/package')?>"><i class="vg_icon icon_package"></i>Gói cước</a></li>
		</ul>
	</div>
</div>