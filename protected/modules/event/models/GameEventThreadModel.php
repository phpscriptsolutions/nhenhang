<?php

class GameEventThreadModel extends BaseGameEventThreadModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GameEventThread the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/**
	 * lay ra 1 bo cau hoi
	 */
	public static function getNewRandomThread($userPhone)
	{
		$sql = "SELECT id
				FROM game_event_thread
				WHERE id NOT IN (SELECT DISTINCT thread_id FROM game_event_user_log WHERE user_phone=:user_phone )
				ORDER BY RAND()
				LIMIT 1
				";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
		return $command->queryScalar();
	}
	/**
	 * check user da tham gia choi chua
	 */
	public static function countPlayByDate($userPhone,$date)
	{
		$sql = "SELECT count(*)
				FROM game_event_user_log
				WHERE user_phone=:user_phone AND date(started_datetime) = :date
				";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
		$command->bindParam(':date', $date, PDO::PARAM_STR);
		return $command->queryScalar();
	}
	
	public static function getQuestionsByThread($threadId)
	{
		$qArray = self::model()->findByPk($threadId)->question_list;
		$sql = "SELECT *
				FROM game_event_question
				WHERE id IN ($qArray)";
		$command = Yii::app()->db->createCommand($sql);
		return $command->queryAll();
	}
}