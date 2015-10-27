<?php
class ArtistAuto extends CWidget
{
	public $fieldId = 'artist_id';
	public $fieldName = 'artist_name';
	public $fieldIdVal = '';
	public $fieldNameVal = '';

   public function init()
   {
   	    parent::init();
   	    $idTxt = CHtml::getIdByName($this->fieldName);
   	    $idById = CHtml::getIdByName($this->fieldId);

   	    Yii::app()->getClientScript()->registerCssFile( Yii::app()->theme->baseUrl."/css/jquery.autocomplete.css");
   	    Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl."/js/jquery.autocomplete.js");
   	    $link = Yii::app()->createUrl("artist/autoComplete");

   	    $script = <<<EOD
   	    $(document).ready(function() {
	   	    $('#{$idTxt}').autocomplete('{$link}', {
				width: 260,
				matchContains: true,
				mustMatch: true,
				selectFirst: true
			});
			$("#{$idTxt}").result(function(event, data, formatted) {
				$("#{$idTxt}").val(data[0]);
				$("#{$idById}").val(data[1]);
			});
   	    });
EOD;
		 Yii::app()->clientScript->registerScript("artist-auto",$script, CClientScript::POS_HEAD);
   }

	public function run(){
	   echo CHtml::textField($this->fieldName, $this->fieldNameVal);
	   echo CHtml::hiddenField($this->fieldId, $this->fieldIdVal);
	}
}