<?php

/**
 * This is the model class for table "log_sms_mo".
 *
 * The followings are the available columns in table 'log_sms_mo':
 * @property string $id
 * @property string $service_number
 * @property string $sms_id
 * @property string $sender_phone
 * @property string $receive_time
 * @property string $keyword
 * @property string $content
 * @property string $auth_user
 * @property string $auth_pass
 * @property integer $output_id
 * @property string $status
 */
class BaseLogSmsMoModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogSmsMo the static model class
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
		return 'log_sms_mo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('receive_time', 'required'),
			array('output_id', 'numerical', 'integerOnly'=>true),
			array('service_number, sender_phone, keyword, auth_user, auth_pass', 'length', 'max'=>20),
			array('sms_id', 'length', 'max'=>50),
			array('content, status', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_number, sms_id, sender_phone, receive_time, keyword, content, auth_user, auth_pass, output_id, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('sender_phone',$this->sender_phone,true);
		$criteria->compare('receive_time',$this->receive_time,true);
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('auth_user',$this->auth_user,true);
		$criteria->compare('auth_pass',$this->auth_pass,true);
		$criteria->compare('output_id',$this->output_id);
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