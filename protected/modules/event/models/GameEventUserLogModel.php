<?php

class GameEventUserLogModel extends BaseGameEventUserLogModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GameEventUserLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getPoint($userPhone, $thread_id)
	{
		$sql = "SELECT sum(point) as total, SEC_TO_TIME(TIME_TO_SEC(time(MAX(completed_datetime)))-TIME_TO_SEC(time(MIN(started_datetime)))) as time_play
				FROM game_event_user_log
				WHERE user_phone=:user_phone AND thread_id=:thread_id
				";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':user_phone', $userPhone, PDO::PARAM_STR);
		$command->bindParam(':thread_id', $thread_id, PDO::PARAM_STR);
		return $command->queryRow();
	}
	
	public function getLogByPhone($date, $phone) {
		$sql = "SELECT t.user_phone, t.thread_id, t.ask_id, 
						t.started_datetime, t.completed_datetime, t.point,						 
						thread.name as thread_name,
						question.name as question_name
			FROM game_event_user_log t
				LEFT JOIN game_event_thread as thread on thread.id= t.thread_id
				LEFT JOIN game_event_question as question on question.id= t.ask_id
			WHERE user_phone = :user_phone AND date(started_datetime) = :date
			order by t.thread_id
			";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':user_phone', $phone, PDO::PARAM_STR);
		$command->bindParam(':date', $date, PDO::PARAM_STR);
		
		return $command->queryAll();
	
	}
}