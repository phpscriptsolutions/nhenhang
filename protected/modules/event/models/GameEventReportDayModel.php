<?php

class GameEventReportDayModel extends BaseGameEventReportDayModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GameEventReportDay the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getRank($limit=10)
	{
		$sql = "SELECT sum(point) as total_point, user_phone, SEC_TO_TIME(TIME_TO_SEC(time(time_end))-TIME_TO_SEC(time(time_start))) as time_play
				FROM game_event_report_day
				WHERE TRUE
				GROUP BY user_phone
				ORDER BY total_point DESC,time_play ASC
				LIMIT $limit
				";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}
	public function getRankByThread($threadId, $limit=3)
	{
		$sql = "SELECT sum(point) as total_point, user_phone, SEC_TO_TIME(TIME_TO_SEC(time(MAX(completed_datetime)))-TIME_TO_SEC(time(MIN(started_datetime)))) as time_play
				FROM game_event_user_log
				WHERE thread_id=:thread_id
				GROUP BY user_phone
				ORDER BY total_point DESC,time_play ASC
				LIMIT $limit
				";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':thread_id', $threadId, PDO::PARAM_INT);
		return $command->queryAll();
	}
	
	public function getLogByPhone($date, $phone) {
		$sql = "SELECT t.user_phone, t.thread_id, min(t.started_datetime) as started_datetime, max(t.completed_datetime) as completed_datetime , sum(point) as total_point, thread.name as thread_name
			FROM game_event_user_log t
				LEFT JOIN game_event_thread as thread on thread.id= t.thread_id
			WHERE user_phone = :user_phone AND date(started_datetime) = :date
			GROUP BY thread_id
			";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':user_phone', $phone, PDO::PARAM_STR);
		$command->bindParam(':date', $date, PDO::PARAM_STR);
		$data = $command->queryAll();
		return $data;	
	}
}