<?php

/**
 * This is the model class for table "user_activity".
 *
 * The followings are the available columns in table 'user_activity':
 * @property string $id
 * @property string $user_id
 * @property string $user_phone
 * @property string $user_ip
 * @property string $user_agent
 * @property string $activity
 * @property string $channel
 * @property string $obj_id
 * @property string $obj_name
 * @property string $note
 * @property string $from_ads
 * @property string $media_url
 * @property string $uri
 * @property string $referrer
 * @property string $loged_time
 */
class BaseUserActivityModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserActivity the static model class
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
		return 'user_activity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('loged_time', 'required'),
			array('user_id, obj_id', 'length', 'max'=>10),
			array('user_phone', 'length', 'max'=>16),
			array('user_ip', 'length', 'max'=>100),
			array('user_agent', 'length', 'max'=>500),
			array('activity, channel', 'length', 'max'=>50),
			array('obj_name', 'length', 'max'=>160),
			array('note, from_ads', 'length', 'max'=>150),
			array('media_url, uri, referrer', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, user_phone, user_ip, user_agent, activity, channel, obj_id, obj_name, note, from_ads, media_url, uri, referrer, loged_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('user_ip',$this->user_ip,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('activity',$this->activity,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('obj_id',$this->obj_id,true);
		$criteria->compare('obj_name',$this->obj_name,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('from_ads',$this->from_ads,true);
		$criteria->compare('media_url',$this->media_url,true);
		$criteria->compare('uri',$this->uri,true);
		$criteria->compare('referrer',$this->referrer,true);
		$criteria->compare('loged_time',$this->loged_time,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}