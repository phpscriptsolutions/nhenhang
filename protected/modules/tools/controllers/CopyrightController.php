<?php
class CopyrightController extends Controller{
	public function init()
	{
		parent::init();
		$this->pageTitle = Yii::t('admin', "Tools Copyright ") ;
	}
	public function actionIndex()
	{
		$result = ToolsCopyrightModel::getSongToUpdateCP();
		$data = array();
		foreach ($result as $value) array_push($data, $value['song_id']);
		$this->render('index', compact('result','data'));
	}
	public function actionProcess()
	{
		$songId = Yii::app()->request->getParam('song_id',0);
		$reason = "hide";
		$result = new stdClass();
		$result->errorCode = 1;
		$result->message="<div>Update Success Copyright Song_Id:$songId</div>";
		$result->completed=0;
		if($songId>0){
			try
			{
				//UPDATE assign_id here
				$songCP = ToolsCopyrightModel::getSongToUpdateCP($songId);
				if($songCP){
					$cps = explode(',', $songCP[0]['cps']);
					$cpPriority = Yii::app()->db->createCommand("SELECT id, priority FROM copyright ORDER BY priority DESC")->queryAll();
					foreach ($cpPriority as $value){
						if(in_array($value['id'], $cps)){
							$assignCp = $value['id'];
							break;
						}
					}
					$sql = "UPDATE song_copyright SET assign_cp_id = $assignCp WHERE song_id=$songId";
					$res = Yii::app()->db->createCommand($sql)->execute();
					if(!$res){
						$result->errorCode = 3;
						$result->message="<div>Update Success</div>";
					}
				}
			}
			catch(Exception $e) // an exception is raised if a query fails
			{
				$result->errorCode = 2;
				$result->message="Exception ".$e->getMessage();
			}
		}else{
			$result->errorCode = 1;
			$result->message="Song Id Not Avaiable ($songId)";
		}
		echo CJSON::encode($result);
		Yii::app()->end();
	}
	
}