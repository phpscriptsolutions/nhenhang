<?php
$this->pageLabel = "Read file";
?>
<div id="content">
<div class="form">
<form method="post" action="">
<div class="row">
	<label>File Path:</label>
	<input style="width: 80%" type="text" name="file_path" value="" />
</div>
<div class="row">
	<label>Lines Count:</label>
	<input type="text" name="line_count" value="10" />
</div>
<div class="row buttons">
		<?php
			echo CHtml::ajaxSubmitButton(Yii::t('web','Read Now'),CHtml::normalizeUrl(array('file/readFile','render'=>false)),
				array(
					'beforeSend'=>'js: function() {
						$("#result").html("<img src=\"'.Yii::app()->theme->baseUrl.'/images/ajax-loader-top-page.gif\">");
					}',
					'success'=>'js: function(data) {
						$("#result").html(data);
					}'
					),
				array('live' =>false,'class'=>'btn-popup btn-popup-green'));

			?>
	</div>
</form>
</div>
<div id="result"></div>
</div>