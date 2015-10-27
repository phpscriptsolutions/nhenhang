<?php

/**
 * This is the model class for table "genre".
 *
 * The followings are the available columns in table 'genre':
 * @property integer $id
 * @property string $name
 * @property string $url_key
 * @property integer $parent_id
 * @property string $description
 * @property integer $created_by
 * @property string $created_time
 * @property string $updated_time
 * @property integer $sorder
 * @property integer $status
 * @property integer $is_new
 * @property integer $is_hot
 * @property integer $is_collection
 * @property integer $cmc_id
 * @property string $type
 */
class BaseGenreModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Genre the static model class
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
		return 'genre';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, created_by', 'required'),
			array('parent_id, created_by, sorder, status, is_new, is_hot, is_collection, cmc_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>150),
			array('url_key, description', 'length', 'max'=>255),
			array('type', 'length', 'max'=>10),
			array('created_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url_key, parent_id, description, created_by, created_time, updated_time, sorder, status, is_new, is_hot, is_collection, cmc_id, type', 'safe', 'on'=>'search'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('is_new',$this->is_new);
		$criteria->compare('is_hot',$this->is_hot);
		$criteria->compare('is_collection',$this->is_collection);
		$criteria->compare('cmc_id',$this->cmc_id);
		$criteria->compare('type',$this->type,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}