<?php

/**
 * This is the model class for table "log_sms_mt".
 *
 * The followings are the available columns in table 'log_sms_mt':
 * @property string $id
 * @property string $service_number
 * @property string $sms_id
 * @property string $receive_phone
 * @property string $send_datetime
 * @property integer $sms_type
 * @property string $content
 * @property string $description
 * @property integer $charge
 * @property string $service_name
 * @property string $status
 */
class BaseLogSmsMtModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogSmsMt the static model class
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
		return 'log_sms_mt';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('send_datetime', 'required'),
			array('sms_type, charge', 'numerical', 'integerOnly'=>true),
			array('service_number, receive_phone, service_name', 'length', 'max'=>20),
			array('sms_id', 'length', 'max'=>50),
			array('content', 'length', 'max'=>500),
			array('description, status', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_number, sms_id, receive_phone, send_datetime, sms_type, content, description, charge, service_name, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('service_number',$this->service_number,true);
		$criteria->compare('sms_id',$this->sms_id,true);
		$criteria->compare('receive_phone',$this->receive_phone,true);
		$criteria->compare('send_datetime',$this->send_datetime,true);
		$criteria->compare('sms_type',$this->sms_type);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('charge',$this->charge);
		$criteria->compare('service_name',$this->service_name,true);
		$criteria->compare('status',$this->status,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}