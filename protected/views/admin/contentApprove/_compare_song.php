<style>
table tr td{
	padding: 5px;
}
</style>
<?php
if(count($dataDiff)>0): 
?>
<h3 style="margin: 10px 0;color: #F00;">Thông tin bài hát bị thay đổi</h3>
<table class="detail-view">
<tr class="odd"><td>#</td><td>Thông tin cũ</td><td>Thông tin mới</td><td>Field</td></tr>
<?php foreach ($dataDiff as $key => $value):?>
<tr class="even"><td><?php echo Yii::t('cpap', $key);?></td>
<td><?php echo $value['old'];?></td>
<td><?php echo $value['new'];?></td>
<td><?php echo $key;?></td></tr>
<?php endforeach;?>
</table>
<?php endif;?>