<?php
@ini_set("display_errors", 0);
Yii::import("ext.xupload.models.XUploadForm");
class ImportUploadController extends Controller
{
	const START_ROW = 1;
	const NUMBER_ROW_LIMIT = 999;
	const IMPORT_SONG_CACHE = 'Checker_';
	const PATH_FILE_SOURCE = "";
	public function actions() {
		$path = _APP_PATH_ . DS . "data";
		return array(
				'upload' => array(
						'class' => 'ext.xupload.actions.XUploadAction',
						'subfolderVar' => 'parent_id',
						'path' => $path,
						'alowType' => 'application/vnd.ms-excel,excel/xls')
		);
	}
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Upload file Import") ;
	}

	public function actionNewimport() {
		//$path = _APP_PATH_ . DS . "data";
		//$pathSource = 'E:\phuongnv\Vega\chacha_cloud\src\trunk\chacha\data';
		$pathSource = _APP_PATH_ . DS . "data";
		$log = new KLogger('LOG_CHECK_SONG_IMPORT', KLogger::INFO);
		$log->LogInfo("Start New Import", false);
		try{
			$model = new AdminImportSongModel;
			$importer = self::IMPORT_SONG_CACHE . Yii::app()->user->id;
			$result = array();

			if (isset($_POST['AdminImportSongModel'])) {
				$this->layout=false;

				$file_path = $pathSource . DS . "tmp" . DS . $_POST['AdminImportSongModel']['source_path'];

				$fileName = explode(DS, $file_path);
				$fileName = $fileName[count($fileName)-1];
				if (file_exists($file_path)) {
					
					$log->LogInfo("Start Read File and put Memcache | ".$file_path, false);
					$data = new ExcelReader($file_path);
					
					//insert file
					$sql = "INSERT INTO import_song_file(file_name,importer,status,created_time,type)
                			VALUE('".$fileName."', '{$importer}',0,NOW(),'CHECK')
	                			";
					$log->LogInfo("SQL: ".$sql, false);
					$insertFileRess = Yii::app()->db->createCommand($sql)->execute();
					$fileImportId = Yii::app()->db->getLastInsertID();
					$i = 1;
					$err = 0;
					$count = 0;
					$total = 0;
					$sqlAr = array();
					$flag=true;
					While($flag)
					{
						if ($data->val($i, 'A') != "" && $data->val($i, 'B') != "" && $data->val($i, 'C') != "") {
							$stt = $data->val($i, 'A');
							$songName = $model->my_encoding($data->val($i, 'B'));
							$artistName = $model->my_encoding($data->val($i, 'C'));
							$artistId = $this->getArtistId($artistName);
							$artistId = implode(',', $artistId);
							$sqlAr[] = "('$stt','".addslashes($songName)."', '".addslashes($artistName)."', $fileImportId, '{$importer}','{$artistId}')";
							$count++;
							$total++;
						}else{
							$err++;
						}
						$i++;
						if($err==3) $flag=false;
						if($count==200 || !$flag){
							$sql = "INSERT INTO import_song(stt,name,artist,file_id,importer,album) VALUES";
							$sql .= implode(',', $sqlAr);
							$log->LogInfo("SQL: ".$sql, false);
							if(Yii::app()->db->createCommand($sql)->execute()){
								//reset
								$count = 0;
								$sqlAr = array();
							}
						}
					}
					
					$sql = "UPDATE import_song_file set total_song=$total WHERE id=$fileImportId";
					Yii::app()->db->createCommand($sql)->execute();
					
					//remove file source after insert
					/* $fileSystem = new Filesystem();
					$fileSystem->remove($file_path); */
					
					echo CJSON::encode(array(
							'errorCode' => 0,
							'errorDesc'=>'Success imported Total Record: '.$total.' Go to <a href="'.Yii::app()->createUrl('/tools/importSong/index&fileId='.$fileImportId).'">Scan</a>'
							)
						);
				} else {
					echo CJSON::encode(array(
							'errorCode' => 1,
							'errorDesc' => 'File không tồn tại:'.$file_path
					));
					$log->LogInfo("File không tồn tại: ".$file_path, false);
				}
				Yii::app()->end();
			}
		}catch (Exception $e)
		{
			echo CJSON::encode(array(
					'errorCode' => 1,
					'errorDesc' => 'Exception:'.$e->getMessage()
			));
			$log->LogError("actionAjaxImport | Exception Error: ".$e->getMessage(), false);
			Yii::app()->end();
		}
		$uploadModel = new XUploadForm();
		$this->render('newimport', array(
				'model' => $model,
				'listSong' => $result,
				'uploadModel' => $uploadModel,
		));
	}
	
	private function getArtistId($artistName)
	{
		if(strpos($artistName, ' ft ')!==false){
			$at = explode(' ft ', $artistName);
		}elseif(strpos($artistName, ',')!==false){
			$at = explode(',', $artistName);
		}else{
			$at = array($artistName);
		}
		$data = array();
		foreach ($at as $artistName){
			$artistName = trim(strtoupper($artistName));
			$sql = "SELECT id
					FROM artist
					WHERE TRIM(UPPER(name))=:artist
					";
			$cm = Yii::app()->db->createCommand($sql);
			$cm->bindParam(':artist', $artistName, PDO::PARAM_STR);
			$result = $cm->queryAll();
			
			if($result){
				foreach ($result as $artist){
					$data[] = $artist['id'];
				}
			}
			if(count($data)<=0){
				$data = array(0);
			}
		}
		return $data;
	}
}
