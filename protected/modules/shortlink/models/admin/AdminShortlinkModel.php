<?php

Yii::import('application.modules.shortlink.models.db.ShortlinkModel');

class AdminShortlinkModel extends ShortlinkModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    public function beforeSave()
    {
    	$this->shortlink = $this->domain."/sl/".$this->url_key;
    	return parent::beforeSave();
    }
    public function rules()
    {
    	return CMap::mergeArray(parent::rules(), 
	    	array(
	    		array('url_key', 'checkUnique'),
	    	)
    	);
    }
    public function checkUnique()
    {
    	if($this->id>0){
    		$sql = "select count(*) as total from shortlink where url_key=:url_key and id<>:id";
    		$cmd = Yii::app()->db->createCommand($sql);
    		$cmd->bindParam(':url_key', $urlKey, PDO::PARAM_STR);
    		$cmd->bindParam(':id', $this->id, PDO::PARAM_INT);
    		$c = $cmd->queryScalar();
    	}else{
    		$sql = "select count(*) as total from shortlink where url_key=:url_key";
    		$cmd = Yii::app()->db->createCommand($sql);
    		$cmd->bindParam(':url_key', $this->url_key, PDO::PARAM_STR);
    		$c = $cmd->queryScalar();
    	}
    	if($c) {
    		$this->addError('url_key','Exists!');
    	}
    }
    public static function getUrlKey($urlKey, $id='')
    {
    	do{
    		$flag=true;
    		$sql = "select count(*) as total from shortlink where url_key=:url_key";
    		if($id!=''){
    			$sql .=" AND id<>:id";
    		}
    		$cmd = Yii::app()->db->createCommand($sql);
    		$cmd->bindParam(':url_key', $urlKey, PDO::PARAM_STR);
    		if($id!=''){
    			$cmd->bindParam(':id', $id, PDO::PARAM_INT);
    		}
    		$count = $cmd->queryScalar();
    		if($count>0){
    			$posChar = strlen($urlKey);
    			$firstString = substr($urlKey, 0, $posChar-1);
    			$lastString = substr($urlKey, $posChar-1, 1);
    			if(is_numeric($lastString)){
    				$lastChar =$lastString+1;
    				$urlKey = $firstString.$lastChar;
    			}else{
    				$lastChar = 1;
    				$urlKey = $urlKey.$lastChar;
    			}
    		}else{
    			$flag=false;
    		}
    	}while ($flag);
    	return $urlKey;
    }
    public function search()
    {
    	// Warning: Please modify the following code to remove attributes that
    	// should not be searched.
    
    	$criteria=new CDbCriteria;
    
    	$criteria->compare('id',$this->id);
    	$criteria->compare('prefix',$this->prefix,true);
    	$criteria->compare('url_key',$this->url_key,true);
    	$criteria->compare('domain',$this->domain,true);
    	$criteria->compare('shortlink',$this->shortlink,true);
    	$criteria->compare('dest_link',$this->dest_link,true);
    	$criteria->compare('created_datetime',$this->created_datetime,true);
    	$criteria->compare('status',$this->status);
    	$criteria->order="id DESC";
    	return new CActiveDataProvider($this, array(
    			'criteria'=>$criteria,
    			'pagination'=>array(
    					'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['pageSize']),
    			),
    	));
    }
}