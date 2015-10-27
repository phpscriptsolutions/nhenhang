<?php

/**
 * This is the model class for table "log_app".
 *
 * The followings are the available columns in table 'log_app':
 * @property integer $id
 * @property string $device_id
 * @property string $device_name
 * @property string $imei
 * @property string $phone
 * @property string $app_version
 * @property string $activity
 * @property string $channel
 * @property string $network
 * @property string $loged_time
 */
class BaseLogAppModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogApp the static model class
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
		return 'log_app';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id, imei, app_version, loged_time', 'required'),
			array('device_id, device_name', 'length', 'max'=>100),
			array('imei, phone, app_version, activity', 'length', 'max'=>50),
			array('channel, network', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, device_id, device_name, imei, phone, app_version, activity, channel, network, loged_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('device_id',$this->device_id,true);
		$criteria->compare('device_name',$this->device_name,true);
		$criteria->compare('imei',$this->imei,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('app_version',$this->app_version,true);
		$criteria->compare('activity',$this->activity,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('network',$this->network,true);
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