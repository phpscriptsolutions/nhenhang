<?php
Class UserAccess
{
    public static function checkAccess($accessName,$fake = false) {
    	if(Yii::app()->getModule('srbac')->debug) return true;
    	if(!isset(Yii::app()->session[$accessName])){
    		Yii::app()->session[$accessName] = Yii::app()->user->checkAccess($accessName);
    	}
    	return Yii::app()->session[$accessName];

    	/* if(Yii::app()->user->id == 1 && !$fake){} return true;
        else return Yii::app()->user->checkAccess($accessName); */

        /*if(Yii::app()->user->id == 1) return true;
        else return Yii::app()->user->checkAccess($accessName);*/
    }
}
?>
