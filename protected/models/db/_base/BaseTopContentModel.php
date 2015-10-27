<?php

/**
 * This is the model class for table "top_content".
 *
 * The followings are the available columns in table 'top_content':
 * @property integer $id
 * @property string $name
 * @property string $group
 * @property string $type
 * @property integer $content_id
 * @property string $link
 * @property integer $sorder
 * @property integer $status
 * @property string $description
 * @property string $updated_time
 */
class BaseTopContentModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TopContent the static model class
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
		return 'top_content';
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
			array('content_id, sorder, status', 'numerical', 'integerOnly'=>true),
			array('name, link', 'length', 'max'=>255),
			array('group', 'length', 'max'=>5),
			array('type', 'length', 'max'=>14),
			array('description, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, group, type, content_id, link, sorder, status, description, updated_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('group',$this->group,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('content_id',$this->content_id);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}