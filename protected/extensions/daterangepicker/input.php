<?php
class input extends CWidget
{
	public $name;
    public $value;
    private $id;
    
    public function init() {
    	 $this->id = CHtml::getIdByName($this->name);
        parent::init();
        $this->publishAssets();
    }
    
    public function run()
    {
    	echo "<input type='text' value='".$this->value."' name='$this->name' id='$this->id' style='width:158px!important' /> ";
    }
    
    public function publishAssets() {
    	Yii::app()->clientScript->registerCoreScript('jquery');
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        if (is_dir($assets)) {
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/jquery-ui-1.7.1.custom.min.js', CClientScript::POS_END);
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/js/daterangepicker.jQuery.js', CClientScript::POS_END);
            Yii::app()->clientScript->registerCssFile($baseUrl . '/css/ui.daterangepicker.css');
            Yii::app()->clientScript->registerCssFile($baseUrl . '/css/redmond/jquery-ui-1.7.1.custom.css');
            Yii::app()->clientScript->registerScript("daterangepicker","
                $(function(){
	                  $('#".$this->id."').daterangepicker({
	                               arrows:true,
	                               datepickerOptions:{
								        changeMonth: true,
								        changeYear: true,
								        monthNamesShort: ['Một', 'Hai', 'Ba', 'Bốn', 'Năm', 'Sáu', 'Bảy', 'Tám', 'Chín', 'Mười', 'Mười một', 'Mười hai'],
								        dayNamesMin: ['CN', 'Hai', 'Ba', 'Bốn', 'Năm', 'Sáu', 'Bảy'],
								    }
                                }); 
	             });
            ");
            
        } else {
            throw new CHttpException(500, 'daterangepicker - Error: Couldn\'t find assets to publish.');
        }
    }
}