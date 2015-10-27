<?php

/**
 * This is the model class for table "user_verify".
 *
 * The followings are the available columns in table 'user_verify':
 * @property string $id
 * @property integer $user_id
 * @property string $msisdn
 * @property string $email
 * @property string $verify_code
 * @property string $action
 * @property string $params
 * @property string $token
 * @property string $created_time
 * @property integer $status
 */
class BaseUserVerifyModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserVerify the static model class
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
		return 'user_verify';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, status', 'numerical', 'integerOnly'=>true),
			array('msisdn, verify_code', 'length', 'max'=>50),
			array('email, token', 'length', 'max'=>255),
			array('action', 'length', 'max'=>20),
			array('params, created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, msisdn, email, verify_code, action, params, token, created_time, status', 'safe', 'on'=>'search'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('verify_code',$this->verify_code,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('created_time',$this->created_time,true);
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