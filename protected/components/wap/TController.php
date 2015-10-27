<?php
class TController extends Controller
{
	public $layout = 'application.views.touch.layouts.main';
	public $userPhone = false;
	public $deviceLayout = 'touch';
	public function init() {
		parent::init();
	}
	
	/*public function getViewPath() {
		$isTouch = $this->_isTouchLayout();
		if(!$isTouch){
			$wapView = _APP_PATH_ . "/protected/views/wap/" . $this->getId();
			return $wapView;
			$action = $this->getAction()->getId();
			if(file_exists($wapView.DS.$action.".php")){
				return $wapView;
			}			 
		}
		return parent::getViewPath();
	}
	
	public function getViewFile($viewName) {
		$rs = parent::getViewFile($viewName);
		if (!file_exists($rs)) {					
			$rs = parent::getViewFile($viewName);
		}
		return $rs;
	}*/
}