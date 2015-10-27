<?php

class AdminController extends CController
{
	public $layout = 'application.views.admin.layouts.login';
    public $slidebar = array();
    public $pageLabel="";

    public $userId;
    public $username="";
    public $cpId;

    public $phone;
    public $time;
    public $channel;
    public $transType;
    public $objId1;
    public $objId2;
    public $state = false;
    public $channelList = array(
    		''=>'Tất cả',
    );
    public $transList = array(
    		''=>'Tất cả',
    		'subscribe'=>'subscribe',
    		'subscribe_ext'=>'subscribe_ext',
    		'unsubscribe'=>'unsubscribe',
    		'play_song'=>'play_song',
    		'download_song'=>'download_song',
    		'play_album'=>'play_album',
    		'play_video'=>'play_video',
    		'download_video'=>'download_video',
    		'download_ringtone'=>'download_ringtone',
    );

    public function actions() {
        return array(
                // captcha action renders the CAPTCHA image displayed on the contact page
                'captcha'=>array(
                        'class'=>'CCaptchaAction',
                        'backColor'=>0xFFFFFF,
                        'minLength'=>5,
                        'maxLength'=>5,
                		//'testLimit' => 1,
                ),
                // page action renders "static" pages stored under 'protected/views/site/pages'
                // They can be accessed via: index.php?r=site/page&view=FileName
                'page'=>array(
                        'class'=>'CViewAction',
                ),
        );
    }


	public function actionIndex()
	{
		$string = "aa34235235234";

		$pattern = "/^[A-Za-z]([\w]){7,}$/";
		$ret =  preg_match($pattern,$string) && preg_match("/\d/",$string);
		echo "<pre>";var_dump($ret);exit();

		$this->redirect('/');
	}

