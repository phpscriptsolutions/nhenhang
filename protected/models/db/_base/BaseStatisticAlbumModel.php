<?php

/**
 * This is the model class for table "statistic_album".
 *
 * The followings are the available columns in table 'statistic_album':
 * @property string $date
 * @property string $album_id
 * @property string $album_name
 * @property string $artist_id
 * @property string $artist_name
 * @property integer $genre_id
 * @property integer $cp_id
 * @property string $played_count
 * @property integer $played_count_web
 * @property integer $played_count_wap
 * @property integer $played_count_api_ios
 * @property integer $played_count_api_android
 * @property integer $played_count_api_winphone
 * @property integer $total_sub_listen
 * @property integer $total_nosub_listen
 */
class BaseStatisticAlbumModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return StatisticAlbum the static model class
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
		return 'statistic_album';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, album_id', 'required'),
			array('genre_id, cp_id, played_count_web, played_count_wap, played_count_api_ios, played_count_api_android, played_count_api_winphone, total_sub_listen, total_nosub_listen', 'numerical', 'integerOnly'=>true),
			array('album_id, artist_id, played_count', 'length', 'max'=>11),
			array('album_name, artist_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, album_id, album_name, artist_id, artist_name, genre_id, cp_id, played_count, played_count_web, played_count_wap, played_count_api_ios, played_count_api_android, played_count_api_winphone, total_sub_listen, total_nosub_listen', 'safe', 'on'=>'search'),
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

		$criteria->compare('date',$this->date,true);
		$criteria->compare('album_id',$this->album_id,true);
		$criteria->compare('album_name',$this->album_name,true);
		$criteria->compare('artist_id',$this->artist_id,true);
		$criteria->compare('artist_name',$this->artist_name,true);
		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('played_count',$this->played_count,true);
		$criteria->compare('played_count_web',$this->played_count_web);
		$criteria->compare('played_count_wap',$this->played_count_wap);
		$criteria->compare('played_count_api_ios',$this->played_count_api_ios);
		$criteria->compare('played_count_api_android',$this->played_count_api_android);
		$criteria->compare('played_count_api_winphone',$this->played_count_api_winphone);
		$criteria->compare('total_sub_listen',$this->total_sub_listen);
		$criteria->compare('total_nosub_listen',$this->total_nosub_listen);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}