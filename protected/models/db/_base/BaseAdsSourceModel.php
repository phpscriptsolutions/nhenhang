<?php

/**
 * This is the model class for table "ads_source".
 *
 * The followings are the available columns in table 'ads_source':
 * @property integer $id
 * @property string $name
 * @property string $url_key
 * @property string $code
 * @property string $action
 * @property string $domain
 * @property string $short_link
 * @property string $dest_link
 * @property integer $package_id
 * @property string $description
 * @property string $created_datetime
 * @property integer $status
 */
class BaseAdsSourceModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return AdsSource the static model class
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
		return 'ads_source';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url_key, code, domain, short_link, dest_link', 'required'),
			array('package_id, status', 'numerical', 'integerOnly'=>true),
			array('name, url_key, short_link, dest_link', 'length', 'max'=>255),
			array('code, action, domain', 'length', 'max'=>100),
			array('description, created_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url_key, code, action, domain, short_link, dest_link, package_id, description, created_datetime, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('domain',$this->domain,true);
		$criteria->compare('short_link',$this->short_link,true);
		$criteria->compare('dest_link',$this->dest_link,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_datetime',$this->created_datetime,true);
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