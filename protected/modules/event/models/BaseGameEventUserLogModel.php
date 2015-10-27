<?php

/**
 * This is the model class for table "game_event_user_log".
 *
 * The followings are the available columns in table 'game_event_user_log':
 * @property integer $id
 * @property integer $user_id
 * @property string $user_phone
 * @property integer $ask_id
 * @property integer $answer_id
 * @property integer $point
 * @property integer $thread_id
 * @property string $started_datetime
 * @property string $completed_datetime
 */
class BaseGameEventUserLogModel extends ChachaActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GameEventUserLog the static model class
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
		return 'game_event_user_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, ask_id, answer_id, point, thread_id', 'numerical', 'integerOnly'=>true),
			array('user_phone', 'length', 'max'=>100),
			array('started_datetime, completed_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, user_phone, ask_id, answer_id, point, thread_id, started_datetime, completed_datetime', 'safe', 'on'=>'search'),
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('ask_id',$this->ask_id);
		$criteria->compare('answer_id',$this->answer_id);
		$criteria->compare('point',$this->point);
		$criteria->compare('thread_id',$this->thread_id);
		//$criteria->compare('started_datetime',$this->started_datetime,true);
		$criteria->compare('completed_datetime',$this->completed_datetime,true);
		$criteria->group = 'DATE(started_datetime), user_phone';
		
		if (is_array($this->started_datetime)){
			$criteria->addBetweenCondition('started_datetime', $this->started_datetime[0], $this->started_datetime[1]);
		}
		else
			$criteria->compare('started_datetime',$this->started_datetime,true);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}