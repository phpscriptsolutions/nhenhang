<?php
class ContentController extends Controller
{
	public $time;
	
	public function init() {
		parent::init();
		$this->pageLabel = '';
	
		if (isset($_GET['date']) && $_GET['date'] != "") {
			$createdTime = urldecode($_GET['date']);
			
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate, 'to' => $toDate);
			} else {
				$time = explode("/", trim(urldecode($_GET['date'])));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time =  array('from' => $time, 'to' => $time);
			}
		} else {
			//$startDay = date("Y") . "-" . date("m") . "-01";
			$fromDate = date("Y-m-d",strtotime("-1 day"));
			$toDate = date("Y-m-d");
			$this->time = array('from' => $fromDate, 'to' => $toDate);
		}
	}
	
	public function actionIndex()
	{
		$this->forward("statistic/song");
	}
	
	public function actionSong()
	{
		$this->pageLabel = Yii::t("admin", "Thống kê bài hát từ {$this->time["from"]} Tới {$this->time["to"]}");
		$options = $_GET;
		if(isset($options["song_name"]) && $options["song_name"]!=""){
			$this->pageLabel .= " - Bài hát \"{$options["song_name"]}\"";
		}
		if(isset($options["artist_name"]) && $options["artist_name"]!=""){
			$this->pageLabel .= " - Ca sỹ \"{$options["artist_name"]}\"";
		}
		
	
		$data = StatisticSongModel::model()->getBySong($this->time,$options);
		$this->render("song_detail",compact("data","options"));
	}
	
	public function actionVideo()
	{
		$this->pageLabel = Yii::t("admin", "Thống kê video từ {$this->time["from"]} Tới {$this->time["to"]}");
		$options = $_GET;
		if(isset($options["video_name"]) && $options["video_name"]!=""){
			$this->pageLabel .= " - Video \"{$options["video_name"]}\"";
		}
		if(isset($options["artist_name"]) && $options["artist_name"]!=""){
			$this->pageLabel .= " - Ca sỹ \"{$options["artist_name"]}\"";
		}
		
		if(isset($options["user_name"]) && $options["user_name"]!=""){
			$this->pageLabel .= " - Thành viên \"{$options["user_name"]}\"";
		}
	
		$data = StatisticVideoModel::model()->getByVideo($this->time,$options);
		$this->render("video_detail",compact("data","options"));
	}
	
	
	public function actionAlbum()
	{
		$this->pageLabel = Yii::t("admin", "Thống kê Album từ {$this->time["from"]} Tới {$this->time["to"]}");
		$options = $_GET;
		if(isset($options["album_name"]) && $options["album_name"]!=""){
			$this->pageLabel .= " - Album \"{$options["album_name"]}\"";
		}
		if(isset($options["artist_name"]) && $options["artist_name"]!=""){
			$this->pageLabel .= " - Ca sỹ \"{$options["artist_name"]}\"";
		}
		
		if(isset($options["user_name"]) && $options["user_name"]!=""){
			$this->pageLabel .= " - Thành viên \"{$options["user_name"]}\"";
		}
	
		$data = StatisticAlbumModel::model()->getByAlbum($this->time,$options);
		$this->render("album_detail",compact("data","options"));
	}
	
	function _builConditionSong($options)
	{
		if(isset($options["artist_name"]) && $options["artist_name"]!="")
		{
			$sql = "SELECT DISTINCT t1.song_id 
					FROM song_artist t1
					INNER JOIN artist t2 ON t1.artist_id = t2.id
					WHERE t2.name LIKE :A_NAME";
			$command = Yii::app()->db->createCommand($sql);
			$artistName = "%".$options["artist_name"]."%";
			$command->bindParam(":A_NAME", $artistName, PDO::PARAM_STR);	
			$data = $command->queryAll();		
			$data = 	CHtml::listData($data, "song_id", "song_id");
			$options["song_ids"] = array_values($data);
		}
		
		if(isset($options["user_name"]) && $options["user_name"]!="")
		{
			$sql = "SELECT DISTINCT t1.id as id
					FROM user t1					
					WHERE t1.username LIKE :U_NAME";
			$command = Yii::app()->db->createCommand($sql);
			$uname = $options["user_name"]."%";
			$command->bindParam(":U_NAME", $uname, PDO::PARAM_STR);		
			$data = $command->queryRow();
			$options["user_id"] = $data["id"];			
		}
		return $options;
	}
	
	function _builConditionVideo($options)
	{
		if(isset($options["artist_name"]) && $options["artist_name"]!="")
		{
			$sql = "SELECT DISTINCT t1.video_id 
					FROM video_artist t1
					INNER JOIN artist t2 ON t1.artist_id = t2.id
					WHERE t2.name LIKE :A_NAME";
			$command = Yii::app()->db->createCommand($sql);
			$artistName = "%".$options["artist_name"]."%";
			$command->bindParam(":A_NAME", $artistName, PDO::PARAM_STR);	
			$data = $command->queryAll();		
			$data = 	CHtml::listData($data, "video_id", "video_id");
			$options["video_ids"] = array_values($data);
		}
		
		if(isset($options["user_name"]) && $options["user_name"]!="")
		{
			$sql = "SELECT DISTINCT t1.id as id
					FROM user t1					
					WHERE t1.username LIKE :U_NAME";
			$command = Yii::app()->db->createCommand($sql);
			$uname = $options["user_name"]."%";
			$command->bindParam(":U_NAME", $uname, PDO::PARAM_STR);		
			$data = $command->queryRow();
			$options["user_id"] = $data["id"];			
		}
		return $options;
	}
	
	function _builConditionAlbum($options)
	{
		if(isset($options["artist_name"]) && $options["artist_name"]!="")
		{
			$sql = "SELECT DISTINCT t1.video_id 
					FROM album_artist t1
					INNER JOIN artist t2 ON t1.artist_id = t2.id
					WHERE t2.name LIKE :A_NAME";
			$command = Yii::app()->db->createCommand($sql);
			$artistName = "%".$options["artist_name"]."%";
			$command->bindParam(":A_NAME", $artistName, PDO::PARAM_STR);	
			$data = $command->queryAll();		
			$data = 	CHtml::listData($data, "video_id", "video_id");
			$options["video_ids"] = array_values($data);
		}
		
		if(isset($options["user_name"]) && $options["user_name"]!="")
		{
			$sql = "SELECT DISTINCT t1.id as id
					FROM user t1					
					WHERE t1.username LIKE :U_NAME";
			$command = Yii::app()->db->createCommand($sql);
			$uname = $options["user_name"]."%";
			$command->bindParam(":U_NAME", $uname, PDO::PARAM_STR);		
			$data = $command->queryRow();
			$options["user_id"] = $data["id"];			
		}
		return $options;
	}
}