	public function actionLogin()
	{
		$baseUrl = Yii::app()->homeUrl;
		$baseUrl =  Yii::app()->request->hostInfo.$baseUrl;
		
		if (Yii::app()->user->isGuest){
			$model=new LoginForm();
			if(Yii::app()->request->isPostRequest)
			{
				$model->attributes=$_POST['LoginForm'];
				// validate user input and redirect to the previous page if valid
				if($model->validate() && $model->login()){
					$this->redirect(Yii::app()->user->returnUrl);
				}else{
					$error = $model->getErrorCode();
					//var_dump($error);exit;
					if($error==201){
						echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
						echo "<h2 style='text-align:center'>Tài khoản của bạn đã bị khóa. Liên hệ TrangPTK để kích hoạt lại.($error)</h2>";
						exit();
					}
				}

			}
			// display the login form
			$this->render('login',array('model'=>$model));
		}else{
			$this->redirect('/');
		}
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->createUrl("/admin/login"));
	}


	public function actionError()
	{
		$this->layout = 'application.views.admin.layouts.newstyle';
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	/*
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	        */
	    	$errCode = $error['code'];
	    	$errorMsg = ($errCode==404)?"Không tìm thấy nội dung yêu cầu!":$error['message'];
	    }else{
	    	//$error = Yii::app()->request->getParam('error');
	    	$errorMsg = $_GET['msg'];
	    }
	    $this->render('error', array('errorMsg'=>$errorMsg, 'errCode'=>$errCode) );
	}

	public function actionBlockLogin()
	{
		if(!isset($_GET['rank'])){
			$_GET['msg'] = "Không tìm thấy yêu cầu";
			$this->forward("admin/error",true);
		}
		//$this->renderPartial("blockLogin");
		$this->render("blockLogin");
	}


	public function actionLoadLang()
	{
		header("Content-type: text/javascript");
		echo "var LANG = [] ;\n";
		$path = Yii::getPathOfAlias('application.messages');
		$data = require_once $path.DS.Yii::app()->language.DS."js.php" ;
		foreach($data as $key=>$val){
            $key = addslashes($key);
            $val = addslashes($val);
			echo "LANG['$key']='$val';\n";
		}
        Yii::app()->end(); exit;
	}

	public function actionSendmail()
	{
		$sql = "SELECT GROUP_CONCAT(profile_id) AS listProfile FROM song_profile";
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		echo "<pre>";print_r($data['listProfile']);exit();

		$params = array(
				'username'=>'Thangbg',
				'site'=>'chacha.vn',
				);
		EmailHelper::send("ACTIVE", "thangtv2@vega.com.vn",$params);
	}

	public function actionViewlog()
	{
		$isAll = Yii::app()->request->getParam('all',0);
		$date = array();
		if(!$isAll){
			$date['to'] = date("Y-m-d 23:59:59");
			$date['from'] = date("Y-m-d 00:00:00",time()-(30*24*60*60));
		}
		$this->layout = false;
		$ip = $_SERVER['REMOTE_ADDR'];
		$blackList = $this->_whilelistIP();
		if(!in_array($ip, $blackList) && false){
			echo '<meta http-equiv="content-type" content="text/html; charset=utf-8"/>';
			echo "IP của bạn <b>{$ip}</b> không được cấp quyền truy cập nội dung này!";
			Yii::app()->end();
		}
		Yii::app()->user->setState('pageSize',5);

		$phone = Yii::app()->request->getParam('phone',null);
		//$isAll = Yii::app()->request->getParam('all',0);
		//$isFull = Yii::app()->request->getParam('full',0);
		//$channel = Yii::app()->request->getParam('channel',0);
		$subscribe = null;
		$smsMo = $smsMt = $model = $modelDK = null;
		$params = array();
		$phone = Formatter::formatPhone($phone);
		if($phone){	
			//log đăng ký và hủy
			$modelDK = new AdminUserTransactionModel('search');
			$modelDK->unsetAttributes();  // clear any default values
			$phone = Formatter::formatPhone($phone);
			$modelDK->setAttribute('user_phone', $phone);
			$modelDK->_dkhuy=true;
			//vinaphone
			$modelDKViNA = new LogApiVinaphoneModel('search');
			$modelDKViNA->unsetAttributes();  // clear any default values
			$phone = Formatter::formatPhone($phone);
			$modelDKViNA->setAttribute('msisdn_a', $phone);
			//$modelDKViNA->setAttribute('error_id', 0);
			$modelDKViNA->_dkhuy=true;
			$params['modelDKViNA']=$modelDKViNA;

			//gia hạn
			$modelRenew = new AdminUserTransactionModel('search');
			$modelRenew->unsetAttributes();  // clear any default values
			$phone = Formatter::formatPhone($phone);
			$modelRenew->setAttribute('user_phone', $phone);
			$modelRenew->setAttribute('transaction', 'subscribe_ext');
			if(!$isAll){
				$modelRenew->setAttribute('created_time', $date);
			}
			$params['modelRenew']=$modelRenew;
			//log content
			$genre = GenreModel::model()->findAll();
			foreach ($genre as $gen)
			{
				$genreArr[$gen->id]=$gen->name;
			}
			Yii::app()->session['genre'] = $genreArr;
			//echo '<pre>';print_r($genreArr);
			$modelContent = new AdminUserTransactionModel('search');
			$modelContent->unsetAttributes();  // clear any default values
			$phone = Formatter::formatPhone($phone);
			$modelContent->setAttribute('user_phone', $phone);
			$modelContent->_content=true;
			if(!$isAll){
				$modelContent->setAttribute('created_time', $date);
			}
			$params['modelContent']=$modelContent;
			$subscribe = AdminUserSubscribeModel::model()->findByAttributes(array('user_phone'=>$phone));
			//MO
			$smsMo = new AdminLogSmsMoModel('search');
			$smsMo->setAttribute('sender_phone', "=".$phone);
			if(!$isAll){
				$date['toTime'] = date("Y-m-d 23:59:59");
				$date['fromTime'] = date("Y-m-d 00:00:00",time()-(30*24*60*60));
				$smsMo->setAttribute('receive_time', $date);
			}
			$params['smsMo']=$smsMo;
			//MT
			$smsMt = new AdminLogSmsMtModel('search');
			$smsMt->setAttribute('receive_phone', "=".$phone);
			if(!$isAll){
				$smsMt->setAttribute('send_datetime', $date);
			}
			$params['smsMt']=$smsMt;
		}
		$this->render('viewlog',
				CMap::mergeArray(array(
						'isAll'=>$isAll,
						'phone'=>$phone,
						'subscribe'=>$subscribe,
						'modelDK'=>$modelDK,
				),$params)
		);
	}

	public function actionReportAds()
	{
		$this->layout = false;
		$ads = Yii::app()->request->getParam('type','BUZZCITY');
		$date = Yii::app()->request->getParam('date',null);
		if(!$ads){
			die("Request not foud");
		}
		$ads = strtoupper($ads);
		$cond1 = $cond2 = "";
		if($date){
			$cond1 = " AND date = '{$date}'";
		}
		$sql = "SELECT * FROM statistic_ads WHERE ads = '{$ads}' $cond1 ORDER BY date DESC";
		$data =  Yii::app()->db->createCommand($sql)->queryAll();

		/*Get In day*/
		$inday = array();
		if(!$date){
			$inday[0]['date'] = date("Y-m-d");
			$sql = "SELECT COUNT(*) AS total FROM log_ads_click WHERE ads = '{$ads}' AND date(created_time) = date(NOW())";
			$ret =  Yii::app()->db->createCommand($sql)->queryRow();
			$inday[0]['click_total'] = $ret['total'];

			$sql = "SELECT COUNT(DISTINCT user_ip) AS total FROM log_ads_click WHERE ads = '{$ads}' AND date(created_time) = date(NOW())";
			$ret =  Yii::app()->db->createCommand($sql)->queryRow();
			$inday[0]['click_unique']= $ret['total'];

			$sql = "SELECT COUNT(*) AS total FROM log_ads_click WHERE ads = '{$ads}' AND (user_phone is not null OR user_phone <> '') AND date(created_time) = date(NOW())";
			$ret =  Yii::app()->db->createCommand($sql)->queryRow();
			$inday[0]['click_detect']= $ret['total'];

			$sql = "SELECT COUNT(DISTINCT user_phone) AS total FROM log_ads_click WHERE ads = '{$ads}' AND (user_phone is not null OR user_phone <> '') AND date(created_time) = date(NOW())";
			$ret =  Yii::app()->db->createCommand($sql)->queryRow();
			$inday[0]['click_detect_unique']= $ret['total'];

			$time = date("Y-m-d");
			$sql = "SELECT COUNT(*) AS total FROM user_transaction WHERE transaction = 'subscribe' AND return_code = '0' AND note LIKE '%{$ads}%' AND  created_time>='{$time} 00:00:00' AND created_time<='{$time} 23:59:59'";
			$ret =  Yii::app()->db->createCommand($sql)->queryRow();
			$inday[0]['total_subs_success']= $ret['total'];

			$sql = "SELECT COUNT(*) AS total FROM user_transaction WHERE transaction = 'subscribe' AND return_code <> '0' AND note LIKE '%{$ads}%' AND  created_time>='{$time} 00:00:00' AND created_time<='{$time} 23:59:59'";
			$ret =  Yii::app()->db->createCommand($sql)->queryRow();
			$inday[0]['total_subs_fail']= $ret['total'];
		}

        if (Yii::app()->request->getParam('export', false) && Yii::app()->request->getParam('s', false) == 1) {
            ini_set('display_errors', 'On');
            $label = array(
                'date' => Yii::t('admin', 'Ngày'),
                'click_total' => Yii::t('admin', 'Tổng số click'),
                'click_unique' => Yii::t('admin', 'Số click ko trùng IP'),
                'click_detect' => Yii::t('admin', 'Số click Nhận diện được'),
                'click_detect_unique' => Yii::t('admin', 'Số click Nhận diện Ko trùng Ip'),
                'total_subs_success' => Yii::t('admin', 'Số đăng ký thành công'),
                'total_subs_fail' => Yii::t('admin', 'Số đăng ký thất bại'),
            );
            $datas = CMap::mergeArray($inday,$data);
            $title = Yii::t('admin', 'Thống kê banner '.$ads);
            $excelObj = new ExcelExport($datas, $label, $title);
            $excelObj->export();
        }

		if($date){
			$cond2 = " AND date(created_time) = '{$date}'";
		}
		$sql = "SELECT concat(date(created_time),user_ip) as uc, date(created_time) as m, user_ip, count(*) as total from log_ads_click where ads='{$ads}' $cond2 group by  uc order by m desc";
		$listIP =  Yii::app()->db->createCommand($sql)->queryAll();

        if (Yii::app()->request->getParam('export', false) && Yii::app()->request->getParam('s', false) == 2) {
            $dataexport = array();
            foreach ($listIP as $item){
            	if($item['total'] <= 1) continue;
            	$dataexport[] = $item;
            }
        	ini_set('display_errors', 'On');
            $label = array(
                'm' => Yii::t('admin', 'Ngày'),
                'user_ip' => Yii::t('admin', 'IP'),
                'total' => Yii::t('admin', 'Số click'),
            );

            $title = Yii::t('admin', 'Danh sách IP click trùng banner '.$ads);
            $excelObj = new ExcelExport($dataexport, $label, $title);
            $excelObj->export();
        }

		$this->render('reportAds',array(
			'data'=>$data,
			'ads'=>$ads,
			'listIP'=>$listIP,
			'inday'=>$inday,
		));
	}

	private function _whilelistIP()
	{
		return array(
				// Vega IP
				'127.0.0.1',
				'113.160.24.110',
				'113.190.252.218',
				'113.190.227.231',
				'118.70.169.188',
				'118.70.124.143',
				'10.0.0.89',
				'192.168.241.121',
				'10.0.0.95',
				'10.0.0.31',

		);
	}

	protected function getGenreName($data,$row)
	{
		$genreArr = Yii::app()->session['genre'];
		if(isset($genreArr[$data->genre_id])) return $genreArr[$data->genre_id];
		else return "Nhạc Việt";
	}

	protected function getTransaction($data,$row)
	{
		switch ($data->transaction){
			case "download_song":
				return "Tải bài hát";
				break;
			case "play_song":
				return "Nghe bài hát";
				break;
			case "play_video":
				return "Xem video";
				break;
			case "download_video":
				return "Tải video";
				break;
			case "download_ringtone":
				return "Tải nhạc chuông";
				break;
			case "play_album":
				return "Nghe album";
				break;
			case "gift_song":
				return "Tặng quà";
				break;
		}
			return "";
	}
}