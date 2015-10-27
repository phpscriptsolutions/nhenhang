<?php
class MController extends Controller
{
	public $layout = 'application.modules.event.views.layouts.main';
	//public $layout = 'application.views.wap.default.layouts.main';
	public $deviceLayout = 'default';
	public $userPhone = false;
	public $isSub = false;
	public function init() {
		/* $log = new KLogger('log_view_error', KLogger::INFO);
		$log->LogInfo("viewPath:".$this->getViewPath(), false);
		$log->LogInfo("Action:".$this->getAction(), false); */
		$isTouch = $this->_isTouchLayout();
		if($isTouch){
			$this->deviceLayout='touch';
			$this->layout = 'application.views.touch.layouts.main';
			if(strpos(Yii::app()->params['mobile_touch_url'],$_SERVER['HTTP_HOST'])===false){
				$this->redirect(Yii::app()->params['mobile_touch_url'].Yii::app()->request->requestUri);
			}
		}else{
			$this->deviceLayout='default';
			//$this->layout = 'application.views.wap.default.layouts.main';
			$this->layout = 'application.modules.event.views.layouts.main';
			if(strpos(Yii::app()->params['mobile_base_url'],$_SERVER['HTTP_HOST'])===false){
				$this->redirect(Yii::app()->params['mobile_base_url'].Yii::app()->request->requestUri);
			}
		}
		parent::init();
		
		if($isTouch){
			//get userPhone
			if (Yii::app()->user->isGuest) {
				$identity = new UserIdentity(null, null);
				$type = 'autoLogin';
				if ($identity->userAuthenticate($type, $this->deviceOs)) {
					Yii::app()->user->login($identity);
					$this->userPhone = Yii::app()->user->getState('msisdn');
				}
			} else {
				$this->userPhone = Yii::app()->user->getState('msisdn');
			}
			$this->banners = BannerModel::getBanner('wap');
			//chk is subscribe
			if(!empty($this->userPhone))
				$this->isSub = WapUserSubscribeModel::model()->chkIsSubscribe($this->userPhone);
		}
	}

}