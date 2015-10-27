<?php

Yii::import('application.models.db.AdminAccessItemsModel');

class AdminAdminAccessItemsModel extends AdminAccessItemsModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getListRoles()
    {
    	$c = new CDbCriteria();
    	$c->distinct = true;
    	$c->select = "name";
    	$c->order = "name ASC";
    	$c->condition = "type=2";
    	return self::model()->findAll($c);
    }    
}