<?php

/**
 * This is the model class for table "content_approve".
 *
 * The followings are the available columns in table 'content_approve':
 * @property integer $id
 * @property string $content_type
 * @property integer $content_id
 * @property integer $admin_id
 * @property string $admin_name
 * @property integer $approved_id
 * @property string $action
 * @property string $data_change
 * @property integer $status
 * @property string $created_time
 * @property string $approved_time
 * @property string $approved_content_time
 */
class BaseContentApproveModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ContentApprove the static model class
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
		return 'content_approve';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content_type, admin_id', 'required'),
			array('content_id, admin_id, approved_id, status', 'numerical', 'integerOnly'=>true),
			array('content_type', 'length', 'max'=>30),
			array('admin_name', 'length', 'max'=>255),
			array('action', 'length', 'max'=>10),
			array('data_change, created_time, approved_time, approved_content_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, content_type, content_id, admin_id, admin_name, approved_id, action, data_change, status, created_time, approved_time, approved_content_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('content_type',$this->content_type,true);
		$criteria->compare('content_id',$this->content_id);
		$criteria->compare('admin_id',$this->admin_id);
		$criteria->compare('admin_name',$this->admin_name,true);
		$criteria->compare('approved_id',$this->approved_id);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('data_change',$this->data_change,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('approved_time',$this->approved_time,true);
		$criteria->compare('approved_content_time',$this->approved_content_time,true);
		$criteria->order = "id DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}