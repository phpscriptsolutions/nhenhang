<?php

/**
 * This is the model class for table "song_deleted".
 *
 * The followings are the available columns in table 'song_deleted':
 * @property string $song_id
 * @property integer $deleted_by
 * @property string $deleted_reason
 * @property string $deleted_time
 */
class BaseSongDeletedModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SongDeleted the static model class
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
		return 'song_deleted';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('song_id', 'required'),
			array('deleted_by', 'numerical', 'integerOnly'=>true),
			array('song_id', 'length', 'max'=>10),
			array('deleted_reason', 'length', 'max'=>255),
			array('deleted_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('song_id, deleted_by, deleted_reason, deleted_time', 'safe', 'on'=>'search'),
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

		$criteria->compare('song_id',$this->song_id,true);
		$criteria->compare('deleted_by',$this->deleted_by);
		$criteria->compare('deleted_reason',$this->deleted_reason,true);
		$criteria->compare('deleted_time',$this->deleted_time,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}