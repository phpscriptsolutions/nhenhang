<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
                'id'=>'jobDialog',
                'options'=>array(
                    'title'=>Yii::t('web','Crop Image'),
                    'autoOpen'=>true,
                	'resizable'=>false,
                    'modal'=>'true',
                    'width'=>'700px',
                    'height'=>'auto',
                ),
                ));

$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->request->baseUrl."/web/jcrop/css/jquery.Jcrop.css");
$cs->registerCssFile(Yii::app()->request->baseUrl."/web/jcrop/css/jquery.Jcrop.extras.css");
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/jcrop/js/jquery.Jcrop.js", CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->request->baseUrl."/web/jcrop/js/jquery.color.js", CClientScript::POS_HEAD);


$form=$this->beginWidget('CActiveForm', array(
    'action'=>'',
    'method'=>'post',
    'htmlOptions'=>array('class'=>'popupform'),
));
?>

<script type="text/javascript">
  jQuery(function($){

    var jcrop_api;

    $('#target').Jcrop({
      bgFade:     true,
      bgOpacity: .2,
      aspectRatio:16/9,
      //minSize:[304,171],
      setSelect: [ 0,0,320,180],
      onChange:   showCoords,
      onSelect:   showCoords,
    },function(){
      jcrop_api = this;
    });
  })

    function showCoords(c)
  {
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#x2').val(c.x2);
    $('#y2').val(c.y2);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  $("#crop_img").click(function(){
	  var url = $(".popupform").attr('action');
		$.post(url,$('.popupform').serialize(), function(data){
			$("#<?php echo $updateItem ?>").attr("src",$.trim(data)+"?v="+Math.random().toString(36).substring(3));
			$("#jobDialog").dialog("close");
	    });
		return false;
  })

</script>
<?php if($error["code"] != 0):?>
<?php echo $error["message"];?>
<?php else :?>
<div class="row-fluid">
	<div class="span9">
		<img src="<?php echo $fileUrl ?>" id="target" />
	</div>
	<div class="inline-labels hide" style="display: none;">

		<label>X1 <input type="text" size="4" id="x1" name="x1" /></label> <label>Y1
			<input type="text" size="4" id="y1" name="y1" />
		</label> <label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
		<label>Y2 <input type="text" size="4" id="y2" name="y2" /></label> <label>W
			<input type="text" size="4" id="w" name="w" />
		</label> <label>H <input type="text" size="4" id="h" name="h" /></label>
	</div>

</div>
<center>
<br />
<input type="button" id="crop_img" value="Update" />
<?php
/* echo CHtml::ajaxSubmitButton(Yii::t('admin','Change'),CHtml::normalizeUrl(array('image/crop')),array('success'=>'js: function(data) {
                    $("#'.$updateItem.'").attr("src",$.trim(data));
					$("#jobDialog").dialog("close");
                    }'),array('id'=>'closeJobDialogPC','live' =>false)); */
echo CHtml::button(Yii::t('web','Cancel'),array("onclick"=>'$("#jobDialog").dialog("close");'));
?>
</center>
<?php endif;?>
<?php
$this->endWidget();
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
