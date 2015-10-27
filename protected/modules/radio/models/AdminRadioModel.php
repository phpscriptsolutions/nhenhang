<?php

Yii::import('application.models.db.RadioModel');

class AdminRadioModel extends RadioModel
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
    public function getAllSub($channelId=0)
    {
    	$sql = "SELECT * FROM radio where status=1";
    	$subChannel = Yii::app()->db->createCommand($sql)->queryAll();
    	
		$data	= $this->getAllSubChannel($channelId, $subChannel);
		return $data;
    }
    protected function getAllSubChannel($parentId, array $cates, $res = array(), $spec = '') {
    	foreach ($cates as $cate) {
    		if ($cate['parent_id'] == $parentId) {
    			$cate['name'] = $spec . $cate['name'];
    			$res[]     = $cate['id'];
    			$res     = $this->getAllSubChannel($cate['id'], $cates, $res, $spec . '--');
    		}
    	}
    	return $res;
    }
}