<?php

/**
 * This is the model class for table "log_ads_click".
 *
 * The followings are the available columns in table 'log_ads_click':
 * @property integer $id
 * @property string $ads
 * @property string $user_phone
 * @property string $user_ip
 * @property string $user_agent
 * @property integer $is_3g
 * @property string $created_time
 */
class BaseLogAdsClickModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogAdsClick the static model class
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
		return 'log_ads_click';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ads, user_ip, created_time', 'required'),
			array('is_3g', 'numerical', 'integerOnly'=>true),
			array('ads, user_agent', 'length', 'max'=>255),
			array('user_phone, user_ip', 'length', 'max'=>30),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ads, user_phone, user_ip, user_agent, is_3g, created_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('ads',$this->ads,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('user_ip',$this->user_ip,true);
		$criteria->compare('user_agent',$this->user_agent,true);
		$criteria->compare('is_3g',$this->is_3g);
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