<?php

class Controller extends SBaseController {

    public $layout = 'application.views.admin.layouts.newstyle';
    public $menu = array();
    public $breadcrumbs = array();
    public $slidebar = array();
    public $pageLabel = "";
    public $userId;
    public $username = "";
    public $cpId;
    public $ccpId;
    public $expiredPass = 0;

    public $adminGroup = "";
    public $levelAccess = 999999;

    public function init() {
        if (!Yii::app()->user->isGuest) {
            $this->userId = Yii::app()->user->Id;
            $this->username = Yii::app()->user->username;
            $this->cpId = Yii::app()->user->cp_id;
            $this->expiredPass = Yii::app()->user->change_pass;
            $this->adminGroup = implode(",", Yii::app()->user->roles);

            if(in_array("SuperAdmin",Yii::app()->user->roles)){
            	$this->levelAccess = 1;
            }elseif(in_array("Admin",Yii::app()->user->roles) || in_array("AdminCCP",Yii::app()->user->roles)){
            	$this->levelAccess = 2;
            }if(in_array("SuperAdmin",Yii::app()->user->roles)){
            	$this->levelAccess = 3;
            }else{
            	$this->levelAccess = 4;
            }
        }else{
        	$this->redirect(array('/admin/login'));
        }

        $flag_loop = Yii::app()->request->getParam('_state', false);        
        if ($this->expiredPass >= 2 && !$flag_loop) {
            $this->redirect(array('adminUser/profile', '_state' => $this->expiredPass));
        }

        // setup multi language
        if (!isset(Yii::app()->session['_lang'])) {
            Yii::app()->session['_lang'] = Yii::app()->params['defaultLanguage'];
        }

        Yii::app()->language = Yii::app()->session['_lang'];
        parent::init();
    }

    protected function beforeAction($action) {
        $params = isset(Yii::app()->params['controllerlog'])?Yii::app()->params['controllerlog']:array();
        $act = $this->getAction()->getId();
        $ctr = $this->getId();
        $ctract = $ctr . $act;
        $method = isset($params[$ctract])?$params[$ctract]:"";
        $flag = false;
        if(Yii::app()->request->isPostRequest){
        	//Log tat ca cac action la post
        	$flag = true;
        }else if (array_key_exists($ctract, $params) && ($method == 'get' || $method == 'all')) {
        	// Log cac action la GET va nam trong config 'controllerlog'
        	$flag = true;
        }
		else if ($ctr=='customer' && (Yii::app()->session['phone']!='') && $act!="logAction"  && $act!="viewLogAction" ) {
        	// Log cac action la GET va nam trong config 'controllerlog'
			if( $act=="logAction")
			$act="Xem log tác động khách hàng";
			else if( $act=="index")
			 $act="Tra cứu thuê bao";
			else if( $act=="register")
			 $act="Đăng ký gói cước";
			else if( $act=="subscriber")
			 $act="Xem lịch sử đăng ký, huỷ dịch vụ của thuê bao";
			else if( $act=="history")
			 $act="Xem lịch sử trừ cước của thuê bao";
			else if( $act=="sms")
			 $act="Xem tin nhắn MO/MT của thuê bao"; 
        	$flag = true;
        }
        

        if ($flag) {
            $model = new AdminLogActionModel();
            $model->adminId = $this->userId;
            $model->adminName = $this->username;
            $model->controller = $ctr;
            $model->action = $act;
            $model->created_time = new CDbExpression("NOW()");
			$model->ip = Yii::app()->request->getUserHostAddress();
			$model->roles = $this->adminGroup;
			$model->msisdn = Yii::app()->session['phone'];
	        $model->params = json_encode($_REQUEST);
            $model->save();
        }
        
        //log action delete
        if(strpos(strtolower($act), 'delete')!==false){
        	$uri = $_SERVER['REQUEST_URI'];
        	$ip  = $_SERVER['REMOTE_ADDR'];
        	$log = new KLogger('LogActionDeleteCMS', KLogger::INFO);
        	$log->LogInfo("Log Delete | UserId: ".Yii::app()->user->id."|IP:$ip"."| URI:".$uri, false);
        }
        return parent::beforeAction($action);
    }
	public function canEditPrice() {
		if(($this->cpId == 0) || ($this->cpId == 1) || ($this->cpId == 89)) return true;
		return false;
	}

}