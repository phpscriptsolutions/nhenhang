<?php
class VideoController extends Controller
{
	public function init()
	{
		parent::init();
		$this->pageTitle = Yii::t('admin', "Tools Video ") ;
	}
	public function actionIndex()
	{
		$sql="SELECT count(*) FROM video_to_hide WHERE status=0";
		$result = Yii::app()->db->createCommand($sql)->queryScalar();
		$this->render('index', compact('result'));
	}
	public function actionHide()
	{
		$videoId = Yii::app()->request->getParam('video_id',0);
		$reason = "hide";
		$result = new stdClass();
		$result->errorCode = 0;
		$result->message="success";
		$result->completed=0;
		$videos = ToolsVideoModel::model()->getVideoToHide();
		/* echo '<pre>';print_r($videos);die('stop'); */
		$i=0;
		if($videos){
			$video = $videos[0];
			$videoId = $video['video_id'];
			$reason = $video['reason'];
			if($videoId>0){
				$connection=Yii::app()->db;
				$transaction=$connection->beginTransaction();
				try
				{
					//UPDATE VIDEO_STATUS
					$sql1="	UPDATE video_status t1
						SET t1.approve_status=".AdminVideoStatusModel::REJECT."
						WHERE t1.video_id = :video_id";
					$command1 = $connection->createCommand($sql1);
					$command1->bindParam(':video_id', $videoId, PDO::PARAM_INT);
					$res1 = $command1->execute();
			
					// Insert to video_delete
					$sql2 = "INSERT INTO video_deleted(video_id, deleted_by, deleted_reason, deleted_time)
						VALUE(:video_id, 1, :reason, NOW())
						ON DUPLICATE KEY UPDATE video_id=:video_id, deleted_reason=:reason
						";
					$command2 = $connection->createCommand($sql2);
					$command2->bindParam(':video_id', $videoId, PDO::PARAM_INT);
					$command2->bindParam(':reason', $reason, PDO::PARAM_STR);
					$res2 = $command2->execute();
					//.... other SQL executions
					$transaction->commit();
					$result->message="Hide success $videoId";
					/* $log = new KLogger('HIDE_LOG', KLogger::INFO);
					$log->LogInfo("Hide LOG: |sql1:".$sql1.$videoId." |sql2: ".$sql2.$reason, false); */
					
				}
				catch(Exception $e) // an exception is raised if a query fails
				{
					$result->errorCode = 2;
					$result->message="Exception ".$e->getMessage();
					$transaction->rollback();
				}
					
			}else{
				$result->errorCode = 1;
				$result->message="video Id Not Avaiable ($videoId)";
			}
			ToolsVideoModel::model()->updateStatus($video['id'], $result->errorCode);
		}else{
			$result->completed = 1;
			$result->message="Completed";
		}
		
		$result->message .="<br />";
		echo CJSON::encode($result);
		Yii::app()->end();
	}
}