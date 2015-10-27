<?php

/**
 * This is the model class for table "package".
 *
 * The followings are the available columns in table 'package':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property double $fee
 * @property integer $duration
 * @property string $owner
 * @property double $price_song_streaming
 * @property double $price_video_streaming
 * @property double $price_song_download
 * @property double $price_video_download
 * @property double $price_ringtone_download
 * @property string $description
 * @property string $promotion_desc
 * @property string $sms_short_code
 * @property string $sms_command_code
 * @property integer $sorder
 * @property integer $status
 */
class BasePackageModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Package the static model class
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
		return 'package';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name', 'required'),
			array('duration, sorder, status', 'numerical', 'integerOnly'=>true),
			array('fee, price_song_streaming, price_video_streaming, price_song_download, price_video_download, price_ringtone_download', 'numerical'),
			array('code', 'length', 'max'=>20),
			array('name', 'length', 'max'=>160),
			array('owner, description, promotion_desc', 'length', 'max'=>255),
			array('sms_short_code', 'length', 'max'=>12),
			array('sms_command_code', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, name, fee, duration, owner, price_song_streaming, price_video_streaming, price_song_download, price_video_download, price_ringtone_download, description, promotion_desc, sms_short_code, sms_command_code, sorder, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('owner',$this->owner,true);
		$criteria->compare('price_song_streaming',$this->price_song_streaming);
		$criteria->compare('price_video_streaming',$this->price_video_streaming);
		$criteria->compare('price_song_download',$this->price_song_download);
		$criteria->compare('price_video_download',$this->price_video_download);
		$criteria->compare('price_ringtone_download',$this->price_ringtone_download);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('promotion_desc',$this->promotion_desc,true);
		$criteria->compare('sms_short_code',$this->sms_short_code,true);
		$criteria->compare('sms_command_code',$this->sms_command_code,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}