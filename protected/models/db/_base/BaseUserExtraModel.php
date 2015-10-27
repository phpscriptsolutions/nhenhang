<?php

/**
 * This is the model class for table "user_extra".
 *
 * The followings are the available columns in table 'user_extra':
 * @property integer $user_id
 * @property string $introduction
 * @property string $cmnd
 * @property integer $deleted_by
 * @property string $deleted_reason
 * @property string $birthday
 * @property integer $flag_username
 */
class BaseUserExtraModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserExtra the static model class
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
		return 'user_extra';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id, deleted_by, flag_username', 'numerical', 'integerOnly'=>true),
			array('introduction', 'length', 'max'=>500),
			array('cmnd', 'length', 'max'=>20),
			array('deleted_reason', 'length', 'max'=>255),
			array('birthday', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, introduction, cmnd, deleted_by, deleted_reason, birthday, flag_username', 'safe', 'on'=>'search'),
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('introduction',$this->introduction,true);
		$criteria->compare('cmnd',$this->cmnd,true);
		$criteria->compare('deleted_by',$this->deleted_by);
		$criteria->compare('deleted_reason',$this->deleted_reason,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('flag_username',$this->flag_username);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}