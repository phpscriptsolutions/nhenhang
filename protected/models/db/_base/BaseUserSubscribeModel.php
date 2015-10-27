<?php

/**
 * This is the model class for table "user_subscribe".
 *
 * The followings are the available columns in table 'user_subscribe':
 * @property string $id
 * @property integer $user_id
 * @property string $user_phone
 * @property integer $package_id
 * @property integer $bundle
 * @property string $source
 * @property string $event
 * @property string $extended_count
 * @property integer $extended_retry_times
 * @property string $last_retry_time
 * @property integer $retry_on_day
 * @property string $created_time
 * @property string $extended_time
 * @property string $expired_time
 * @property string $updated_time
 * @property string $last_subscribe_time
 * @property string $last_unsubscribe_time
 * @property string $last_action
 * @property integer $remain_status
 * @property integer $notify_sms
 * @property integer $status
 * @property integer $time_remain
 * @property integer $time_streaming
 */
class BaseUserSubscribeModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserSubscribe the static model class
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
		return 'user_subscribe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, user_phone, package_id, extended_count, created_time, expired_time, updated_time', 'required'),
			array('user_id, package_id, bundle, extended_retry_times, retry_on_day, remain_status, notify_sms, status, time_remain, time_streaming', 'numerical', 'integerOnly'=>true),
			array('user_phone', 'length', 'max'=>16),
			array('source, last_action', 'length', 'max'=>20),
			array('event', 'length', 'max'=>100),
			array('extended_count', 'length', 'max'=>10),
			array('last_retry_time, extended_time, last_subscribe_time, last_unsubscribe_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, user_phone, package_id, bundle, source, event, extended_count, extended_retry_times, last_retry_time, retry_on_day, created_time, extended_time, expired_time, updated_time, last_subscribe_time, last_unsubscribe_time, last_action, remain_status, notify_sms, status, time_remain, time_streaming', 'safe', 'on'=>'search'),
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
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('bundle',$this->bundle);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('event',$this->event,true);
		$criteria->compare('extended_count',$this->extended_count,true);
		$criteria->compare('extended_retry_times',$this->extended_retry_times);
		$criteria->compare('last_retry_time',$this->last_retry_time,true);
		$criteria->compare('retry_on_day',$this->retry_on_day);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('extended_time',$this->extended_time,true);
		$criteria->compare('expired_time',$this->expired_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('last_subscribe_time',$this->last_subscribe_time,true);
		$criteria->compare('last_unsubscribe_time',$this->last_unsubscribe_time,true);
		$criteria->compare('last_action',$this->last_action,true);
		$criteria->compare('remain_status',$this->remain_status);
		$criteria->compare('notify_sms',$this->notify_sms);
		$criteria->compare('status',$this->status);
		$criteria->compare('time_remain',$this->time_remain);
		$criteria->compare('time_streaming',$this->time_streaming);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}