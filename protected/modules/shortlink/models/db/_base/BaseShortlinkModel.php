<?php

/**
 * This is the model class for table "shortlink".
 *
 * The followings are the available columns in table 'shortlink':
 * @property integer $id
 * @property string $prefix
 * @property string $url_key
 * @property string $domain
 * @property string $shortlink
 * @property string $dest_link
 * @property string $created_datetime
 * @property integer $status
 */
class BaseShortlinkModel extends ChachaActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Shortlink the static model class
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
		return 'shortlink';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url_key, domain, dest_link', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('prefix, url_key, shortlink', 'length', 'max'=>255),
			array('domain', 'length', 'max'=>100),
			array('dest_link', 'length', 'max'=>500),
			array('created_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, prefix, url_key, domain, shortlink, dest_link, created_datetime, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('prefix',$this->prefix,true);
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('domain',$this->domain,true);
		$criteria->compare('shortlink',$this->shortlink,true);
		$criteria->compare('dest_link',$this->dest_link,true);
		$criteria->compare('created_datetime',$this->created_datetime,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}