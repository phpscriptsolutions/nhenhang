<div>Tìm thấy <?php echo $result;?> video chưa ẩn. <button type="button" id="run" onclick="Run();">Run</button></div>
<div id="loading-video" style="display: none;"><span class="loading-import"><img src="<?php echo Yii::app()->theme->baseUrl ?>/images/ajax-loader-top-page.gif"></span></div>
<div id="result" style="height: 300px; overflow: auto;border: 1px solid #ccc;"></div>
<script>
function Run()
{
	$("#loading-video").show();
	$("#run").attr("disabled","disabled");
				jQuery.ajax({
					'url': '<?php echo Yii::app()->createUrl('/tools/video/hide')?>',
					'type':'POST',
					//'data': {fileId:fileId},
					'dataType':'json',
					'success': function(data){
							$("#result").prepend(data.message);
							if(data.completed == 1)
					        {
					            $('#loading-video').hide();
					            $("#result").append('<div>Run Completed!</div>');
					            $("#run").removeAttr("disabled");
					        }else{
					        	Run();
						    }
						}
			    })
}
</script>