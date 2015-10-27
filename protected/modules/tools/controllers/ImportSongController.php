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
	public function actionCheckSong()
	{
		@ini_set("max_execution_time", 180000);
		$completed = $error = 0;
		$data = time();
		$fileId = Yii::app()->request->getParam('fileId',0);
		$result = ImportSongModel::getSongsAll($fileId);
		if($result){
			$song = $result[0];
			$check = $this->isExistsSong($song['name'], $song['album']);
			$status = (!$check)?2:1;
			$check = (!$check)?0:$check;
			$this->updateSongImportSource($song['id'],$check, $status);
		}else{
			$completed = 1;
		}
		$data = $this->getPerCompleted($fileId);
		$dataJson = array(
				'error'		=> $error,
				'completed' => $completed,
				'data' 		=> $data.'%'
		);
		echo CJSON::encode($dataJson);
		Yii::app()->end();
	}
	private function isExistsSong($songName, $artistIds)
	{
		if($artistIds==0) return false;
		$songName = trim(strtoupper($songName));
		$sql = "SELECT c1.id
				FROM song c1
				LEFT JOIN song_artist c2 ON c1.id=c2.song_id
				WHERE TRIM(UPPER(c1.name)) = :songname and c2.artist_id IN ($artistIds) and c1.status=1 and c1.cp_id=1
				";
		$cm = Yii::app()->db->createCommand($sql);
		$cm->bindParam(':songname', $songName, PDO::PARAM_STR);
		$result = $cm->queryScalar();
		if($result && $result>0) return $result;
		return false;
	}

	protected function updateSongImportSource($id, $songRelated, $status=0)
	{
		$sql = "UPDATE import_song
				SET status=$status, new_song_id=$songRelated
				WHERE id=$id";
		return Yii::app()->db->createCommand($sql)->execute();
	}
	private function getPerCompleted($fileId)
	{
		$sql = "select
				SUM(CASE WHEN status > 0 THEN 1 ELSE 0 END) AS isNotYet,
				SUM(CASE WHEN true THEN 1 ELSE 0 END) AS isAll
				from import_song
				where file_id=:file";
		$cm = Yii::app()->db->createCommand($sql);
		$cm->bindParam(':file', $fileId, PDO::PARAM_INT);
		$result = $cm->queryRow();
		return intval($result['isNotYet']/$result['isAll']*100);
	}
}
