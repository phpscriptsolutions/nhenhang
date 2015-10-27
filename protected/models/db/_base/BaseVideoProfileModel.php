<?php

/**
 * This is the model class for table "video_profile".
 *
 * The followings are the available columns in table 'video_profile':
 * @property integer $id
 * @property string $profile_id
 * @property string $name
 * @property string $quality_name
 * @property string $format
 * @property integer $http_support
 * @property integer $rtsp_support
 * @property integer $rtmp_support
 * @property integer $sorder
 * @property integer $status
 */
class BaseVideoProfileModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VideoProfile the static model class
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
		return 'video_profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('profile_id, name', 'required'),
			array('http_support, rtsp_support, rtmp_support, sorder, status', 'numerical', 'integerOnly'=>true),
			array('profile_id', 'length', 'max'=>10),
			array('name', 'length', 'max'=>45),
			array('quality_name', 'length', 'max'=>20),
			array('format', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, profile_id, name, quality_name, format, http_support, rtsp_support, rtmp_support, sorder, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('profile_id',$this->profile_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('quality_name',$this->quality_name,true);
		$criteria->compare('format',$this->format,true);
		$criteria->compare('http_support',$this->http_support);
		$criteria->compare('rtsp_support',$this->rtsp_support);
		$criteria->compare('rtmp_support',$this->rtmp_support);
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