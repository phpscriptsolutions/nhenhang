<?php

Yii::import('application.models.db.RejectModel');

class  RejectModel extends BaseRejectModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}