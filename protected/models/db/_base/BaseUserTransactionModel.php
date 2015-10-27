<?php

/**
 * This is the model class for table "user_transaction".
 *
 * The followings are the available columns in table 'user_transaction':
 * @property string $id
 * @property string $user_id
 * @property string $user_phone
 * @property string $transaction
 * @property string $channel
 * @property integer $old_obj_id
 * @property string $obj1_id
 * @property string $obj1_name
 * @property string $obj1_url_key
 * @property string $obj2_id
 * @property string $obj2_name
 * @property string $obj2_url_key
 * @property integer $package_id
 * @property integer $cp_id
 * @property string $cp_name
 * @property integer $genre_id
 * @property double $sharing_rate
 * @property double $price
 * @property string $promotion
 * @property string $note
 * @property string $return_code
 * @property string $created_time
 */
class BaseUserTransactionModel extends MainActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return UserTransaction the static model class
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
		return 'user_transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, created_time', 'required'),
			array('old_obj_id, package_id, cp_id, genre_id', 'numerical', 'integerOnly'=>true),
			array('sharing_rate, price', 'numerical'),
			array('user_id, obj1_id, obj2_id, promotion, return_code', 'length', 'max'=>10),
			array('user_phone', 'length', 'max'=>16),
			array('transaction, channel', 'length', 'max'=>100),
			array('obj1_name, obj1_url_key, obj2_name, obj2_url_key, cp_name', 'length', 'max'=>255),
			array('note', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, user_phone, transaction, channel, old_obj_id, obj1_id, obj1_name, obj1_url_key, obj2_id, obj2_name, obj2_url_key, package_id, cp_id, cp_name, genre_id, sharing_rate, price, promotion, note, return_code, created_time', 'safe', 'on'=>'search'),
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_phone',$this->user_phone,true);
		$criteria->compare('transaction',$this->transaction,true);
		$criteria->compare('channel',$this->channel,true);
		$criteria->compare('old_obj_id',$this->old_obj_id);
		$criteria->compare('obj1_id',$this->obj1_id,true);
		$criteria->compare('obj1_name',$this->obj1_name,true);
		$criteria->compare('obj1_url_key',$this->obj1_url_key,true);
		$criteria->compare('obj2_id',$this->obj2_id,true);
		$criteria->compare('obj2_name',$this->obj2_name,true);
		$criteria->compare('obj2_url_key',$this->obj2_url_key,true);
		$criteria->compare('package_id',$this->package_id);
		$criteria->compare('cp_id',$this->cp_id);
		$criteria->compare('cp_name',$this->cp_name,true);
		$criteria->compare('genre_id',$this->genre_id);
		$criteria->compare('sharing_rate',$this->sharing_rate);
		$criteria->compare('price',$this->price);
		$criteria->compare('promotion',$this->promotion,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('return_code',$this->return_code,true);
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