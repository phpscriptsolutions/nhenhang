<h3>Tìm thấy <?php echo count($result);?> bài hát có từ 2 mã bản quyền.</h3>
<button type="button" id="run" onclick="Run();">Run</button>
<div id="loading-song" style="display: none;"><span class="loading-import"><img src="<?php echo Yii::app()->theme->baseUrl ?>/images/ajax-loader-top-page.gif"></span></div>
<div id="result" style="height: 300px; overflow: auto;border: 1px solid #ccc;"></div>
<style>
table{
	margin-top: 10px;
	width: 100%;
}
table tr td{
	border: 1px solid #ccc;
	padding: 5px;
}
</style>
<?php
if($result){
	echo '<table>';
	echo '<tr>
			<td>song_id</td>
			<td>ccp</td>
			<td>total</td>
		  </tr>';
	foreach ($result as $value){
		echo '<tr>
				<td>'.$value['song_id'].'</td>
				<td>'.$value['cps'].'</td>
				<td>'.$value['total'].'</td>
			  </tr>';
	}
	echo '</table>';
}
?>

<script>
function Run()
{
	$("#loading-song").show();
	$("#run").attr("disabled","disabled");
	var cID=[];
	<?php foreach ($data as $value):?>
	cID.push(<?php echo $value;?>);
	<?php endforeach;?>
	//console.log(cID[0]);
	ApproveAll(cID);
}
function ApproveAll(cid)
{
	var id = cid[0];
	//console.log(cid);
	var type = $('#t_'+id).text();
	var url='admin.php?r=tools/copyright/process&song_id='+id;
	$.ajax({
        url: url,
        type: "POST",
        dataType:"json",
        async: true,
        data: {t:1},
        beforeSend: function(){
			$("#r_"+id).html("<img src='<?php echo Yii::app()->theme->baseUrl;?>/images/ajax-loader-top-page.gif' />");
	    },
        success: function(data) {
        	$("#result").prepend(data.message);
		    
			cid.splice(0, 1);
        	if(cid.length>0){
        		ApproveAll(cid);
        	}else{
				//ket thuc
       		 	$('#loading-song').hide();
	            $("#result").prepend('<div>Run Completed!</div>');
	            $("#run").removeAttr("disabled");
            }
        }
    });
}
</script>