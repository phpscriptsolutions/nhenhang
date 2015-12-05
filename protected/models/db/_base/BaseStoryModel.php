<?php

/**
 * This is the model class for table "story".
 *
 * The followings are the available columns in table 'story':
 * @property integer $id
 * @property string $category_name
 * @property string $category_slug
 * @property integer $category_id
 * @property string $story_name
 * @property string $story_slug
 * @property string $author
 * @property string $description
 * @property string $lastest_chapter
 * @property string $status
 * @property string $updated_time
 * @property string $link
 * @property integer $hot
 * @property string $source
 * @property string $gp_store
 * @property integer $page
 * @property integer $is_crawler
 */
class BaseStoryModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Story the static model class
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
		return 'story';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_name, category_slug, category_id, story_name, story_slug, status, updated_time, link, source', 'required'),
			array('category_id, hot, page, is_crawler', 'numerical', 'integerOnly'=>true),
			array('category_name, category_slug, story_name, story_slug, author, lastest_chapter, link, gp_store', 'length', 'max'=>255),
			array('status, source', 'length', 'max'=>100),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category_name, category_slug, category_id, story_name, story_slug, author, description, lastest_chapter, status, updated_time, link, hot, source, page, is_crawler', 'safe', 'on'=>'search'),
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
		$criteria->compare('category_name',$this->category_name,true);
		$criteria->compare('category_slug',$this->category_slug,true);
		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('story_name',$this->story_name,true);
		$criteria->compare('story_slug',$this->story_slug,true);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('lastest_chapter',$this->lastest_chapter,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('hot',$this->hot);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('page',$this->page);
		$criteria->compare('is_crawler',$this->is_crawler);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}