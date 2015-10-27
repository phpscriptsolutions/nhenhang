<?php

/**
 * This is the model class for table "video_playlist".
 *
 * The followings are the available columns in table 'video_playlist':
 * @property string $id
 * @property string $name
 * @property string $url_key
 * @property integer $genre_id
 * @property string $artist_id
 * @property string $artist_name
 * @property integer $video_count
 * @property integer $price
 * @property string $publisher
 * @property string $published_date
 * @property string $description
 * @property integer $created_by
 * @property integer $approved_by
 * @property integer $updated_by
 * @property integer $cp_id
 * @property string $created_time
 * @property string $updated_time
 * @property integer $sorder
 * @property integer $status
 * @property integer $played_count
 * @property string $cmc_id
 */
class BaseVideoPlaylistModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return VideoPlaylist the static model class
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
		return 'video_playlist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url_key, artist_name', 'required'),
			array('genre_id, video_count, price, created_by, approved_by, updated_by, cp_id, sorder, status, played_count', 'numerical', 'integerOnly'=>true),
			array('name, url_key, artist_name', 'length', 'max'=>160),
			array('artist_id', 'length', 'max'=>10),
			array('publisher', 'length', 'max'=>50),
			array('updated_time', 'length', 'max'=>45),
			array('cmc_id', 'length', 'max'=>11),
			array('published_date, description, created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url_key, genre_id, artist_id, artist_name, video_count, price, publisher, published_date, description, created_by, approved_by, updated_by, cp_id, created_time, updated_time, sorder, status, played_count, cmc_id', 'safe', 'on'=>'search'),
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
		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('artist_id',$this->artist_id,true);
		$criteria->compare('artist_name',$this->artist_name,true);
		$criteria->compare('video_count',$this->video_count);
		$criteria->compare('price',$this->price);
		$criteria->compare('publisher',$this->publisher,true);
		$criteria->compare('published_date',$this->published_date,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('approved_by',$this->approved_by);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('played_count',$this->played_count);
		$criteria->compare('cmc_id',$this->cmc_id,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}