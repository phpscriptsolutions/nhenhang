<?php
class AdminUserModel extends BaseAdminUserModel
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('cp_id, status', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>50),
			array('email, fullname', 'length', 'max'=>160),
			array('password', 'length', 'max'=>45),
			array('phone, company', 'length', 'max'=>255),
			array('username', 'unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cp_id, username, email, password, fullname, phone, company, status', 'safe', 'on'=>'search'),
		);
	}

	
	public function unique($attribute,$params)
	{
		if(!$this->id && self::model()->exists('username = :username', array(':username'=>$this->username))){
			$this->addError("username", Yii::t('admin','Tên đăng nhập đã tồn tại'));
			return false;
		}
		return true;
	}	
}