<?php

/**
 * This is the model class for table "sms_queue_push_system".
 *
 * The followings are the available columns in table 'sms_queue_push_system':
 * @property integer $id
 * @property string $sender
 * @property string $receiver
 * @property string $sms_content
 * @property string $action
 * @property integer $status
 * @property string $send_time
 * @property string $created_time
 * @property string $note
 * @property string $params
 */
class BaseSmsQueuePushSystemModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SmsQueuePushSystem the static model class
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
		return 'sms_queue_push_system';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status', 'numerical', 'integerOnly'=>true),
			array('sender, receiver', 'length', 'max'=>50),
			array('action', 'length', 'max'=>100),
			array('sms_content, send_time, created_time, note, params', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sender, receiver, sms_content, action, status, send_time, created_time, note, params', 'safe', 'on'=>'search'),
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
		$criteria->compare('sender',$this->sender,true);
		$criteria->compare('receiver',$this->receiver,true);
		$criteria->compare('sms_content',$this->sms_content,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('send_time',$this->send_time,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('params',$this->params,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}