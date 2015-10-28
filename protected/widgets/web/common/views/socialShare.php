<!-- facebook share -->
<!--<span class="facebookshare">
	<?php
/*	$this->widget("application.widgets.web.common.FBShare", array(
		"url" =>  $this->url,
		"name" => $this->name,
		"imgsrc" =>$this->imgsrc,
		"title" => $this->title,
	));
	*/?>
</span>-->
<!-- end facebook share -->

<?php /*
<!-- Tweet Button -->
<a href="http://twitter.com/share" class="padL1" data-count="none" data-via="YOUR-TWITTER-USERNAME" title="Chia sẻ lên Twitter" target="_blank">
	<img height="24px" width="24px" src="/images/share_twitter.png" />
</a>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<!-- / Tweet Button -->
*/?>
<!-- Zingme -->
<!--<a class="" type="icon-1" name="zm_share" title="Chia sẻ lên Zing Me">
	<img height="24px" width="24px" src="/images/share_zing.png" />
</a>
<script src="http://wb.me.zing.vn/index.php?wb=LINK&t=js&c=share_button" type="text/javascript"></script>-->
<!-- / Zingme -->

<!--<a href="https://plus.google.com/share?url=<?php /*echo $this->url; */?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
	<img src="/images/share_google.png" alt="Share on Google+"/>
</a>-->
<span class="separator"></span>
<span class="facebooklikebutton">
<?php
	$this->widget("application.widgets.web.common.FBLike", array(
		"url" => $this->url,
	));
	?>
</span>