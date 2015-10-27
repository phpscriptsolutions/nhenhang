<?php

Yii::import('application.models.db.ToolsSettingGetMsisdnModel');

class AdminToolsSettingGetMsisdnModel extends ToolsSettingGetMsisdnModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}