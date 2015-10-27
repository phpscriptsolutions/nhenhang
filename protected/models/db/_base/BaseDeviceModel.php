<?php

/**
 * This is the model class for table "device".
 *
 * The followings are the available columns in table 'device':
 * @property string $id
 * @property string $device_id
 * @property string $model
 * @property string $brand
 * @property string $marketing_name
 * @property string $description
 * @property string $os
 * @property string $resolution
 * @property string $error_code
 * @property string $song_profile_ids
 * @property string $audio_protocol
 * @property string $video_profile_ids
 * @property string $video_protocol
 */
class BaseDeviceModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Device the static model class
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
		return 'device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id, model', 'length', 'max'=>100),
			array('brand', 'length', 'max'=>50),
			array('marketing_name', 'length', 'max'=>30),
			array('description', 'length', 'max'=>255),
			array('os, song_profile_ids, video_profile_ids', 'length', 'max'=>45),
			array('resolution', 'length', 'max'=>15),
			array('error_code', 'length', 'max'=>20),
			array('audio_protocol, video_protocol', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, device_id, model, brand, marketing_name, description, os, resolution, error_code, song_profile_ids, audio_protocol, video_profile_ids, video_protocol', 'safe', 'on'=>'search'),
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
		$criteria->compare('device_id',$this->device_id,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('marketing_name',$this->marketing_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('os',$this->os,true);
		$criteria->compare('resolution',$this->resolution,true);
		$criteria->compare('error_code',$this->error_code,true);
		$criteria->compare('song_profile_ids',$this->song_profile_ids,true);
		$criteria->compare('audio_protocol',$this->audio_protocol,true);
		$criteria->compare('video_profile_ids',$this->video_profile_ids,true);
		$criteria->compare('video_protocol',$this->video_protocol,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}