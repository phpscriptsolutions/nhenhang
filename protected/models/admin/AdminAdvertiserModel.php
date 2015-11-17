<?php

Yii::import('application.models.db.AdvertiserModel');

class AdminAdvertiserModel extends AdvertiserModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}