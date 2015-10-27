<?php
class StatisticController extends Controller
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
				$time = explode("/", trim(urldecode($_GET['report']['date'])));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = $time;
			}
		} else {
			$startDay = date("Y") . "-" . date("m") . "-01";
			$fromDate = date("Y-m-d", strtotime($startDay));
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
		
		$data = StatisticSongModel::model()->getData($this->time,$options);
		$this->render("song_statistic",compact("data","options"));	
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
		
		$data = StatisticVideoModel::model()->getData($this->time,$options);
		$this->render("video_statistic",compact("data","options"));	
	}
	
	
	public function actionAlbum()
	{
		$this->pageLabel = Yii::t("admin", "Thống kê Album từ {$this->time["from"]} Tới {$this->time["to"]}");		
		$options = $_GET;
		if(isset($options["album_name"]) && $options["album_name"]!=""){
			$this->pageLabel .= " - Video \"{$options["album_name"]}\"";
		}
		if(isset($options["artist_name"]) && $options["artist_name"]!=""){
			$this->pageLabel .= " - Ca sỹ \"{$options["artist_name"]}\"";
		}
		
		$data = StatisticAlbumModel::model()->getData($this->time,$options);
		$this->render("album_statistic",compact("data","options"));	
	}
}