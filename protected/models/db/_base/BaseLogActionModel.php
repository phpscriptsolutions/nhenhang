<?php

/**
 * This is the model class for table "log_action".
 *
 * The followings are the available columns in table 'log_action':
 * @property string $id
 * @property integer $adminId
 * @property string $adminName
 * @property string $controller
 * @property string $action
 * @property string $params
 * @property string $created_time
 * @property string $ip
 * @property string $roles
 * @property string $msisdn
 */
class BaseLogActionModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return LogAction the static model class
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
		return 'log_action';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_time', 'required'),
			array('adminId', 'numerical', 'integerOnly'=>true),
			array('adminName, controller, action, roles', 'length', 'max'=>255),
			array('ip, msisdn', 'length', 'max'=>25),
			array('params', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, adminId, adminName, controller, action, params, created_time, ip, roles, msisdn', 'safe', 'on'=>'search'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('adminId',$this->adminId);
		$criteria->compare('adminName',$this->adminName,true);
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('roles',$this->roles,true);
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}