<?php

Yii::import('application.models.db.Max4dModel');

class AdminMax4dModel extends Max4dModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}