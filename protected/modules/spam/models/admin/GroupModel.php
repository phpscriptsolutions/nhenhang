<?php

Yii::import('application.modules.spam.models.db.BaseGroupModel');

class GroupModel extends BaseGroupModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}