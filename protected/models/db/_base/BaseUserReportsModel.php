<?php

/**
 * This is the model class for table "user_reports".
 *
 * The followings are the available columns in table 'user_reports':
 * @property integer $id
 * @property string $subject
 * @property string $content
 * @property integer $content_id
 * @property string $content_type
 * @property integer $user_id
 * @property string $user_phone
 * @property string $ip
 * @property string $user_agent
 * @property string $ref
 * @property string $platform
 * @property string $os
 * @property string $os_version
 * @property string $browse
 * @property string $browse_version
 * @property string $created_time
 * @property string $updated_time
 * @property string $note
 * @property integer $status
 * @property string $error_code
 * @property string $error_message
 * @property string $error_type
 */
class BaseUserReportsModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserReports the static model class
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
		return 'user_reports';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content_id, user_id, status', 'numerical', 'integerOnly'=>true),
			array('subject, ref, note, error_message', 'length', 'max'=>255),
			array('content_type, os_version, browse_version', 'length', 'max'=>10),
			array('user_phone, os, browse', 'length', 'max'=>20),
			array('ip', 'length', 'max'=>25),
			array('user_agent', 'length', 'max'=>500),
			array('platform, error_code, error_type', 'length', 'max'=>100),
			array('content, created_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subject, content, content_id, content_type, user_id, user_phone, ip, user_agent, ref, platform, os, os_version, browse, browse_version, created_time, updated_time, note, status, error_code, error_message, error_type', 'safe', 'on'=>'search'),
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
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('content_id',$this->content_id);
		$criteria->compare('content_type',$this->content_type,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('ref',$this->ref,true);
		$criteria->compare('platform',$this->platform,true);
		$criteria->compare('os',$this->os,true);
		$criteria->compare('os_version',$this->os_version,true);
		$criteria->compare('browse',$this->browse,true);
		$criteria->compare('browse_version',$this->browse_version,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('error_code',$this->error_code,true);
		$criteria->compare('error_message',$this->error_message,true);
		$criteria->compare('error_type',$this->error_type,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}