<?php

/**
 * This is the model class for table "game_event_report_day".
 *
 * The followings are the available columns in table 'game_event_report_day':
 * @property string $user_phone
 * @property string $date
 * @property integer $point
 * @property integer $time_total
 * @property string $time_start
 * @property string $time_end
 */
class BaseGameEventReportDayModel extends ChachaActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GameEventReportDay the static model class
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
		return 'game_event_report_day';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('point, time_total', 'numerical', 'integerOnly'=>true),
			array('user_phone', 'length', 'max'=>100),
			array('date', 'length', 'max'=>50),
			array('time_start, time_end', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_phone, date, point, time_total, time_start, time_end', 'safe', 'on'=>'search'),
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

		$criteria->compare('user_phone',$this->user_phone,true);
		//$criteria->compare('date',$this->date,true);
		$criteria->compare('point',$this->point);
		$criteria->compare('time_total',$this->time_total);
		//$criteria->compare('time_start',$this->time_start,true);
		$criteria->compare('time_end',$this->time_end,true);
		
		
		if (is_array($this->time_start)){
			$criteria->addBetweenCondition('time_start', $this->time_start[0], $this->time_start[1]);
		}
		else
			$criteria->compare('time_start',$this->time_start,true);
		
		$criteria->group = 'date(time_start), user_phone';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}