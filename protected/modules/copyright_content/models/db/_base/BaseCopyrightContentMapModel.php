<?php

/**
 * This is the model class for table "copyright_content_map".
 *
 * The followings are the available columns in table 'copyright_content_map':
 * @property string $id
 * @property integer $input_id
 * @property integer $content_id
 * @property string $content_name
 * @property string $content_type
 */
class BaseCopyrightContentMapModel extends ChachaActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CopyrightContentMap the static model class
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
		return 'copyright_content_map';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('input_id, content_id', 'required'),
			array('input_id, content_id', 'numerical', 'integerOnly'=>true),
			array('content_name', 'length', 'max'=>255),
			array('content_type', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, input_id, content_id, content_name, content_type', 'safe', 'on'=>'search'),
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
		$criteria->compare('input_id',$this->input_id);
		$criteria->compare('content_id',$this->content_id);
		$criteria->compare('content_name',$this->content_name,true);
		$criteria->compare('content_type',$this->content_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}