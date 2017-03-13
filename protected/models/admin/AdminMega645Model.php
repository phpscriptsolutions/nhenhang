<?php

Yii::import('application.models.db.Mega645Model');

class AdminMega645Model extends Mega645Model
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}