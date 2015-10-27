<?php

/**
 * This is the model class for table "cp".
 *
 * The followings are the available columns in table 'cp':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $code
 * @property string $priority
 * @property double $sharing_rate
 * @property integer $created_by
 * @property integer $updated_by
 * @property string $created_time
 * @property string $updated_time
 * @property integer $sorder
 * @property integer $status
 */
class BaseCpModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Cp the static model class
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
		return 'cp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('created_by, updated_by, sorder, status', 'numerical', 'integerOnly'=>true),
			array('sharing_rate', 'numerical'),
			array('name, email', 'length', 'max'=>255),
			array('code, priority', 'length', 'max'=>10),
			array('created_time, updated_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, email, code, priority, sharing_rate, created_by, updated_by, created_time, updated_time, sorder, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('priority',$this->priority,true);
		$criteria->compare('sharing_rate',$this->sharing_rate);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('updated_by',$this->updated_by);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('sorder',$this->sorder);
		$criteria->compare('status',$this->status);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}