<?php

/**
 * This is the model class for table "banner".
 *
 * The followings are the available columns in table 'banner':
 * @property integer $id
 * @property string $type
 * @property string $channel
 * @property string $name
 * @property string $url
 * @property string $position
 * @property string $start_time
 * @property string $expired_time
 * @property string $image_file
 * @property string $params
 * @property integer $apply_user
 * @property integer $width
 * @property integer $height
 * @property integer $rate
 * @property integer $log_click
 * @property integer $status
 * @property integer $sorder
 */
class BaseBannerModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Banner the static model class
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
		return 'banner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, url, start_time, expired_time', 'required'),
			array('apply_user, width, height, rate, log_click, status, sorder', 'numerical', 'integerOnly'=>true),
			array('type, channel', 'length', 'max'=>10),
			array('name', 'length', 'max'=>50),
			array('url', 'length', 'max'=>400),
			array('position, image_file', 'length', 'max'=>20),
			array('params', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, channel, name, url, position, start_time, expired_time, image_file, params, apply_user, width, height, rate, log_click, status, sorder', 'safe', 'on'=>'search'),
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('expired_time',$this->expired_time,true);
		$criteria->compare('image_file',$this->image_file,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('apply_user',$this->apply_user);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('log_click',$this->log_click);
		$criteria->compare('status',$this->status);
		$criteria->compare('sorder',$this->sorder);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}