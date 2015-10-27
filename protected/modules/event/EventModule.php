<?php

class EventModule extends CWebModule
{
	public $_assetsUrl = '';
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		$cs=Yii::app()->getClientScript();
    	$this->_assetsUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.event.assets'),false,1,YII_DEBUG);
    	$cs->registerCssFile($this->_assetsUrl."/css/event.css");
    	// import the module-level models and components
    	$this->setImport(array(
    			'event.models.*',
    			//'event.components.*',
    			//'event.models.wap.*',
    	));
    	$userPhone = yii::app()->user->getState('msisdn');
    	if($userPhone && (!isset($_SESSION['visit']) || !$_SESSION['visit'])){
    		$_SESSION['visit']=1;
    		$gameEventActivity = new GameEventActivityModel();
    		$gameEventActivity->user_phone = $userPhone;
    		$gameEventActivity->activity   = 'visit';
    		$gameEventActivity->updated_time = date('Y-m-d H:i:s');
    		$gameEventActivity->note = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    		$gameEventActivity->save();
    	}
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
