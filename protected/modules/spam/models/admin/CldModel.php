<?php

Yii::import('application.modules.spam.models.db.BaseCldModel');

class CldModel extends BaseCldModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}