<?php

/**
 * This is the model class for table "news_event".
 *
 * The followings are the available columns in table 'news_event':
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property integer $object_id
 * @property integer $sorder
 * @property string $custom_link
 * @property string $channel
 * @property string $content
 * @property integer $is_web_slidebar
 * @property string $created_time
 * @property string $updated_time
 * @property integer $status
 */
class BaseNewsEventModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return NewsEvent the static model class
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
		return 'news_event';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_time', 'required'),
			array('object_id, sorder, is_web_slidebar, status', 'numerical', 'integerOnly'=>true),
			array('name, custom_link, channel', 'length', 'max'=>255),
			array('type', 'length', 'max'=>10),
			array('content', 'length', 'max'=>500),
			array('updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, type, object_id, sorder, custom_link, channel, content, is_web_slidebar, created_time, updated_time, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('custom_link',$this->custom_link,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('is_web_slidebar',$this->is_web_slidebar);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
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