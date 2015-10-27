<?php

/**
 * This is the model class for table "admin_user".
 *
 * The followings are the available columns in table 'admin_user':
 * @property integer $id
 * @property integer $cp_id
 * @property integer $ccp_id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $fullname
 * @property string $phone
 * @property string $company
 * @property integer $require_changepass
 * @property string $last_updatepass
 * @property integer $last_block_login
 * @property integer $status
 */
class BaseAdminUserModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AdminUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'admin_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email, password', 'required'),
			array('cp_id, ccp_id, require_changepass, last_block_login, status', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>50),
			array('email, fullname', 'length', 'max'=>160),
			array('password', 'length', 'max'=>45),
			array('phone, company', 'length', 'max'=>255),
			array('last_updatepass', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cp_id, ccp_id, username, email, password, fullname, phone, company, require_changepass, last_updatepass, last_block_login, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            return Common::loadMessages("db");
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('ccp_id',$this->ccp_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('require_changepass',$this->require_changepass);
		$criteria->compare('last_updatepass',$this->last_updatepass,true);
		$criteria->compare('last_block_login',$this->last_block_login);
		$criteria->compare('status',$this->status);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}