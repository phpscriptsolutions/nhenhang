<?php

Yii::import('application.modules.spam.models.db.BasePhoneModel');

class PhoneModel extends BasePhoneModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}