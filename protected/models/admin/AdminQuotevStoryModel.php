<?php

Yii::import('application.models.db.QuotevStoryModel');

class AdminQuotevStoryModel extends QuotevStoryModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}