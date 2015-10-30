<?php

class Controller extends CController {

    public $layout = 'application.views.web.layouts.2column';
    public $breadcrumbs = array();

    public $htmlKeyword = "";
    public $htmlDescription = "";
    public $htmlTitle = "";
    public $headMeta = "";
	public $lastAction='';
	public $lastUrl='';

    public function init() {
		if (!isset(Yii::app()->session['device'])) {
			$device = new DeviceHelper();
			$data = array();
			$data['platform'] = $device->getPlatform();
			Yii::app()->session['device'] = $data;
		}
		$device = Yii::app()->session['device'];
        //log shortlink
        if(isset($_REQUEST['source']) && $_REQUEST['source']=='shortlink' && !Yii::app()->user->getState('slLoged')){
        	$logSL = new ShortlinkLogsModel();
        	$logSL->link_id 	= intval($_REQUEST['slid']);
        	$logSL->user_ip 	= $_SERVER["REMOTE_ADDR"];
        	$logSL->user_agent 	= $_SERVER["HTTP_USER_AGENT"];
        	$logSL->referer 	= $_SERVER['HTTP_REFERER'];
        	$logSL->loged_datetime = date('Y-m-d H:i:s');
        	$logSL->save();
        	Yii::app()->user->setState('slLoged',1);
        }
        //end log
		if(Yii::app()->user->hasState('last_action')) {
			$this->lastAction = Yii::app()->user->getState('last_action');
		}
		if(Yii::app()->user->hasState('last_url')) {
			$this->lastUrl = Yii::app()->user->getState('last_url');
		}
        // reload cache
        $this->updateCache();
        parent::init();
    }

    public function actionError(){}

    public function  render($view, $data = null, $return = false) {

    	$this->htmlKeyword = Yii::app()->params['htmlMetadata']['keywords'];
    	if($this->htmlTitle){
    		$this->htmlTitle .= " | ". Common::strNormal($this->htmlTitle)." | ";
    	}
    	$this->htmlTitle .= Yii::app()->params['htmlMetadata']['title'];

    	if(!$this->htmlDescription){
    		$this->htmlDescription = Yii::app()->params['htmlMetadata']['description'];
    	}
    	if($this->headMeta ==''){
    		$this->headMeta = '
    				<meta name="description" content="Đọc truyện online, đọc truyện chữ, truyện hay, truyện full. Truyện Full luôn tổng hợp và cập nhật các chương truyện một cách nhanh nhất." />
					<meta name="keywords" content="doc truyen, doc truyen online, truyen hay, truyen chu, ngon tinh, kiem hiep, tien hiep, sac hiep, kinh di, trinh tham, vong du, xuyen khong, truyen teen" />
			';
    	}
    	parent::render($view, $data, $return);
    }

    private function updateCache() {
    	if(Yii::app()->request->getParam('resetcache', 0) === 1)
    		Yii::app()->setComponent('cache', new CDummyCache());
    }
}