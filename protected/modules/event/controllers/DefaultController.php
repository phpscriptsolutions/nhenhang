<?php

class DefaultController extends MController
{
	public function actionIndex()
	{
		$userSub = $this->userSub;
		$this->render('index', array(
            'userSub' => $userSub,            
            ));
	}
	
	public function actionRules()
	{				
		$rules = HtmlModel::model()->findAllByAttributes(array('type' => 'event'));		
		$this->render('rules', array(
			'rules' => $rules,
		));
	}
	public function actionRank()
	{
		//$rank = GameEventReportDayModel::model()->getRank(10);
		$rank = array();
		$thread = GameEventThreadModel::model()->findAll();
		if($thread){
			foreach ($thread as $value){
				$sql = "SELECT thread_id,point, user_phone,id,SEC_TO_TIME(TIME_TO_SEC(time(time_end))-TIME_TO_SEC(time(time_start))) as time_play
						FROM game_event_report_day
						where thread_id=:thread_id
						ORDER BY point DESC,time_play ASC
						limit 1";
				$command = Yii::app()->db->createCommand($sql);
				$command->bindParam(':thread_id', $value->id, PDO::PARAM_INT);
				$rank[] = $command->queryRow();
			}
		}
		$rankSort = array();
		foreach ($rank as $value){
			if($value)
				$rankSort[$value['point']] = $value;
		}
		krsort($rankSort);
		$this->render('rank', array(
				'rank'=>$rankSort
		));
	}
	public function actionBonus()
	{
		$this->render('bonus');
	}
}