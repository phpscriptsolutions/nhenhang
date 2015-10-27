<?php

/**
 * This is the model class for table "spam_sms_phone".
 *
 * The followings are the available columns in table 'spam_sms_phone':
 * @property integer $id
 * @property string $phone
 * @property integer $group_id
 * @property integer $status
 * @property string $created_time
 */
class BasePhoneModel extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return SpamSmsPhone the static model class
     */
    public $phone_file;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'spam_sms_phone';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        /**
          return array(
          array('group_id, status', 'numerical', 'integerOnly'=>true),
          array('phone', 'length', 'max'=>100),
          // The following rule is used by search().
          // Please remove those attributes that should not be searched.
          array('id, phone, group_id, status, created_time', 'safe', 'on'=>'search'),
          );
         * 
         */
        //rule for upload file
        return array(
            array('group_id, status', 'numerical', 'integerOnly' => true),
            array('phone', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, phone, group_id, status, created_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'group' => array(self::BELONGS_TO,'BaseGroupModel','group_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return Common::loadMessages("db");
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['pageSize']),
                    ),
                ));
    }
    
    /**
     * get list of SMS group
     */
    public function getPhoneGroup($id) {
        try {
            $cusData = Yii::app()->db->createCommand()
                    ->select('phone')
                    ->from('spam_sms_phone')
                    ->where('group_id='.$id)
                    ->queryAll();
            ///var_dump($cusData);

            return $cusData;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

}