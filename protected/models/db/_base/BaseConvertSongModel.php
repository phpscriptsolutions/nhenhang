<?php

/**
 * This is the model class for table "convert_song".
 *
 * The followings are the available columns in table 'convert_song':
 * @property integer $id
 * @property string $song_id
 * @property string $source_path
 * @property string $profile_ids
 * @property string $begin_time
 * @property string $end_time
 * @property integer $status
 */
class BaseConvertSongModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ConvertSong the static model class
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
		return 'convert_song';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('source_path', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('song_id', 'length', 'max'=>11),
			array('source_path, profile_ids', 'length', 'max'=>255),
			array('begin_time, end_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, song_id, source_path, profile_ids, begin_time, end_time, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('song_id',$this->song_id,true);
		$criteria->compare('source_path',$this->source_path,true);
		$criteria->compare('profile_ids',$this->profile_ids,true);
		$criteria->compare('begin_time',$this->begin_time,true);
		$criteria->compare('end_time',$this->end_time,true);
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