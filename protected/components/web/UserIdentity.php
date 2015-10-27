<?php
class UserIdentity extends CUserIdentity
{
	const ERROR_NO_VALID_PHONE=10;
	const ERROR_NO_VALID_EMAIL=11;
	const ERROR_LIMITED_LOGIN = 403;
    private $_id;
    public $new;
    public $auto=false;

    public function authenticate()
    {

        $isEmail = EmailHelper::isEmailAddress($this->username);
        $isPhone = Formatter::isPhoneNumber($this->username);
        if($isEmail){
            $crit = new CDbCriteria();
            $crit->condition = "LOWER(email)=:email";
            $crit->params = array(':email'=>$this->username);
            $crit->order = "id DESC";
            $user = WebUserModel::model()->find($crit);
            if(empty($user)){
                return $this->errorCode = self::ERROR_USERNAME_INVALID;
            }elseif($user && $user->validate_email==0){
                return $this->errorCode = self::ERROR_NO_VALID_EMAIL;
            }
        }elseif($isPhone){
            $this->username = Formatter::formatPhone($this->username);
            $crit = new CDbCriteria();
            $crit->condition = "phone=:phone";
            $crit->params = array(':phone'=>$this->username);
            $user = WebUserModel::model()->find($crit);
            if(empty($user)){
                return $this->errorCode = self::ERROR_USERNAME_INVALID;
            }elseif($user && $user->validate_phone==0){
                return $this->errorCode = self::ERROR_NO_VALID_PHONE;
            }
        }else {
            $user = WebUserModel::model()->find('LOWER(username)=?', array(strtolower($this->username)));
        }

        if($user===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        //else if(!$user->validatePassword($this->password))
        else if($user->password != UserIdentity::encodePassword($this->password) && $this->auto==false){
            $this->errorCode=self::ERROR_PASSWORD_INVALID;}
        else
        {
            $user->lastvisit_at = new CDbExpression("NOW()");
            $user->save();
            $this->_id = $user->id;
            $this->errorCode=self::ERROR_NONE;
            $this->setState('lastLoginTime', $user->login_time);
            $this->setState('updated_time', $user->updated_time);
            $this->setState('fullname', $user->fullname);
            $this->setState('username', $user->username);
            $this->setState('email', $user->email);
            $this->setState('phone', $user->phone);
            $this->setState('new', !$user->login_time);
        }
        return $this->errorCode==self::ERROR_NONE;
    }

    public function authnopass()
    {
    	$phone = Formatter::formatPhone($this->username);
    	$user=WebUserModel::model()->findByPhone($phone);

    	$this->_id=$user->id;
    	$this->setState('lastLoginTime', $user->login_time);
    	$this->setState('fullname', $user->fullname);
        $this->setState('updated_time', $user->updated_time);
    	$this->setState('username', $user->username);
    	$this->setState('email', $user->email);
    	$this->setState('phone', $user->phone);
    	$this->setState('new', !$user->login_time);
    	$this->errorCode=self::ERROR_NONE;
    	$user->login_time = date('Y-m-d H:i:s');
    	$user->save();
    	/* $activity = new WebUserActivityModel();
    	$activity->fromLogin($user->id,$user->phone);
    	$activity->save(); */
    	return !$this->errorCode;
    }

    public static function encodePassword($password){
    	//return $password;
        return Common::endcoderPassword($password);
    }

    public function getId()
    {
        return $this->_id;
    }

    /**
     *
     * get random password string
     * @param int $length
     * @return string
     */
    public static function randomPassword($length=6) {
        $str = "0123456789abcdefghijklmopqrstuxyz";
        $min = 0;
        $max = strlen($str)-1;
        $password = "";
        for($i=0; $i<$length; $i++)
        {
            $char = $str[mt_rand($min, $max)];
            $password .= $char;
        }

        return $password;
    }

}