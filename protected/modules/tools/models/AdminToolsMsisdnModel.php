<?php

Yii::import('application.models.db.ToolsMsisdnModel');

class AdminToolsMsisdnModel extends ToolsMsisdnModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}