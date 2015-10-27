<?php

/**
 * This is the model class for table "copyright_input_content".
 *
 * The followings are the available columns in table 'copyright_input_content':
 * @property integer $id
 * @property integer $stt
 * @property integer $content_id
 * @property string $name
 * @property string $artist
 * @property string $copyright_code
 * @property integer $copyright_id
 * @property integer $input_file
 * @property integer $status
 */
class BaseCopyrightInputContentModel extends ChachaActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CopyrightInputContent the static model class
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
		return 'copyright_input_content';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stt, content_id, copyright_id, input_file, status', 'numerical', 'integerOnly'=>true),
			array('name, artist', 'length', 'max'=>255),
			array('copyright_code', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, stt, content_id, name, artist, copyright_code, copyright_id, input_file, status', 'safe', 'on'=>'search'),
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
		$criteria->compare('stt',$this->stt);
		$criteria->compare('content_id',$this->content_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('artist',$this->artist,true);
		$criteria->compare('copyright_code',$this->copyright_code,true);
		$criteria->compare('copyright_id',$this->copyright_id);
		$criteria->compare('input_file',$this->input_file);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}