<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends MainUserIdentity {
	private $_id;
	const ERROR_NOT_VALIDATE_EMAIL = 20;
	const ERROR_NOT_VALIDATE_PHONE = 21;
	/**
	 * function userAuthenticate
	 * call after detect phone number, save phone number and package to session
	 *
	 * @param string $type
	 * @return bool
	 */
	public function userAuthenticate($type, $os) {
		if($type == 'autoLogin') {
			$msisdn = self::_detectMSISDN('wap',NULL,$os);
			if ($msisdn){
				// get user info from phone
				if($user = UserModel::model()->findByAttributes(array("phone" => $msisdn))) {
					if(!empty($user->suggested_list))
						$this->setState('_user', array(
								'id'    => $user->id,
								'suggested_list' => $user->suggested_list,
						));
					else
						$this->setState('_user', array(
								'phone'    => $msisdn,
								'suggested_list' => ""
						));
				}
				else{
					$this->setState('_user', array(
							'phone'    => $msisdn,
							'suggested_list' => ""
					));
				}

				$this->_msisdn = $msisdn;
				$this->errorCode = self::ERROR_NONE;


			} else {
				$this->errorCode=self::ERROR_USERNAME_INVALID;
			}
			$this->_id = $msisdn;
		}else{
		$user = WapUserModel::model ()->findByAttributes ( array('email'=> $this->username ));
		if (empty ( $user )) {
			$phone = Formatter::formatPhone ( $this->username );
			$user = WapUserModel::model ()->findByPhone ( $phone );
		}
		if ($user === null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else if ($user->password !== (Common::endcoderPassword ( $this->password )))
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else {
			$this->_id = $user->id;
			$this->setState ( 'username', $user->username );
			$this->setState ( 'fullname', $user->fullname );
			$this->setState ( 'phone', $user->phone );
			$this->errorCode = self::ERROR_NONE;
			$user->login_time = new CDbExpression ( "NOW()" );
			$user->save ();
			$this->_msisdn = $user->phone;
		}
		}
		if ($this->_msisdn) {
			$this->setState ( 'msisdn', $this->_msisdn );
		}
		$package = WapUserSubscribeModel::model ()->getUserSubscribe ( $this->_msisdn ); // get user_subscribe record by phone
		if ($package) {
			$packageObj = WapPackageModel::model ()->findByPk ( $package->package_id );
			$this->setState ( 'package', $packageObj->code );
		}
		return ! $this->errorCode;

	}

	/**
	 * @param string $type
	 * @return bool
	 */
	public function authenticate($type='email'){
		if($type=='email') {
			$users = WapUserModel::model()->findAllByAttributes(array('email' => $this->username));
			$typeValidate = 'validate_email';

			if (count($users) == 0) {
				$phone = Formatter::formatPhone($this->username);
				$users = WapUserModel::model()->loginByPhone($phone);
				$typeValidate = 'validate_phone';
			}
			if (count($users) == 0) {
				$this->errorCode = self::ERROR_USERNAME_INVALID;
				return false;
			} else {
				$checkPass = false;
				$isValidate = false;
				$userInfo = null;
				foreach ($users as $user) {
					if ($user->password === Common::endcoderPassword($this->password)) {
						$checkPass = true;
						$userInfo = $user;
						if ($user->$typeValidate == 1) {
							$isValidate = true;
							break;
						}
					}
				}

				if ($checkPass === false) {
					$this->errorCode = self::ERROR_PASSWORD_INVALID;
					return false;
				} else if ($isValidate === false) {
					if ($typeValidate == 'validate_email') {
						$this->errorCode = self::ERROR_NOT_VALIDATE_EMAIL;
					} else {
						$this->errorCode = self::ERROR_NOT_VALIDATE_PHONE;
					}
					return false;
				} else {
					$this->_id = $userInfo->id;
					$this->setState('username', $userInfo->username);
					$this->setState('fullname', $userInfo->fullname);
					$this->setState('phone', $userInfo->phone);
					$this->setState('updated_time', $userInfo->updated_time);
					$this->errorCode = self::ERROR_NONE;
					$userInfo->login_time = new CDbExpression ("NOW()");
					$userInfo->save();
					$this->_msisdn = $userInfo->phone;
				}
			}
		}else{
			$user = WapUserModel::model()->findByAttributes(array('username' => $this->username));

			if ($user === null) {
				$this->errorCode = self::ERROR_USERNAME_INVALID;
				return false;
			}else{
				//check password
				if ($type=='username' && $user->password !== Common::endcoderPassword($this->password)) {
					$this->errorCode = self::ERROR_PASSWORD_INVALID;
					return false;
				}else{
					$this->_id = $user->id;
					$this->setState('username', $user->username);
					$this->setState('fullname', $user->fullname);
					$this->setState('phone', $user->phone);
					$this->setState('updated_time', $user->updated_time);
					$this->errorCode = self::ERROR_NONE;
					$user->login_time = new CDbExpression ("NOW()");
					$user->save();
					$this->_msisdn = $user->phone;
				}
			}
		}

		if ($this->_msisdn) {
			$this->setState('msisdn', $this->_msisdn);
		}
		$package = WapUserSubscribeModel::model()->getUserSubscribe($this->_msisdn); // get user_subscribe record by phone
		if ($package) {
			$packageObj = WapPackageModel::model()->findByPk($package->package_id);
			$this->setState('package', $packageObj->code);
		}
		return !$this->errorCode;
	}
	public function userAuthenticateWifi($msisdn) {
		if ($msisdn) {
			// get user info from phone
			$user = UserModel::model ()->findByAttributes ( array (
					"phone" => $msisdn
			) );
			if ($user) {
				if (! empty ( $user->suggested_list ))
					$this->setState ( '_user', array (
							'id' => $user->id,
							'suggested_list' => $user->suggested_list
					) );
				else
					$this->setState ( '_user', array (
							'phone' => $msisdn,
							'suggested_list' => ""
					) );
			} else {
				$this->setState ( '_user', array (
						'phone' => $msisdn,
						'suggested_list' => ""
				) );
			}
			$this->_msisdn = $msisdn;

			$this->setState ( 'msisdn', $msisdn );
			$this->setState ( 'isWifi', true );

			$package = WapUserSubscribeModel::model ()->getUserSubscribe ( $this->_msisdn ); // get user_subscribe record by phone
			if ($package) {
				$packageObj = WapPackageModel::model ()->findByPk ( $package->package_id );
				$this->setState ( 'package', $packageObj->code );
			}

			self::_logDetectMSISDN( $msisdn, 'wifi' );

			$this->errorCode = self::ERROR_NONE;
		} else {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}

		return ! $this->errorCode;
	}

	/**
	 *
	 * @return integer the ID of the user record
	 */
	public function getId() {
		return $this->_id;
	}
}