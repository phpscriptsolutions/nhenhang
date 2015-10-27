<?php
@ini_set("display_errors", 0);
Yii::import("ext.xupload.models.XUploadForm");
class ImportUploadController extends Controller
{
	const START_ROW = 1;
	const NUMBER_ROW_LIMIT = 999;
	const IMPORT_SONG_CACHE = 'Importer_';
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
		try{
			$log = new KLogger('LOG_IMPORT_FILE_SONG_PNV', KLogger::INFO);
			$log->LogInfo("Start New Import", false);
			$model = new AdminImportSongModel;
			$importer = self::IMPORT_SONG_CACHE . Yii::app()->user->id;
			$result = array();

			if (isset($_POST['AdminImportSongModel'])) {
				$this->layout=false;
				$autoconfirm = Yii::app()->request->getParam('autoconfirm');
				$autoconfirm = isset($autoconfirm) ? 1 : 0;

				$created_time = $_POST['AdminSongModel']['created_time'];
				$updated_time = $_POST['AdminSongModel']['updated_time'];

				$path = Yii::app()->params['importsong']['store_path'];
				$file_path = $pathSource . DS . "tmp" . DS . $_POST['AdminImportSongModel']['source_path'];

				$fileName = explode(DS, $file_path);
				$fileName = $fileName[count($fileName)-1];
				if (file_exists($file_path)) {
					$count = 0;
					$start_row = $_POST['AdminImportSongModel']['start_row'] > 0 ? $_POST['AdminImportSongModel']['start_row'] : 0;
					$start_row += self::START_ROW;
					$limit_row = 65000;
					$limit_row += $start_row;
					$log->LogInfo("Start Read File and put Memcache | ".$file_path, false);
					$data = new ExcelReader($file_path);
					$resultSql = array();
					//insert file
					$sql = "INSERT INTO import_song_file(file_name,importer,status,created_time)
                			VALUE('".$fileName."', '{$importer}',0,NOW())
	                			";
					$insertFileRess = Yii::app()->db->createCommand($sql)->execute();
					$fileImportId = Yii::app()->db->getLastInsertID();
					for ($i = $start_row; $i < $limit_row; $i++) {
						if ($data->val($i, 'B') != "" && $data->val($i, 'G') != "" && $data->val($i, 'C') != "") {
							$stt = $data->val($i, Yii::app()->params['importsong']['excelcolumns']['stt']);
							$name= $model->my_encoding($data->val($i, Yii::app()->params['importsong']['excelcolumns']['name']));
							$category = $model->my_encoding($data->val($i, Yii::app()->params['importsong']['excelcolumns']['category']));
							$sub_category = $model->my_encoding($data->val($i, Yii::app()->params['importsong']['excelcolumns']['sub_category']));
							$composer = $model->my_encoding($data->val($i, Yii::app()->params['importsong']['excelcolumns']['composer']));
							$artist = $model->my_encoding($data->val($i, Yii::app()->params['importsong']['excelcolumns']['artist']));
							$album = $model->my_encoding($data->val($i, Yii::app()->params['importsong']['excelcolumns']['album']));
							$path = str_replace('\\', DS, $data->val($i, Yii::app()->params['importsong']['excelcolumns']['path']));
							$file = $data->val($i, Yii::app()->params['importsong']['excelcolumns']['file']);

							$sql = "(";
							$sql .= "'".($autoconfirm)."'";
							$sql .= ",'".$created_time."'";
							$sql .= ",'".$updated_time."'";
							$sql .= ",'".$stt."'";
							$sql .= ",'".addslashes($name)."'";
							$sql .= ",'".$category."'";
							$sql .= ",'".$sub_category."'";
							$sql .= ",'".addslashes($composer)."'";
							$sql .= ",'".addslashes($artist)."'";
							$sql .= ",'".addslashes($album)."'";
							//$sql .= ",'".str_replace('\\', '\\\\', $path)."'";
							$sql .= ",'".addslashes($path)."'";
							//$sql .= ",'".str_replace('\\', '\\\\', $file)."'";
							$sql .= ",'".addslashes($file)."'";
							$sql .= ",'".$importer."'";
							//$sql .= ",'".str_replace('\\', '\\\\', $file_path)."'";
							$sql .= ",'".addslashes($file_path)."'";
							$sql .= ",'".$fileImportId."'";
							$sql .= ")";
							$resultSql[]=$sql;
							$count++;
						}
						/* if($count==10)
						 echo '<pre>';print_r($result);die(); */
					}

					//insert data to db
					if($insertFileRess){
						$sql = "INSERT INTO import_song(autoconfirm,created_time,updated_time,stt,name,category,sub_category,composer,artist,album,path,file,importer,file_name,file_id) VALUES";
						$sql .= implode(',', $resultSql);
						if(Yii::app()->db->createCommand($sql)->execute()){
							$sql = "UPDATE import_song_file set total_song=$count WHERE id=$fileImportId";
							Yii::app()->db->createCommand($sql)->execute();
						}
						//insert false

					}


					//remove file source after insert
					$fileSystem = new Filesystem();
					$fileSystem->remove($file_path);
					echo CJSON::encode(array(
							'errorCode' => 0,
							'errorDesc'=>'Success imported Total Record: '.count($resultSql)
							)
						);
				} else {
					//if ($_POST['AdminImportSongModel']['ajax'])
					echo CJSON::encode(array(
							'errorCode' => 1,
							'errorDesc' => 'Chưa upload file excel'
					));
				}
				Yii::app()->end();
			}
		}catch (Exception $e)
		{

			$log->LogError("actionAjaxImport | Exception Error: ".$e->getMessage(), false);
			echo CJSON::encode(array(
							'errorCode' => 1,
							'errorDesc' => 'Chưa upload file excel'
					));
			Yii::app()->end();
		}
		$uploadModel = new XUploadForm();
		$this->render('newimport', array(
				'model' => $model,
				'listSong' => $result,
				'uploadModel' => $uploadModel,
		));
	}
}
