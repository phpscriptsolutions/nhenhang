<?php

Yii::import('application.models.db.RadioCollectionModel');

class AdminRadioCollectionModel extends RadioCollectionModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function beforeSave()
    {
    	$this->updated_time =  new CDbExpression('NOW()');
    	return parent::beforeSave();
    }
    public function attributeLabels()
    {
    	return array(
			'radio_id' => Yii::t('app', 'Radio'),
			'collection_id' => Yii::t('app', 'Collection'),
    			);
    }
    public function relations()
    {
    	return array(
    			'channel'=>array(self::BELONGS_TO, 'AdminRadioModel', 'radio_id'),
    			'collection'=>array(self::BELONGS_TO, 'AdminCollectionModel', 'collection_id'),
    			'artist'=>array(self::BELONGS_TO, 'AdminArtistModel', 'collection_id'),
    			'genre'=>array(self::BELONGS_TO, 'AdminGenreModel', 'collection_id'),
    			'playlist'=>array(self::BELONGS_TO, 'AdminPlaylistModel', 'collection_id'),
    			'album'=>array(self::BELONGS_TO, 'AdminAlbumModel', 'collection_id')
    	);
    }
}