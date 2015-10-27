<?php

Yii::import('application.models.db.AdminAccessAssignmentsModel');

class AdminAdminAccessAssignmentsModel extends AdminAccessAssignmentsModel
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
    	$c->select = "itemname";
    	$c->order = "itemname ASC";
    	return self::model()->findAll($c);
    }
}