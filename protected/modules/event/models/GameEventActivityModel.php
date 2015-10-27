<?php

class GameEventActivityModel extends BaseGameEventActivityModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GameEventActivity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public static function isShareOnDay($userPhone, $date)
	{
		$sql = "SELECT count(*)
				FROM game_event_activity
				WHERE user_phone=:user_phone AND date(updated_time)=:updated_time AND activity='share'
				";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
		$command->bindParam(':updated_time', $date, PDO::PARAM_STR);
		return $command->queryScalar();
	}
}