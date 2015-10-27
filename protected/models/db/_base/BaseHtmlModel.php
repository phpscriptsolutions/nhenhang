<?php

/**
 * This is the model class for table "html".
 *
 * The followings are the available columns in table 'html':
 * @property integer $id
 * @property string $title
 * @property string $url_key
 * @property string $content
 * @property string $type
 * @property string $updated_time
 * @property string $updated_by
 * @property string $channel
 * @property integer $pos
 */
class BaseHtmlModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Html the static model class
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
		return 'html';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, url_key, content', 'required'),
			array('pos', 'numerical', 'integerOnly'=>true),
			array('title, url_key', 'length', 'max'=>255),
			array('type, updated_by', 'length', 'max'=>10),
			array('channel', 'length', 'max'=>45),
			array('updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, url_key, content, type, updated_time, updated_by, channel, pos', 'safe', 'on'=>'search'),
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('url_key',$this->url_key,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('pos',$this->pos);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}