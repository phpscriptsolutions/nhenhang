<?php
class Feild extends CWidget
{
	public $fieldId = 'artist_ids[]';
	public $fieldIdVal = array(); // is array of artist
	public $htmlOptions = array();
	public $dialogZone = null;
	public $multiSelect = true;


	private $idZone;
	private $updateZone;
	private $paramLink;
	private $link;

   public function init()
   {
   	    parent::init();
   	    $this->paramLink = array(
                   'id_field'=>CHtml::getIdByName($this->fieldId),
   	    			'multileSelect'=>$this->multiSelect?1:0,
                   );
    if(!$this->dialogZone){
           $this->idZone = array('id'=>'showJobDialog', 'class'=>'ajaxlink');
           $this->updateZone = array(
                                    'onclick'=>'$("#jobDialog").dialog("open"); return false;',
                                    'update'=>'#jobDialog'
                                );
       }else{
           $this->paramLink['id_dialog']=$this->dialogZone;
           $this->idZone = array('id'=>$this->dialogZone."-show", 'class'=>'ajaxlink');
           $this->updateZone = array(
                                    'onclick'=>'$("#jobDialog").dialog("open"); return false;',
                                    'update'=>'#dialog'
                                );
       }
       $this->link = $this->controller->createUrl('artist/popupList', $this->paramLink);
       $this->htmlOptions['readonly']='readonly';

   }

	public function run(){

		echo CHtml::link(Yii::t('admin','Choses from list'),'#',array('class'=>'artist-dialog'))."<br />";
		echo ' <div id="'.$this->paramLink['id_field'].'" class="artist-zone"></div>';

		$artistList = '[';
		foreach($this->fieldIdVal as $artist)
		{
			$artistList .= '{id:'.$artist->artist_id.',name:"'.$artist->artist_name.'"},';
		}
		$artistList.= ']';

	   Yii::app()->clientScript->registerScript('artist-'.$this->paramLink['id_field'], "
			$('.artist-dialog').live('click', function() {
					jQuery
					.ajax({
						'onclick' : '$(\\\"{$this->updateZone['update']}\\\").dialog(\\\"open\\\"); return false;',
						'url' : '{$this->link}',
						'cache' : false,
						'beforeSend':function(){
							overlayShow();
						},
						'complete':function(){
					    	overlayHide();
					  	},
						'success' : function(html) {
							overlayHide();
							jQuery('{$this->updateZone['update']}').html(html)}});
				});

			var artistList = {$artistList};
		",CClientScript::POS_HEAD);

	   Yii::app()->clientScript->registerScript('artist-'.$this->paramLink['id_field'].'_end', "
				display_artist(artistList,'{$this->paramLink['id_field']}');
	   		");

	}
}