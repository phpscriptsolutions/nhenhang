<?php

/**
 * This is the model class for table "album_play".
 *
 * The followings are the available columns in table 'album_play':
 * @property string $id
 * @property string $album_id
 * @property string $album_name
 * @property string $user_id
 * @property string $user_phone
 * @property string $user_ip
 * @property string $activity_id
 * @property string $loged_time
 */
class BaseAlbumPlayModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AlbumPlay the static model class
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
		return 'album_play';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('album_id, user_id', 'length', 'max'=>10),
			array('album_name', 'length', 'max'=>255),
			array('user_phone', 'length', 'max'=>30),
			array('user_ip', 'length', 'max'=>100),
			array('activity_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, album_id, album_name, user_id, user_phone, user_ip, activity_id, loged_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('album_id',$this->album_id,true);
		$criteria->compare('album_name',$this->album_name,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('user_ip',$this->user_ip,true);
		$criteria->compare('activity_id',$this->activity_id,true);
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