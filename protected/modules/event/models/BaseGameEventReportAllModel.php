<?php

/**
 * This is the model class for table "game_event_report_all".
 *
 * The followings are the available columns in table 'game_event_report_all':
 * @property string $date
 * @property integer $total_sub
 * @property integer $total_unsub
 * @property integer $access_event
 * @property integer $access_play
 * @property integer $total_play_all
 * @property integer $total_msisdn_valid
 * @property integer $listen_music
 * @property integer $download_music
 * @property integer $play_video
 * @property integer $download_video
 * @property integer $have_transaction
 */
class BaseGameEventReportAllModel extends ChachaActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GameEventReportAll the static model class
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
		return 'game_event_report_all';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('total_sub, total_unsub, access_event, access_play, total_play_all, total_msisdn_valid, listen_music, download_music, play_video, download_video, have_transaction', 'numerical', 'integerOnly'=>true),
			array('date', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date, total_sub, total_unsub, access_event, access_play, total_play_all, total_msisdn_valid, listen_music, download_music, play_video, download_video, have_transaction', 'safe', 'on'=>'search'),
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

		//$criteria->compare('date',$this->date,true);
		$criteria->compare('total_sub',$this->total_sub);
		$criteria->compare('total_unsub',$this->total_unsub);
		$criteria->compare('access_event',$this->access_event);
		$criteria->compare('access_play',$this->access_play);
		$criteria->compare('total_play_all',$this->total_play_all);
		$criteria->compare('total_msisdn_valid',$this->total_msisdn_valid);
		$criteria->compare('listen_music',$this->listen_music);
		$criteria->compare('download_music',$this->download_music);
		$criteria->compare('play_video',$this->play_video);
		$criteria->compare('download_video',$this->download_video);
		$criteria->compare('have_transaction',$this->have_transaction);
		
		if (is_array($this->date)){
			$criteria->addBetweenCondition('date', $this->date[0], $this->date[1]);
		}
		else
			$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}