<?php

class ImportSongModel extends BaseImportSongModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public static function getSongsAll($file_id)
    {
    	$sql = "SELECT *
    			FROM import_song
    			WHERE file_id={$file_id} and status=0
    			ORDER BY stt ASC
    			LIMIT 1
    			";
    	return Yii::app()->db->createCommand($sql)->queryAll();
    }
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
    	$criteria->compare('file_id',$this->file_id,true);
    	$criteria->compare('error_code',$this->error_code,true);
    	$criteria->compare('new_song_id',$this->new_song_id,true);
    
    	return new CActiveDataProvider($this, array(
    			'criteria'=>$criteria,
    			'pagination'=>array(
    					'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
    			),
    	));
    }
}