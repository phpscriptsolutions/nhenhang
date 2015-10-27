<?php
@ini_set("display_errors", 0);
class ImportSongController extends Controller
{
	
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý Import Song ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);
		$errorCode = Yii::app()->request->getParam('errorCode',null);
		$status = Yii::app()->request->getParam('status',0);
		$fileId = Yii::app()->request->getParam('fileId',0);
		
		$model=new ImportSongModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ImportSongModel']))
			$model->attributes=$_GET['ImportSongModel'];
		if(in_array($errorCode, array(-1,2,3,4))){
			$model->error_code = $errorCode;
			$status=2;
			$model->status = $status;
		}elseif($errorCode=='0'){
			$status=1;
			$model->status = $status;
		}
		if($fileId>0){
			$model->file_id = $fileId;
		}
		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ImportSongModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ImportSongModel']))
		{
			$model->attributes=$_POST['ImportSongModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ImportSongModel']))
		{
			$model->attributes=$_POST['ImportSongModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

                /**
	 * Copy record
	 * If copy is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be copy
	 */
	public function actionCopy($id)
	{
		$data = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ImportSongModel']))
		{
                        $model=new ImportSongModel;
			$model->attributes=$_POST['ImportSongModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('copy',array(
			'model'=>$data,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
    * bulk Action.
    * @param string the action
    */
    public function actionBulk() {
    	$act = Yii::app()->request->getParam('bulk_action', null);
        if (isset($act) &&  $act != "") {
        	$this->forward($this->getId()."/" . $act);
        }else {
        	$this->redirect(array('index'));
        }
	}

    /**
    * Delete all record Action.
    * @param string the action
    */
    public function actionDeleteAll() {           
    	if(isset($_POST['all-item'])){
        	ImportSongModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			ImportSongModel::model()->deleteAll($c);
		}
        $this->redirect(array('index'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ImportSongModel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='import-song-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionAjaxImport() {
		@ini_set("max_execution_time", 18000);
		try{
			$timeStart = time();
			$fileId = Yii::app()->request->getParam('fileId',0);
			$log = new KLogger('LOG_IMPORT_FILE_SONG_PNV', KLogger::INFO);
			$log->LogInfo("Start Ajax Import",false);
			$model = new AdminImportSongModel;
			$result = ImportSongModel::getSongsAll($fileId);
			$totalRow = count($result);
			//echo '<pre>';print_r($result);die();
			$path = Yii::app()->params['importsong']['store_path'];
			$is_error = 0;
			$imported = array();
			$notImport = array();
			$data = "";
			$success = 0;
			if ($totalRow > 0) {
				$song = $result[0];
				$log->LogInfo("Start import | ".CJSON::encode($song), false);
				$status = 0;
				$insert_id = $model->importSong($song, $path);
				
				$insert_id = (!$insert_id)?-1:$insert_id;
				// save inserted id to a string, for updating Updated_time column when finish
				if ($insert_id > 0 && !in_array($insert_id, array(2,3,4))) {
					
					$this->updateTime($insert_id, $song['updated_time']);
					$imported = array('stt' => $song['stt'], 'name' => $song['name'], 'path' => $song['path'], 'songId'=>$insert_id);
					$this->updateSongImportSource($song['id'], 1, 0, 'Success',$insert_id, $timeStart);
				} else {
					$errorDesc = array(
							-1=>'File không tồn tại',
							2=>'Không save được vào song',
							3=>'Hết quyền upload bài hát',
							4=>'File mp3 trống'
					);
					$this->updateSongImportSource($song['id'], 2, $insert_id, $errorDesc[$insert_id],0, $timeStart);
					$is_error = 1;
					$notImport = array('stt' => $song['stt'], 'name' => $song['name'], 'path' => $song['path'], 'errorDesc'=>$errorDesc[$insert_id]);
					//$log->LogInfo('Not import > (' . $song['stt'] . ')' . $song['path'] . $song['file'], false);
				}
				$data = $this->renderPartial('ajaxResultRow', array('imported' => $imported, 'notImport' => $notImport), true, true);
			}else{
				//completed
				$success=1;
				$log->LogError("Error | ".CJSON::encode($result), false);
			}
			
			$dataJson = array(
					'is_error'=>$is_error,
					'success' => $success,
					'data' => $data
			);
			echo CJSON::encode($dataJson);
			Yii::app()->end();
		}catch (Exception $e)
		{
			$log->LogError("actionAjaxImport | Exception Error: ".$e->getMessage(), false);
			$dataJson = array(
					'is_error'=>1,
					'success' => 0,
					'data' => "actionAjaxImport | Exception Error: ".$e->getMessage()
			);
			echo CJSON::encode($dataJson);
			Yii::app()->end();
		}
		exit();
	}
	
	protected function updateTime($songId, $updated_time)
	{
		$sql = "UPDATE song set updated_time='{$updated_time}' WHERE id=$songId";
		return Yii::app()->db->createCommand($sql)->execute();
	}
	
	protected function updateSongImportSource($id, $status=0, $errorCode='',$errDesc='', $new_song_id=0, $timeStart=0)
	{
		if($timeStart>0){
			$estimateTime = time()-$timeStart;
		}else{
			$estimateTime=0;
		}
		$sql = "UPDATE import_song SET status=$status, error_code='{$errorCode}', error_desc='$errDesc', new_song_id=$new_song_id, estimate_time='{$estimateTime}' WHERE id=$id";
		return Yii::app()->db->createCommand($sql)->execute();
	}
}
