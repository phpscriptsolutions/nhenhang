<?php

/**
 * This is the model class for table "mega645".
 *
 * The followings are the available columns in table 'mega645':
 * @property integer $id
 * @property string $order_lott
 * @property string $day
 * @property string $no1
 * @property string $no2
 * @property string $no3
 * @property string $no4
 * @property string $no5
 * @property string $no6
 * @property string $no_win
 * @property integer $jackpot
 * @property integer $first
 * @property integer $second
 * @property integer $third
 * @property string $money
 * @property integer $status
 * @property string $created_time
 * @property string $content
 * @property string $next_money
 */
class BaseMega645Model extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Mega645 the static model class
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
		return 'mega645';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('jackpot, first, second, third, status', 'numerical', 'integerOnly'=>true),
			array('order_lott', 'length', 'max'=>20),
			array('no1, no2, no3, no4, no5, no6', 'length', 'max'=>2),
			array('no_win', 'length', 'max'=>12),
			array('money', 'length', 'max'=>15),
			array('next_money', 'length', 'max'=>255),
			array('day, created_time, content', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_lott, day, no1, no2, no3, no4, no5, no6, no_win, jackpot, first, second, third, money, status, created_time, content, next_money', 'safe', 'on'=>'search'),
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
		$criteria->compare('order_lott',$this->order_lott,true);
		$criteria->compare('day',$this->day,true);
		$criteria->compare('no1',$this->no1,true);
		$criteria->compare('no2',$this->no2,true);
		$criteria->compare('no3',$this->no3,true);
		$criteria->compare('no4',$this->no4,true);
		$criteria->compare('no5',$this->no5,true);
		$criteria->compare('no6',$this->no6,true);
		$criteria->compare('no_win',$this->no_win,true);
		$criteria->compare('jackpot',$this->jackpot);
		$criteria->compare('first',$this->first);
		$criteria->compare('second',$this->second);
		$criteria->compare('third',$this->third);
		$criteria->compare('money',$this->money,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('next_money',$this->next_money,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}