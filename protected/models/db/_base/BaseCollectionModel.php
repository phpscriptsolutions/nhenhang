<?php

/**
 * This is the model class for table "collection".
 *
 * The followings are the available columns in table 'collection':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $type
 * @property integer $mode
 * @property string $sql_query
 * @property string $genre_ids
 * @property integer $sorder
 * @property integer $status
 * @property integer $require_genre_id
 * @property integer $home_page
 * @property integer $web_home_page
 * @property integer $limit_items_toppage
 * @property string $link
 * @property string $cc_type
 * @property string $cc_genre
 * @property integer $cc_week_num
 * @property string $cc_week_begin
 * @property string $cc_week_end
 */
class BaseCollectionModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Collection the static model class
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
		return 'collection';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code', 'required'),
			array('mode, sorder, status, require_genre_id, home_page, web_home_page, limit_items_toppage, cc_week_num', 'numerical', 'integerOnly'=>true),
			array('name, link', 'length', 'max'=>255),
			array('code', 'length', 'max'=>50),
			array('type', 'length', 'max'=>14),
			array('genre_ids', 'length', 'max'=>150),
			array('cc_type, cc_genre', 'length', 'max'=>30),
			array('sql_query, cc_week_begin, cc_week_end', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, code, type, mode, sql_query, genre_ids, sorder, status, require_genre_id, home_page, web_home_page, limit_items_toppage, link, cc_type, cc_genre, cc_week_num, cc_week_begin, cc_week_end', 'safe', 'on'=>'search'),
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('mode',$this->mode);
		$criteria->compare('sql_query',$this->sql_query,true);
		$criteria->compare('genre_ids',$this->genre_ids,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->compare('require_genre_id',$this->require_genre_id);
		$criteria->compare('home_page',$this->home_page);
		$criteria->compare('web_home_page',$this->web_home_page);
		$criteria->compare('limit_items_toppage',$this->limit_items_toppage);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('cc_type',$this->cc_type,true);
		$criteria->compare('cc_genre',$this->cc_genre,true);
		$criteria->compare('cc_week_num',$this->cc_week_num);
		$criteria->compare('cc_week_begin',$this->cc_week_begin,true);
		$criteria->compare('cc_week_end',$this->cc_week_end,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}