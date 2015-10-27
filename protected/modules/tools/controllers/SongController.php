<?php
class SongController extends Controller
{
	public function init()
	{
		parent::init();
		$this->pageTitle = Yii::t('admin', "Tools Song ") ;
	}
	public function actionIndex()
	{
		$sql="SELECT count(*) FROM song_to_hide WHERE status=0";
		$result = Yii::app()->db->createCommand($sql)->queryScalar();
		
		$sql2="SELECT count(*) FROM song_to_restore WHERE status=0";
		$restore = Yii::app()->db->createCommand($sql2)->queryScalar();
		$this->render('index', compact('result','restore'));
	}
	public function actionHide()
	{
		$songId = Yii::app()->request->getParam('song_id',0);
		$reason = "hide";
		$result = new stdClass();
		$result->errorCode = 1;
		$result->message="success";
		$result->completed=0;
		$songs = ToolsSongModel::model()->getSongToHide();
		/* echo '<pre>';print_r($songs);die('stop'); */
		$i=0;
		if($songs){
			$song = $songs[0];
			$songId = $song['song_id'];
			$reason = $song['reason'];
			if($songId>0){
				$connection=Yii::app()->db;
				$transaction=$connection->beginTransaction();
				try
				{
					//UPDATE SONG_STATUS
					$sql1="	UPDATE song_status t1
						SET t1.approve_status=".AdminSongStatusModel::REJECT."
						WHERE t1.song_id = :song_id";
					$command1 = $connection->createCommand($sql1);
					$command1->bindParam(':song_id', $songId, PDO::PARAM_INT);
					$res1 = $command1->execute();
			
					// Insert to song_delete
					$sql2 = "INSERT INTO song_deleted(song_id, deleted_by, deleted_reason, deleted_time)
						VALUE(:song_id, 1, :reason, NOW())
						ON DUPLICATE KEY UPDATE song_id=:song_id, deleted_reason=:reason
						";
					$command2 = $connection->createCommand($sql2);
					$command2->bindParam(':song_id', $songId, PDO::PARAM_INT);
					$command2->bindParam(':reason', $reason, PDO::PARAM_STR);
					$res2 = $command2->execute();
					
					//update song
					$songModel = SongModel::model()->findByPk($songId);
					if($songModel){
						$songModel->updated_time = date("Y-m-d H:i:s");
						$songModel->save(false);
					}else{
						$transaction->rollback();
						$result->errorCode = 3;
						$result->message="Song Id Not Avaiable ($songId) <br />";
						ToolsSongModel::model()->updateStatus($song['id'], $result->errorCode);
						echo CJSON::encode($result);
						Yii::app()->end();
					}
					//.... other SQL executions
					$transaction->commit();
					$result->message="Hide success $songId";
					/* $log = new KLogger('HIDE_LOG', KLogger::INFO);
					$log->LogInfo("Hide LOG: |sql1:".$sql1.$songId." |sql2: ".$sql2.$reason, false); */
					
				}
				catch(Exception $e) // an exception is raised if a query fails
				{
					$result->errorCode = 2;
					$result->message="Exception ".$e->getMessage();
					$transaction->rollback();
				}
					
			}else{
				$result->errorCode = 3;
				$result->message="Song Id Not Avaiable ($songId)";
			}
			ToolsSongModel::model()->updateStatus($song['id'], $result->errorCode);
		}else{
			$result->completed = 1;
			$result->message="Completed";
		}
		
		$result->message .="<br />";
		echo CJSON::encode($result);
		Yii::app()->end();
	}
	public function actionRestore()
	{
		$songId = Yii::app()->request->getParam('song_id',0);
		$reason = "restore";
		$result = new stdClass();
		$result->errorCode = 1;
		$result->message="success";
		$result->completed=0;
		$songs = ToolsSongModel::model()->getSongToRestore();
		/* echo '<pre>';print_r($songs);die('stop'); */
		$i=0;
		if($songs){
			$song = $songs[0];
			$songId = $song['song_id'];
			$reason = $song['reason'];
			if($songId>0){
				$connection=Yii::app()->db;
				$transaction=$connection->beginTransaction();
				try
				{
					//UPDATE SONG_STATUS TO APPROVED
					$sql1="	UPDATE song_status t1
						SET t1.approve_status=".AdminSongStatusModel::APPROVED."
						WHERE t1.song_id = :song_id";
					$command1 = $connection->createCommand($sql1);
					$command1->bindParam(':song_id', $songId, PDO::PARAM_INT);
					$res1 = $command1->execute();
			
					// DELETE from song_delete
					$sql2 = "DELETE FROM song_deleted WHERE song_id=:song_id";
					$command2 = $connection->createCommand($sql2);
					$command2->bindParam(':song_id', $songId, PDO::PARAM_INT);
					$res2 = $command2->execute();
					
					//update song
					$songModel = AdminSongModel::model()->findByPk($songId);
					$songModel->updated_time = date("Y-m-d H:i:s");
					$songModel->save(false);
					//.... other SQL executions
					$transaction->commit();
					$result->message="Restore success $songId";
					/* $log = new KLogger('HIDE_LOG', KLogger::INFO);
					$log->LogInfo("Hide LOG: |sql1:".$sql1.$songId." |sql2: ".$sql2.$reason, false); */
					
				}
				catch(Exception $e) // an exception is raised if a query fails
				{
					$result->errorCode = 2;
					$result->message="Exception ".$e->getMessage();
					$transaction->rollback();
				}
					
			}else{
				$result->errorCode = 1;
				$result->message="Song Id Not Avaiable ($songId)";
			}
			ToolsSongModel::model()->updateStatusRestore($song['id'], $result->errorCode);
		}else{
			$result->completed = 1;
			$result->message="Completed";
		}
		
		$result->message .="<br />";
		echo CJSON::encode($result);
		Yii::app()->end();
	}
}