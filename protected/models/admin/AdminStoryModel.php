<?php

Yii::import('application.models.db.StoryModel');

class AdminStoryModel extends StoryModel
{
    var $className = __CLASS__;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}