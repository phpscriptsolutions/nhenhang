<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $id
 * @property string $title
 * @property string $intro
 * @property string $content
 * @property string $avatar
 * @property string $url
 * @property string $related_artists
 * @property integer $total_view
 * @property integer $created_by
 * @property string $created_time
 * @property integer $sorder
 * @property integer $status
 * @property integer $featured
 */
class BaseNewsModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return News the static model class
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
		return 'news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, intro, avatar, url, created_by, created_time', 'required'),
			array('total_view, created_by, sorder, status, featured', 'numerical', 'integerOnly'=>true),
			array('title, avatar, url, related_artists', 'length', 'max'=>255),
			array('intro', 'length', 'max'=>500),
			array('content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, intro, content, avatar, url, related_artists, total_view, created_by, created_time, sorder, status, featured', 'safe', 'on'=>'search'),
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
		$criteria->compare('intro',$this->intro,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('related_artists',$this->related_artists,true);
		$criteria->compare('total_view',$this->total_view);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('featured',$this->featured);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}