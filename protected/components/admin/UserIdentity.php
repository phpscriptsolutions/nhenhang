<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	private $cp_id;
	private $ccp_id;
	private $change_pass;
	const ERROR_STATUS_INVALID=201;
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = AdminAdminUserModel::model()->find('LOWER(username)=?',array(strtolower($this->username)));
		if($user===null){
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		}elseif($user->status==0){
			$this->errorCode=self::ERROR_STATUS_INVALID;
		}
		else{
			if (!isset(Yii::app()->session[$user->username."_".$user->id])) {
				Yii::app()->session[$user->username."_".$user->id] = 0;
			}
			$timeBlock = Yii::app()->params['login']['time_block'];
			if((time() - $user->last_block_login)  <= $timeBlock*60){
				Yii::app()->session[$user->username."_".$user->id] = 0;
				$_GET['rank'] = ($timeBlock*60) - (time() - $user->last_block_login);
				//Yii::app()->getRequest()->redirect(Yii::app()->createUrl("admin/blockLogin"));
				Yii::app()->getController()->forward("admin/blockLogin",true);

			}

			$count = Yii::app()->session[$user->username."_".$user->id];

			if($user->password != Common::endcoderPassword($this->password)){
				Yii::app()->session[$user->username."_".$user->id] = $count+1;
				if($count >= Yii::app()->params['login']['limit_block']){
					$user->last_block_login = time();
				}
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}
			else{
				$this->_id = $user->id;
				$this->errorCode=self::ERROR_NONE;
				$this->setState('username', $user->username);
				$this->setState('cp_id', $user->cp_id);
				$this->setState('ccp_id', $user->ccp_id);
				$assigns = AdminAccessAssignmentsModel::model()->getRoles($user->id);
				$this->setState('roles', $assigns);

				$user->last_block_login = 0;
				Yii::app()->session[$user->username."_".$user->id] = 0;
				$effectPass = time() - strtotime($user->last_updatepass);
				$effectPass = ceil($effectPass/(24*60*60));

				if($user->require_changepass){
					//Lan dau login yc change pass
					$this->setState('change_pass', 2);
				}else if($effectPass > 90){
					// Sau 90 ngay can change pass
					$this->setState('change_pass', 3);
				}else if($effectPass >= 7){
					// Truoc 7 ngay expired Pass, co thong bao
					$this->setState('change_pass', 1);
				}else{
					// Password van con hieu luc
					$this->setState('change_pass', 0);
				}
			}
			$user->update();
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}