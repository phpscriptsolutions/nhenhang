
<?php if(isset($data)):?>
<style>
table tr td{
	padding: 4px;
}
</style>
<div class="content-body grid-view">
    <div class="clearfix"></div>
    <table width="100%" class="items" border="1">
        <tr>
            <th colspan="5" style="height: 40px;">
                Danh sách <?php echo $content_type;?> không map được trong file <span style="color: red;"><?php echo $file_name;?></span> (file_id = <?php echo $file_id;?>)
            </th>
        </tr>
    	 <tr>
            <th>STT</th>
            <th>Tên <?php echo $content_type;?></th>
            <th>Ca sỹ</th>
            <th>Copyright_Code</th>
            <th>File ID</th>
    	</tr>
        <?php foreach($data as $item):?>
    	<tr>
            <td><?php $stt = (isset($item['stt']))?$item['stt']:0; echo $stt;?></td>
            <td><?php $name = (isset($item['name']))?$item['name']:0; echo $name;?></td>
            <td><?php $artist = (isset($item['artist']))?$item['artist']:0; echo $artist;?></td>
            <td><?php $copyright_code= (isset($item['copyright_code']))?$item['copyright_code']:0; echo $copyright_code;?></td>
            <td><?php $input_file = (isset($item['input_file']))?$item['input_file']:0; echo $input_file;?></td>
    	</tr>
        <?php endforeach;?>
    </table>
</div>
<?php else:?>
<div><br><b>Không có dữ liệu</b></div>
<?php endif;?>
