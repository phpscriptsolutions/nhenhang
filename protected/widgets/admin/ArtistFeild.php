<?php
class ArtistFeild extends CWidget
{
	public $fieldId = 'artist_id';
	public $fieldName = 'artist_name';
	public $fieldIdVal = '';
	public $fieldNameVal = '';
	public $htmlOptions = array();
	public $dialogZone = null;
	
	private $idZone;
	private $updateZone;
	private $paramLink;
	private $link;

   public function init()
   {
   	    parent::init();
   	    $this->paramLink = array(
                   'id_field'=>CHtml::getIdByName($this->fieldId),
                   'name_field'=>CHtml::getIdByName($this->fieldName)
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
           /*$this->updateZone = array(
                                    'onclick'=>'$("#'.$this->dialogZone.'").dialog("open"); return false;',
                                    'update'=>'#'.$this->dialogZone
                                );*/
           $this->updateZone = array(
                                    'onclick'=>'$("#jobDialog").dialog("open"); return false;',
                                    'update'=>'#jobDialog'
                                );
                                
           //echo "<div id='$this->dialogZone'></div>";                                
       }
       $this->link = $this->controller->createUrl('artist/popupList', $this->paramLink);
       $this->htmlOptions['readonly']='readonly';
       
   }
    
	public function run(){
	   
	   echo CHtml::textField($this->fieldName, $this->fieldNameVal, $this->htmlOptions);
	   /*echo  CHtml::ajaxLink(Yii::t('admin','Chọn từ danh sách'),
	                           $link,
	                           array(
                                    'onclick'=>'$("#jobDialog").dialog("open"); return false;',
                                    'update'=>'#jobDialog'
                                ),
                                array('id'=>'showJobDialog'));*/
	   
	   /*
	    echo  CHtml::ajaxLink(Yii::t('admin','Danh sách'),
                               $this->link,
                               $this->updateZone,
                               $this->idZone);
                               */
                                
	   echo CHtml::hiddenField($this->fieldId, $this->fieldIdVal, $this->htmlOptions);
	   
	   
	   Yii::app()->clientScript->registerScript('artist-'.$this->fieldId, "
			$('#{$this->paramLink['name_field']}').live('focus', function() {
					jQuery
					.ajax({
						'onclick' : '$(\\\"{$this->updateZone['update']}\\\").dialog(\\\"open\\\"); return false;',
						'url' : '{$this->link}',
						'cache' : false,
						'success' : function(html) {
							jQuery('{$this->updateZone['update']}').html(html)}});
				})		
		");
	}
}