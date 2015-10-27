<?php

class UserSubscribeController extends Controller
{

	public function init()
	{
		parent::init();
		$this->pageTitle = Yii::t('admin', "Quản lý  User Subscribe ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
		$pageSize=10;
		Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminUserSubscribeModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminUserSubscribeModel'])){
			$model->attributes=$_GET['AdminUserSubscribeModel'];

			if(isset($_GET['AdminUserSubscribeModel']['created_time']) && $_GET['AdminUserSubscribeModel']['created_time'] !="")
			{
				// Re-setAttribute create datetime
				$createdTime = $_GET['AdminUserSubscribeModel']['created_time'];
				if(strrpos($createdTime, "-")){
					$createdTime = explode("-", $createdTime);
					$fromDate = explode("/", trim($createdTime[0]));
					$fromDate = $fromDate[2]."-".str_pad($fromDate[0], 2, '0', STR_PAD_LEFT)."-".str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
					$fromDate .=" 00:00:00";
					$toDate = explode("/", trim($createdTime[1]));
					$toDate = $toDate[2]."-".str_pad($toDate[0], 2, '0', STR_PAD_LEFT)."-".str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
					$toDate .=" 23:59:59";
				}else{
					$fromDate = date("Y-m-d", strtotime($_GET['AdminUserSubscribeModel']['created_time']))." 00:00:00";
					$toDate = date("Y-m-d", strtotime($_GET['AdminUserSubscribeModel']['created_time']))." 23:59:59";
				}

				$model->setAttribute("created_time", array(0=>$fromDate,1=>$toDate));
			}
		}


		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AdminUserSubscribeModel;
		$packageList = AdminPackageModel::model()->getList();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminUserSubscribeModel']))
		{
			$phone = $_POST['AdminUserSubscribeModel']['user_phone'];

			if(!Formatter::isPhoneNumber(Formatter::removePrefixPhone($phone))){
				$model->addError('phone', "Thuê bao {$phone} không phải của VinaPhone");
			}else{
				try {
					$bmUrl = Yii::app()->params['bmConfig']['remote_wsdl'];
					$client = new SoapClient($bmUrl, array('trace' => 1));
					$phone = Formatter::formatPhone($phone);
					$package = $_POST['AdminUserSubscribeModel']['package_code'];
					$params = array(
				                 'user_phone' 	=> $phone,
				                 'package' 		=> $package,
				                 'source' 		=> 'admin',
								 'promotion'	=> '0',
					);
					$ret = $client->__soapCall('userRegister', $params);

					if($ret->errorCode==0){
						$userSubs = AdminUserSubscribeModel::model()->findByAttributes(array('user_phone'=>$phone));
						$this->redirect(array('view','id'=>$userSubs->id));
					}else{
						$model->addError('return', 'ERROR:'.$ret->errorCode." ".$ret->message);
					}
				}catch (Exception $e){
					$model->addError('return', $e->getMessage());
					Yii::log($e->getMessage(), "error", "exeption.BMException");
				}
			}
		}
		$this->render('create',array(
			'model'=>$model,
			'packageList'=>$packageList,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$this->redirect(array('view','id'=>$id));
		/*
		 $model=$this->loadModel($id);

		 // Uncomment the following line if AJAX validation is needed
		 // $this->performAjaxValidation($model);

		 if(isset($_POST['AdminUserSubscribeModel']))
		 {
			$model->attributes=$_POST['AdminUserSubscribeModel'];
			if($model->save())
			$this->redirect(array('view','id'=>$model->id));
			}

			$this->render('update',array(
			'model'=>$model,
			));
			*/
	}

	public function actionTryRegister($phone)
	{
		$phone = Formatter::formatPhone($phone);
		$subs = AdminUserSubscribeModel::model()->findByAttributes(array('user_phone'=>$phone));
		if(empty($subs)){
			echo "Số điện thoại {$phone} chưa tồn tại trên hệ thống";
			exit;
		}
		if(!Formatter::isPhoneNumber(Formatter::removePrefixPhone($phone))){
			echo  "Thuê bao {$phone} không phải của VinaPhone";
			exit;
		}

		$packageModel = AdminPackageModel::model()->findByPk($subs->package_id);

		try {
			$bmUrl = Yii::app()->params['bmConfig']['remote_wsdl'];
			$client = new SoapClient($bmUrl, array('trace' => 1));

			$params = array(
		                 'user_phone' 	=> $phone,
		                 'package' 		=> $packageModel->code,
		                 'source' 		=> 'admin',
						 'promotion'	=> '0',
			);
			$ret = $client->__soapCall('userRegister', $params);
			/*
			 if($ret->errorCode !=0){
				echo "Xảy ra lỗi: Mã lỗi [{$ret->errorCode}] - [{$ret->message}] ";
				exit;
				}*/

			$this->redirect(array('view','id'=>$subs->id,'msg'=>json_encode($ret)));
		}catch (Exception $e){
			echo "ERROR: ".$e->getMessage();
			Yii::log($e->getMessage(), "error", "exeption.BMException");
			Yii::app()->end();
		}
	}

	public function actionCancel($phone)
	{
		$phone = Formatter::formatPhone($phone);
		$subs = AdminUserSubscribeModel::model()->findByAttributes(array('user_phone'=>$phone));
		if(empty($subs)){
			echo "Số điện thoại {$phone} chưa tồn tại trên hệ thống";
			exit;
		}
		if(!Formatter::isPhoneNumber(Formatter::removePrefixPhone($phone))){
			echo  "Thuê bao {$phone} không phải của VinaPhone";
			exit;
		}

		$packageModel = AdminPackageModel::model()->findByPk($subs->package_id);

		try {
			$bmUrl = Yii::app()->params['bmConfig']['remote_wsdl'];
			$client = new SoapClient($bmUrl, array('trace' => 1));

			$params = array(
				'user_id' 	=> 0,
				'msisdn' 	=> $phone,
				'package' => 'CHACHAFUN', //tam thoi fix ma goi cuoc o day
				'source' 	=> "admin",
			);

			$ret = $client->__soapCall('userUnRegister', $params);
			/*
			 if($ret->errorCode !=0){
				echo "Xảy ra lỗi: Mã lỗi [{$ret->errorCode}] - [{$ret->message}] ";
				exit;
				}
				*/
			$this->redirect(array('view','id'=>$subs->id,'msg'=>json_encode($ret)));
		}catch (Exception $e){
			echo "ERROR: ".$e->getMessage();
			Yii::log($e->getMessage(), "error", "exeption.BMException");
			Yii::app()->end();
		}
	}

	public function actionTrial()
	{
		/**
		 * Close tinh nang dang ky trial by Tungnv
		 */
		echo "Tinh nang nay tam thoi khong hoat dong. Vui long lien he voi ban quan tri he thong de biet them chi tiet";
		exit();
		$model=new AdminUserSubscribeModel;

		if(isset($_POST['AdminUserSubscribeModel']))
		{
			Yii::import("application.components.bm.*");

			$phone = $_POST['AdminUserSubscribeModel']['user_phone'];
			if(!Formatter::isPhoneNumber(Formatter::removePrefixPhone($phone))){
				$model->addError('phone', "Thuê bao {$phone} không phải của VinaPhone");
			}else{
				try {
					$phone = Formatter::formatPhone($phone);
					$checkUser = AdminUserModel::model()->checkUserPhone($phone);
                    $userSub = AdminUserSubscribeModel::model()->getByPhone($phone);

                    $pass = bmCommon::randomPassword();
					$params['username'] = bmCommon::generateUsername();
			        $params['password'] = $pass['encoderPass'];
			        $params['realPass'] = $pass['realPass'];
			        $params['msisdn'] 	= $phone;
			        $params['packageId'] 	= 3;
			        $params['createdDatetime'] 	= date("Y-m-d H:i:s");
			        $params['expired_time'] 	= date("Y-m-d H:i:s");
			        $params['event'] 	= 'TLVT-10-2012';

				    if (!$checkUser){
                        $user = AdminUserModel::model()->add($params);
                        $params['user_id'] = $user->id;
                    }else{
                        $params['user_id'] = $checkUser->id;
                    }

                    if(empty($userSub) || $userSub->status <> 1){
                    	AdminUserSubscribeModel::model()->register($params, $userSub);
                    }
                    Yii::app()->user->setFlash('userTrial',"Thêm mới thành công thuê bao {$phone}");
				}catch (Exception $e){
					$model->addError('return', $e->getMessage());
				}
			}
		}

		$this->render("trial",array(
			'model'=>$model,
		));
	}


	public function actionAddSuggest()
	{
		$model=new AdminUserSubscribeModel;

		if(isset($_POST['AdminUserSubscribeModel']))
		{
			Yii::import("application.components.bm.*");

			$phone = $_POST['AdminUserSubscribeModel']['user_phone'];
			$freeDay = $_POST['AdminUserSubscribeModel']['freeday'];
			if(!Formatter::isPhoneNumber(Formatter::removePrefixPhone($phone))){
				$model->addError('phone', "Thuê bao {$phone} không phải của VinaPhone");
			}else{
				try {
					$phone = Formatter::formatPhone($phone);
					$checkUser = AdminUserModel::model()->checkUserPhone($phone);
                    $userSub = AdminUserSubscribeModel::model()->getByPhone($phone);

                    $pass = bmCommon::randomPassword();
					$params['username'] = bmCommon::generateUsername();
			        $params['password'] = $pass['encoderPass'];
			        $params['realPass'] = $pass['realPass'];
			        $params['msisdn'] 	= $phone;
			        $params['packageId'] 	= 3;
			        $params['createdDatetime'] 	= date("Y-m-d H:i:s");
			        $params['expired_time'] 	= bmCommon::nextDays(date("Y-m-d H:i:s"), $freeDay);
			        $params['event'] 	= 'SUGGEST-MIENTAY';
			        $params['suggested_list'] 	= 1;

				    if (!$checkUser){
                        $user = AdminUserModel::model()->add($params);
                        $params['user_id'] = $user->id;
                    }else{
                        $params['user_id'] = $checkUser->id;
                        $checkUser->suggested_list = 1;
                        $checkUser->save();
                    }
                    AdminUserSubscribeModel::model()->register($params, $userSub);
                    Yii::app()->user->setFlash('addSuggest',"Thêm mới thành công thuê bao {$phone}");
				}catch (Exception $e){
					$model->addError('return', $e->getMessage());
				}
			}
		}

		$this->render("addSuggest",array(
			'model'=>$model,
		));
	}

	public function actionVip()
	{
		if(Yii::app()->getrequest()->ispostrequest){
			$phone = Yii::app()->request->getParam('phone');
			$phone = Formatter::formatPhone($phone);
			if(Formatter::isVinaphoneNumber($phone)){
				$userVip = AdminUserVipModel::model()->findByAttributes(array('user_phone'=>$phone));
				if(empty($userVip)){
					$userVipModel = new AdminUserVipModel;
					$userVipModel->user_phone = $phone;
					$userVipModel->created_time = new CDbExpression("NOW()");
					$userVipModel->save();
					$this->redirect(array('vip'));
				}
			}else{
				Yii::app()->user->setFlash('uservip',"Số điện thoại '{$phone}' không phải TB Vinaphone");
			}
		}
		$pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
		Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminUserVipModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminUserVipModel'])){
			$model->attributes=$_GET['AdminUserVipModel'];
		}

		$this->render('vip',array(
			'model'=>$model,
            'pageSize'=>$pageSize
		));

	}




	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminUserSubscribeModel::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-user-subscribe-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
