<?php

/**
 * This is the model class for table "user_setting".
 *
 * The followings are the available columns in table 'user_setting':
 * @property integer $user_id
 * @property integer $email_newsletter
 * @property integer $email_create_playlist
 * @property integer $email_subscribe_playlist
 * @property integer $sms_send_song
 * @property integer $sms_update_artist
 */
class BaseUserSettingModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserSetting the static model class
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
		return 'user_setting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id, email_newsletter, email_create_playlist, email_subscribe_playlist, sms_send_song, sms_update_artist', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, email_newsletter, email_create_playlist, email_subscribe_playlist, sms_send_song, sms_update_artist', 'safe', 'on'=>'search'),
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('email_newsletter',$this->email_newsletter);
		$criteria->compare('email_create_playlist',$this->email_create_playlist);
		$criteria->compare('email_subscribe_playlist',$this->email_subscribe_playlist);
		$criteria->compare('sms_send_song',$this->sms_send_song);
		$criteria->compare('sms_update_artist',$this->sms_update_artist);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}