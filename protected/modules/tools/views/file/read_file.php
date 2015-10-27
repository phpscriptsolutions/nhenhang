<style>
.file_content{
	background: #F3F3F3;
	border: 5px solid #84B349;
	padding: 10px;
	height: 500px;
	overflow-y: scroll;
}
.file_header{
	border: 5px solid #DD0F49;
	background: #F1F1F1;
	padding: 5px;
	margin-bottom: 10px;
}
</style>
<?php if($header):?>
<div class="file_header"><?php echo $header;?></div>
<?php endif;?>
<?php if($html):?>
<div class="file_content">
	<?php echo $html;?>
</div>
<?php endif;?>
