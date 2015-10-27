<div>Tìm thấy <span id="total_hide"><?php echo $result;?></span> bài hát chưa ẩn. <button type="button" id="run" onclick="Run();">Run</button></div>
<div>Tìm thấy <?php echo $restore;?> bài hát cần restore. <button type="button" id="run_restore" onclick="RunRestore();">Run</button></div>
<div id="loading-song" style="display: none;"><span class="loading-import"><img src="<?php echo Yii::app()->theme->baseUrl ?>/images/ajax-loader-top-page.gif"></span></div>
<div id="result" style="height: 300px; overflow: auto;border: 1px solid #ccc;"></div>
<script>
function Run()
{
	$("#loading-song").show();
	$("#run").attr("disabled","disabled");
				jQuery.ajax({
					'url': '<?php echo Yii::app()->createUrl('/tools/song/hide')?>',
					'type':'POST',
					//'data': {fileId:fileId},
					'dataType':'json',
					'success': function(data){
							$("#result").prepend(data.message);
							var total = $("#total_hide").text();
							result = parseInt(total)-1;
							$("#total_hide").text(result);
							if(data.completed == 1)
					        {
					            $('#loading-song').hide();
					            $("#result").prepend('<div>Run Completed!</div>');
					            $("#run").removeAttr("disabled");
					        }else{
					        	Run();
						    }
						}
			    })
}
function RunRestore()
{
	$("#loading-song").show();
	$("#run_restore").attr("disabled","disabled");
				jQuery.ajax({
					'url': '<?php echo Yii::app()->createUrl('/tools/song/restore')?>',
					'type':'POST',
					//'data': {fileId:fileId},
					'dataType':'json',
					'success': function(data){
							$("#result").prepend(data.message);
							if(data.completed == 1)
					        {
					            $('#loading-song').hide();
					            $("#result").prepend('<div>Run Completed!</div>');
					            $("#run_restore").removeAttr("disabled");
					        }else{
					        	RunRestore();
						    }
						}
			    })
}
</script>