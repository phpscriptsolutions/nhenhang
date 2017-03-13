<?php

/**
 * This is the model class for table "max4d".
 *
 * The followings are the available columns in table 'max4d':
 * @property integer $id
 * @property integer $order_lott
 * @property string $day
 * @property string $no_first
 * @property string $no_second1
 * @property string $no_second2
 * @property string $no_third1
 * @property string $no_third2
 * @property string $no_third3
 * @property string $no_fourth1
 * @property string $no_fourth2
 * @property integer $first
 * @property integer $second
 * @property integer $third
 * @property integer $fourth1
 * @property integer $fourth2
 * @property integer $status
 * @property string $created_time
 * @property string $content
 */
class BaseMax4dModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Max4d the static model class
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
		return 'max4d';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_lott, first, second, third, fourth1, fourth2, status', 'numerical', 'integerOnly'=>true),
			array('no_first, no_second1, no_second2, no_third1, no_third2, no_third3, no_fourth1, no_fourth2', 'length', 'max'=>4),
			array('day, created_time, content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_lott, day, no_first, no_second1, no_second2, no_third1, no_third2, no_third3, no_fourth1, no_fourth2, first, second, third, fourth1, fourth2, status, created_time, content', 'safe', 'on'=>'search'),
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
		$criteria->compare('order_lott',$this->order_lott);
		$criteria->compare('day',$this->day,true);
		$criteria->compare('no_first',$this->no_first,true);
		$criteria->compare('no_second1',$this->no_second1,true);
		$criteria->compare('no_second2',$this->no_second2,true);
		$criteria->compare('no_third1',$this->no_third1,true);
		$criteria->compare('no_third2',$this->no_third2,true);
		$criteria->compare('no_third3',$this->no_third3,true);
		$criteria->compare('no_fourth1',$this->no_fourth1,true);
		$criteria->compare('no_fourth2',$this->no_fourth2,true);
		$criteria->compare('first',$this->first);
		$criteria->compare('second',$this->second);
		$criteria->compare('third',$this->third);
		$criteria->compare('fourth1',$this->fourth1);
		$criteria->compare('fourth2',$this->fourth2);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('content',$this->content,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}