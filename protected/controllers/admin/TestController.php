<?php
@ini_set('max_execution_time', "600");

define("FUN_URL", "http://10.1.10.173/vascmd/fundial/api");

class TestController extends CController
{
	public $layout = 'application.views.admin.layouts.newstyle';
	public $menu = array();
	public $breadcrumbs = array();
	public $slidebar = array();
	public $pageLabel = "";
	public $userId;
	public $username = "";
	public $cpId;
	public $ccpId;
	public $expiredPass = 0;

	public $adminGroup = "";
	public $levelAccess = 999999;


	public function actionIndex()
	{
        $phone = '84949037864';
        $rbt_status = self::getDetailSubs($phone);
		var_dump($rbt_status);
    }

    public function actionTest()
    {
    	$loger = new KLogger("_TEST_REQUEST", KLogger::INFO);
    	$clientIP = $_SERVER['REMOTE_ADDR'];
    	$loger->LogInfo($clientIP,false);
    	echo "<pre>";print_r($_SERVER);exit();
    }
    function fundial($post)
    {
        $curl = curl_init(FUN_URL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        $content  = curl_exec($curl);
        if(curl_errno($curl)) {
            echo 'Curl error: ' . curl_error($curl);
          }
        $result = ArrayHelper::xml2array(trim($content),1,'attribute');
        curl_close($curl);
        if(isset($result['FUNDIAL']))  return $result['FUNDIAL']['RPLY'];
        else if(isset($result['FUNDIAL_OFAPI']))  return $result['FUNDIAL_OFAPI']['RPLY'];
        else if(isset($result['RPLY']))  return $result['RPLY'];
        else  return $result;
    }

    function get_subscriber_details($msisdn) {
        $post = "<USER name='vega' ip='10.1.10.18' note='ringtunes' channel='API'></USER>" . '
                    <RQST name="GET_SUBSCRIBER_DETAILS">
                    <SUBSCRIBER>
                    <SUBID>' . $msisdn . '</SUBID>
                    </SUBSCRIBER>
                    </RQST>
        ';
        $result = self::fundial($post);
        return $result;
    }
    public function getDetailSubs($phone) {
        $res = self::get_subscriber_details($phone);
        return $res;
    }

    public function actionUpload()
    {
    	$error = array();
    	if(Yii::app()->request->isPostRequest){
    		if(isset($_FILES['file_upload'])){
    			$fileUpload = $_FILES['file_upload'];
    			$tmpPath = _APP_PATH_.DS."data/tmp".DS."TEST_".time().".jpg";
    			if($fileUpload["error"]==0){
    				$ret = move_uploaded_file($_FILES['file_upload']['tmp_name'],$tmpPath);
    				if(!$ret){
    					$error[] = "Lỗi move file ".$tmpPath;
    				}
    			}else{
    				$error[] = $fileUpload["error"];
    			}
    		}
    	}


		$this->render("upload",compact("error"));
    }

    public function actionExportSong()
    {
    	Yii::import("application.models.web.*");
    	$sql = "SELECT t1.*,t2.profile_ids FROM tmp_song_hot t1 INNER JOIN song t2 on t1.id = t2.id";
    	$data = Yii::app()->db->createCommand($sql)->queryAll();
    	foreach($data as $item)
    	{
			$genre_name = SongGenreModel::model()->getCatBySong($item["id"],true);
			$profiles = $item["profile_ids"];
			//$profiles = explode(",", $profiles);
			$profileId = 2;
			if(strrpos($item["profile_ids"], 4) !== false){
				$profileId = 4;
			}
			$url_key = Common::makeFriendlyUrl($item["name"]);
			$songPath = SongModel::model()->getAudioFilePath($item["id"],$profileId);
			$songUrl = WebSongModel::model()->getPlayUrl($item["id"], $profiles, $url_key, $item["artist_name"],"download");

			Yii::app()->db->createCommand()->update("tmp_song_hot",array(
				'genre_name'=>$genre_name,
				'file_path'=>$songPath,
				'file_url'=>$songUrl,
			), "id='{$item["id"]}'"
			);

			echo "{$item["id"]}-{$profiles}-{$item["name"]}-{$genre_name}-{$songPath}-$songUrl";
			echo "<br />----------------------------------------------<br />";
    	}
    	exit;
    }

}