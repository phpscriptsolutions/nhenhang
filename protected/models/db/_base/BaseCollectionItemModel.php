<?php

/**
 * This is the model class for table "collection_item".
 *
 * The followings are the available columns in table 'collection_item':
 * @property string $id
 * @property integer $collect_id
 * @property integer $item_id
 * @property string $item_name
 * @property integer $sorder
 * @property integer $created_by
 * @property string $created_time
 */
class BaseCollectionItemModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CollectionItem the static model class
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
		return 'collection_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('collect_id, item_id', 'required'),
			array('collect_id, item_id, sorder, created_by', 'numerical', 'integerOnly'=>true),
			array('item_name', 'length', 'max'=>255),
			array('created_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, collect_id, item_id, item_name, sorder, created_by, created_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('collect_id',$this->collect_id);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('item_name',$this->item_name,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}