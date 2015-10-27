<?php

/**
 * This is the model class for table "radio".
 *
 * The followings are the available columns in table 'radio':
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property string $type
 * @property string $time_point
 * @property string $day_week
 * @property string $object_ids
 * @property integer $ordering
 * @property integer $status
 * @property string $created_time
 * @property string $updated_time
 * @property string $day_to_time
 */
class BaseRadioModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Radio the static model class
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
		return 'radio';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('parent_id, ordering, status', 'numerical', 'integerOnly'=>true),
			array('name, day_to_time', 'length', 'max'=>255),
			array('type', 'length', 'max'=>8),
			array('time_point, day_week', 'length', 'max'=>50),
			array('object_ids', 'length', 'max'=>100),
			array('created_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, parent_id, type, time_point, day_week, object_ids, ordering, status, created_time, updated_time, day_to_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('time_point',$this->time_point,true);
		$criteria->compare('day_week',$this->day_week,true);
		$criteria->compare('object_ids',$this->object_ids,true);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('day_to_time',$this->day_to_time,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}