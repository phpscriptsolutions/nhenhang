<?php

/**
 * This is the model class for table "search_logs".
 *
 * The followings are the available columns in table 'search_logs':
 * @property integer $id
 * @property string $keyword
 * @property integer $total_search
 * @property string $user_phone
 * @property string $type
 * @property string $search_datetime
 * @property string $source
 */
class BaseSearchLogsModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return SearchLogs the static model class
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
		return 'search_logs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('total_search', 'numerical', 'integerOnly'=>true),
			array('keyword', 'length', 'max'=>255),
			array('user_phone', 'length', 'max'=>50),
			array('type', 'length', 'max'=>100),
			array('source', 'length', 'max'=>10),
			array('search_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, keyword, total_search, user_phone, type, search_datetime, source', 'safe', 'on'=>'search'),
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
		$criteria->compare('total_search',$this->total_search);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('search_datetime',$this->search_datetime,true);
		$criteria->compare('source',$this->source,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}