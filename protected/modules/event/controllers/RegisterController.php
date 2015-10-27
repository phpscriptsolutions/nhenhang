<?php
class RegisterController extends MController
{
	public function init()
	{
		parent::init();
	}
	public function actionIndex()
	{
		$return = array('error'=>0,'msg'=>'');
		if(Yii::app()->request->isPostRequest){
		 	$phone = Formatter::formatPhone($_POST['phone']);
            if(Formatter::isVinaphoneNumber($phone)){
            	if (!isset($_COOKIE["verifyWifiEvent"])) {
                        if (isset($_SESSION['countverifyWifiEvent']))
                            unset($_SESSION['countverifyWifiEvent']);
                        $_SESSION['countverifyWifiEvent'] = 1;
                        $_SESSION['phoneverifyWifiEvent'] = $phone;
                        setcookie("verifyWifiEvent", 1, time() + 600);
                }else{
                        $_SESSION['countverifyWifiEvent']++;
                        if ($_SESSION['countverifyWifiEvent'] > 3) {
                            $return['error'] = 1;
                            $return['msg'] = "Quí khách đã vượt quá số lần xác thực. Vui lòng thử lại sau ít phút.";
                        }
                }
                if($return['error'] == 0){
                    	try {
                    		$userVerify = UserVerifyModel::model()->findByAttributes(array('msisdn'=>$phone,'action'=>'register_event83'));
                    		if(!empty($userVerify)){
                    			$verifyCode = $userVerify->verify_code;
                    		}else{
                    			$verifyCode = rand(1000, 9999);
                    			$verifyModel = new UserVerifyModel();
                    			$verifyModel->setAttribute('created_time', date("Y-m-d H:i:s"));
                    			$verifyModel->setAttribute('msisdn', $phone);
                    			$verifyModel->setAttribute('verify_code', $verifyCode);
                    			$verifyModel->setAttribute('action', 'register_event83');
                    			$verifyModel->save();
                    		}
                    		$sms = new SmsClient();
                    		$content = "Ma xac thuc dang ky tren chacha la: " . $verifyCode;
                    		$sms->sentMT("9234", $phone, 0, $content, 0, "", time(), 9234);
                    
                    		$this->redirect('/event/register/verifyWifi');
                    	} catch (Exception $exc) {
                    		echo $exc->getTraceAsString();
                    	}
                }
            }else{
                    $return['error'] = 2;
                    $return['msg'] = "Số điện thoại của bạn không phải là thuê bao Vinaphone!";
                }
		}
		$this->render('index',array(
				'return'=>$return
		));
	}
	public function actionVerifyWifi(){
		$phone = $_SESSION['phoneverifyWifiEvent'];
		if($phone){
			$return = array('phone'=>$phone,'error'=>0,'msg'=>'');
			if (isset($_POST['code'])) {
				$userVerify = UserVerifyModel::model()->findByAttributes(array('msisdn'=>$phone,'action'=>'register_event83'));
				if (empty($userVerify) || $userVerify->verify_code != $_POST['code']) {
					$return['error'] = 1;
					$return['msg'] = "Mã xác nhận của Quý Khác không chính xác!";
				}else{
					// Xác thực thành công
					$userVerify->delete();
					
					$isUserSub = WapUserSubscribeModel::model()->chkIsSubscribe($phone);
					/* if(!$isUserSub){//chua da dang ky
						try{
							$bmUrl = yii::app()->params['bmConfig']['remote_wsdl'];
							$client = new SoapClient($bmUrl, array('trace' => 1));
							$params = array(
									'phone' => $phone,
									'package' => 'CHACHAFUN',
									'source' => 'wap',
									'promotion' => 0
							);
							$result = $client->__soapCall('userRegister', $params);
						}catch (Exception $e)
						{
							//
						}
					} */
					$identity = new UserIdentity(null, null);
					if ($identity->userAuthenticateWifi($phone)) {
						Yii::app()->user->login($identity);
					}
					if($isUserSub){
						$this->redirect('/event/play');
						Yii::app()->end();
					}else{
						$this->redirect('/event');
						Yii::app()->end();
					}
				}
			}
			$this->render('verifyWifi', $return);
		}else{
			$this->redirect('/event/register');
		}
	}
	public function actionRegisterNow()
	{
		$phone = yii::app()->user->getState('msisdn');
		$register = $this->_DoRegister($phone);
		/* $register = new stdClass();
		$register->errorCode=0;
		$register->msg="Lỗi hệ thống, hãy thử lại sau ít phút."; */
		$currDate = date('Y-m-d');
		$countPlayByDate = GameEventThreadModel::countPlayByDate($phone, $currDate);
		$this->render('register_now', array(
				'register'=>$register,
				'countPlayByDate'=>$countPlayByDate
		));
	}
	private function _DoRegister($phone, $packageCode='CHACHAFUN')
	{
		$result = new stdClass();
		try{
			$bmUrl = yii::app()->params['bmConfig']['remote_wsdl'];
			$client = new SoapClient($bmUrl, array('trace' => 1));
			$params = array(
					'phone' => $phone,
					'package' => $packageCode,
					'source' => 'wap',
					'promotion' => 0
			);
			$result = $client->__soapCall('userRegister', $params);
			
			if ($result->errorCode==0) { // success
				//display success page
				$msg = Yii::app()->params['subscribe'][$result->message];
			}elseif($result->errorCode==11){
				$msg = "Tài khoản của Quý Khách không đủ tiền. Quý Khách vui lòng nạp thêm tiền vào tài khoản để tham gia chơi ngay.";
			} else {
				//display error page
				if (isset(Yii::app()->params['subscribe'][$result->message])) {
					$msg = Yii::app()->params['subscribe'][$result->message];
					if ($result->message == 'duplicate_package_chachafun') {
						$userSub = $this->userSub;//WapUserSubscribeModel::model()->getUserSubscribe(yii::app()->user->getState('msisdn'));
						$msg = Yii::t('wap', Yii::app()->params['subscribe'][$result->message], array('{DATE}' => $userSub->expired_time));
					}
				} else {
					$msg = $result->message; //Yii::app()->params['subscribe']['default'];
				}
			}
			$result->msg=$msg;
		}catch (Exception $e){
			$result->errorCode=1122;
			$result->msg="Lỗi hệ thống, hãy thử lại sau ít phút.";
		}
		return $result;
	}
}