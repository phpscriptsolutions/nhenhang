<?php

/**
 * This is the model class for table "artist".
 *
 * The followings are the available columns in table 'artist':
 * @property string $id
 * @property string $name
 * @property string $url_key
 * @property string $description
 * @property string $song_count
 * @property string $video_count
 * @property string $album_count
 * @property string $fan_count
 * @property integer $genre_id
 * @property string $type
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_time
 * @property string $updated_time
 * @property integer $sorder
 * @property integer $status
 * @property string $artist_key
 * @property string $song_ids
 * @property integer $cmc_id
 */
class BaseArtistModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Artist the static model class
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
		return 'artist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url_key', 'required'),
			array('genre_id, created_by, updated_by, sorder, status, cmc_id', 'numerical', 'integerOnly'=>true),
			array('name, url_key', 'length', 'max'=>160),
			array('song_count, video_count, album_count, fan_count', 'length', 'max'=>10),
			array('type', 'length', 'max'=>50),
			array('artist_key', 'length', 'max'=>45),
			array('song_ids', 'length', 'max'=>200),
			array('description, created_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url_key, description, song_count, video_count, album_count, fan_count, genre_id, type, created_by, updated_by, created_time, updated_time, sorder, status, artist_key, song_ids, cmc_id', 'safe', 'on'=>'search'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('song_count',$this->song_count,true);
		$criteria->compare('video_count',$this->video_count,true);
		$criteria->compare('album_count',$this->album_count,true);
		$criteria->compare('fan_count',$this->fan_count,true);
		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('artist_key',$this->artist_key,true);
		$criteria->compare('song_ids',$this->song_ids,true);
		$criteria->compare('cmc_id',$this->cmc_id);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}