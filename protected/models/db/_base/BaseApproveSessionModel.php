<?php

/**
 * This is the model class for table "approve_session".
 *
 * The followings are the available columns in table 'approve_session':
 * @property string $obj_type
 * @property string $obj_id
 * @property integer $admin_id
 * @property string $created_time
 */
class BaseApproveSessionModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ApproveSession the static model class
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
		return 'approve_session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('obj_type, obj_id, admin_id, created_time', 'required'),
			array('admin_id', 'numerical', 'integerOnly'=>true),
			array('obj_type', 'length', 'max'=>5),
			array('obj_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('obj_type, obj_id, admin_id, created_time', 'safe', 'on'=>'search'),
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

		$criteria->compare('obj_type',$this->obj_type,true);
		$criteria->compare('obj_id',$this->obj_id,true);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}