<?php

/**
 * This is the model class for table "genre_metadata".
 *
 * The followings are the available columns in table 'genre_metadata':
 * @property integer $genre_id
 * @property string $meta_key
 * @property string $meta_value
 * @property string $description
 */
class BaseGenreMetadataModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GenreMetadata the static model class
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
		return 'genre_metadata';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('genre_id', 'required'),
			array('genre_id', 'numerical', 'integerOnly'=>true),
			array('meta_key', 'length', 'max'=>100),
			array('meta_value', 'length', 'max'=>500),
			array('description', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('genre_id, meta_key, meta_value, description', 'safe', 'on'=>'search'),
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

		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('meta_key',$this->meta_key,true);
		$criteria->compare('meta_value',$this->meta_value,true);
		$criteria->compare('description',$this->description,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}