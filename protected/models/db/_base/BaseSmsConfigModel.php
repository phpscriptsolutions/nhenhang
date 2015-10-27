<?php

/**
 * This is the model class for table "sms_config".
 *
 * The followings are the available columns in table 'sms_config':
 * @property integer $id
 * @property string $keyword
 * @property string $group_key
 * @property string $index_key
 * @property string $content
 * @property integer $status
 */
class BaseSmsConfigModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SmsConfig the static model class
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
		return 'sms_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('keyword, group_key, index_key, content, status', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('keyword, index_key', 'length', 'max'=>50),
			array('group_key', 'length', 'max'=>20),
			array('content', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, keyword, group_key, index_key, content, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->compare('group_key',$this->group_key,true);
		$criteria->compare('index_key',$this->index_key,true);
		$criteria->compare('content',$this->content,true);
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