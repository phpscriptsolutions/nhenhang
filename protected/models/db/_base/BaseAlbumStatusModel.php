<?php

/**
 * This is the model class for table "album_status".
 *
 * The followings are the available columns in table 'album_status':
 * @property string $album_id
 * @property integer $approve_status
 * @property integer $artist_status
 * @property string $artist_id
 * @property integer $copyright_status
 */
class BaseAlbumStatusModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AlbumStatus the static model class
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
		return 'album_status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('album_id', 'required'),
			array('approve_status, artist_status, copyright_status', 'numerical', 'integerOnly'=>true),
			array('album_id, artist_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('album_id, approve_status, artist_status, artist_id, copyright_status', 'safe', 'on'=>'search'),
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

		$criteria->compare('album_id',$this->album_id,true);
		$criteria->compare('approve_status',$this->approve_status);
		$criteria->compare('artist_status',$this->artist_status);
		$criteria->compare('artist_id',$this->artist_id,true);
		$criteria->compare('copyright_status',$this->copyright_status);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}