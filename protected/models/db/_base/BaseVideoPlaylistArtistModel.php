<?php

/**
 * This is the model class for table "video_playlist_artist".
 *
 * The followings are the available columns in table 'video_playlist_artist':
 * @property integer $video_playlist_id
 * @property integer $artist_id
 * @property string $artist_name
 * @property integer $video_playlist_status
 */
class BaseVideoPlaylistArtistModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VideoPlaylistArtist the static model class
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
		return 'video_playlist_artist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('video_playlist_id, artist_id, video_playlist_status', 'numerical', 'integerOnly'=>true),
			array('artist_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('video_playlist_id, artist_id, artist_name, video_playlist_status', 'safe', 'on'=>'search'),
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

		$criteria->compare('video_playlist_id',$this->video_playlist_id);
		$criteria->compare('artist_id',$this->artist_id);
		$criteria->compare('artist_name',$this->artist_name,true);
		$criteria->compare('video_playlist_status',$this->video_playlist_status);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}