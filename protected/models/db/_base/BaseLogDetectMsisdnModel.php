<?php

/**
 * This is the model class for table "log_detect_msisdn".
 *
 * The followings are the available columns in table 'log_detect_msisdn':
 * @property string $id
 * @property string $phone
 * @property string $login_ip
 * @property string $device_id
 * @property string $detect_type
 * @property string $loged_time
 * @property integer $status
 * @property string $channel
 * @property string $user_agent
 * @property integer $package_id
 * @property string $event
 * @property string $referral
 * @property string $os
 * @property string $uri
 */
class BaseLogDetectMsisdnModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogDetectMsisdn the static model class
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
		return 'log_detect_msisdn';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id, loged_time', 'required'),
			array('status, package_id', 'numerical', 'integerOnly'=>true),
			array('phone', 'length', 'max'=>16),
			array('login_ip, device_id', 'length', 'max'=>64),
			array('detect_type', 'length', 'max'=>10),
			array('channel', 'length', 'max'=>50),
			array('user_agent, referral, uri', 'length', 'max'=>255),
			array('event', 'length', 'max'=>100),
			array('os', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, phone, login_ip, device_id, detect_type, loged_time, status, channel, user_agent, package_id, event, referral, os, uri', 'safe', 'on'=>'search'),
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
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('login_ip',$this->login_ip,true);
		$criteria->compare('device_id',$this->device_id,true);
		$criteria->compare('detect_type',$this->detect_type,true);
		$criteria->compare('loged_time',$this->loged_time,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('event',$this->event,true);
		$criteria->compare('referral',$this->referral,true);
		$criteria->compare('os',$this->os,true);
		$criteria->compare('uri',$this->uri,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}