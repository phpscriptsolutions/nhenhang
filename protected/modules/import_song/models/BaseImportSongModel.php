<?php

/**
 * This is the model class for table "import_song".
 *
 * The followings are the available columns in table 'import_song':
 * @property integer $id
 * @property integer $autoconfirm
 * @property string $created_time
 * @property string $updated_time
 * @property integer $stt
 * @property string $name
 * @property string $category
 * @property string $sub_category
 * @property string $composer
 * @property string $artist
 * @property string $album
 * @property string $path
 * @property string $file
 * @property integer $status
 * @property string $import_datetime
 * @property string $importer
 * @property string $file_name
 * @property integer $file_id
 * @property string $error_desc
 * @property string $error_code
 * @property integer $new_song_id
 */
class BaseImportSongModel extends ChachaActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ImportSong the static model class
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
		return 'import_song';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('autoconfirm, stt, status, file_id, new_song_id', 'numerical', 'integerOnly'=>true),
			array('name, path, file, file_name, error_desc', 'length', 'max'=>255),
			array('category, sub_category, composer, artist, album, importer', 'length', 'max'=>100),
			array('error_code', 'length', 'max'=>10),
			array('created_time, updated_time, import_datetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, autoconfirm, created_time, updated_time, stt, name, category, sub_category, composer, artist, album, path, file, status, import_datetime, importer, file_name, file_id, error_desc, error_code, new_song_id', 'safe', 'on'=>'search'),
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
		$criteria->compare('autoconfirm',$this->autoconfirm);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('stt',$this->stt);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('sub_category',$this->sub_category,true);
		$criteria->compare('composer',$this->composer,true);
		$criteria->compare('artist',$this->artist,true);
		$criteria->compare('album',$this->album,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('file',$this->file,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('import_datetime',$this->import_datetime,true);
		$criteria->compare('importer',$this->importer,true);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('file_id',$this->file_id);
		$criteria->compare('error_desc',$this->error_desc,true);
		$criteria->compare('error_code',$this->error_code,true);
		$criteria->compare('new_song_id',$this->new_song_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
			),
		));
	}
}