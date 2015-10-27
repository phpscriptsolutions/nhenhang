<?php

class ContentApproveController extends Controller
{
	public $time;
	public $timeLabel;
	public function init() {
		parent::init();
		$this->pageTitle = Yii::t('admin', "Quản lý sửa nội dung ");
	
		if (isset($_GET['datetime']) && $_GET['datetime'] != "") {
			$createdTime = $_GET['datetime'];
			if (strrpos($createdTime, "-")) {
				$createdTime = explode("-", $createdTime);
				$fromDate = explode("/", trim($createdTime[0]));
				$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
				$toDate = explode("/", trim($createdTime[1]));
				$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $fromDate." 00:00:00", 'to' => $toDate." 23:59:59");
			} else {
				$time = explode("/", trim($_GET['datetime']));
				$time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
				$this->time = array('from' => $time." 00:00:00", 'to' => $time." 23:59:59");
			}
		} else {
			$startDay = date("Y") . "-" . date("m") . "-01";
			$fromDate = date("Y-m-d", strtotime($startDay));
			$toDate = date("Y-m-d");
			$this->time = array('from' => $fromDate." 00:00:00", 'to' => $toDate." 23:59:59");
		}
		//
		$timeLabel = array();
		$timeFrom = date('Y-m-d',strtotime($this->time['from']));
		$timeTo = date('Y-m-d',strtotime($this->time['to']));
		while ($timeFrom<=$timeTo){
			$timeLabel[] = $timeFrom;
			$timeFrom = date('Y-m-d', strtotime(date("Y-m-d", strtotime($timeFrom)) . "+1 day"));
		}
		$this->timeLabel = $timeLabel;
		$this->timeLabel = array_reverse($this->timeLabel);
		/* echo '<pre>';print_r($this->time);
			echo '<pre>';print_r($this->timeLabel); */
	}
	public function actionBeLockContent()
	{
		//
		$returnUrl = Yii::app()->request->getParam('returnUrl','');
		$this->render('beLockContent', array(
				'returnUrl'=>$returnUrl
		));
	}
	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);
        $userBeReport = $this->getAllUserByRole();
        
		$model=new AdminContentApproveModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminContentApproveModel']))
			$model->attributes=$_GET['AdminContentApproveModel'];
		if(isset($_GET['datetime']) && $_GET['datetime']!='')
			$model->_search_time = $this->time;
		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize,
			'userBeReport'=>$userBeReport
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$contentId = $model->content_id;
		$contentType = $model->content_type;
		$dataPost = CJSON::decode($model->data_change);
		$dataDiff = array();
		if($contentType=='song'){
			$songModel = AdminSongModel::model()->findByPk($contentId);
			$songCate = AdminSongGenreModel::model()->getCatBySong($contentId, true);
			$metaModel = AdminSongMetadataModel::model()->findByPk($contentId);
			if(isset($dataPost['AdminSongModel'])){
				unset($dataPost['AdminSongModel']['status']);
				foreach ($dataPost['AdminSongModel'] as $key => $value){
					if(isset($songModel->$key) && $songModel->$key!=$value){
						if($key=='composer_id'){
							$dataDiff[$key]['old'] = ($songModel->$key>0)?AdminArtistModel::model()->findByPk($songModel->$key)->name:"";
							$dataDiff[$key]['new'] = ($value>0)?AdminArtistModel::model()->findByPk($value)->name:"";
						}elseif($key=='cp_id'){
							$dataDiff[$key]['old'] = ($songModel->$key>0)?AdminCpModel::model()->findByPk($songModel->$key)->name:"";;
							$dataDiff[$key]['new'] = ($value>0)?AdminCpModel::model()->findByPk($value)->name:"";;;
						}elseif($key=='copyright'){
							$dataDiff[$key]['old'] = $songModel->$key==0?"Độc quyền":"Không độc quyền";
							$dataDiff[$key]['new'] = $value==0?"Độc quyền":"Không độc quyền";
						}else{
							$dataDiff[$key]['old'] = $songModel->$key;
							$dataDiff[$key]['new'] = $value;
						}
					}
				}
			}
			$songExtra = AdminSongExtraModel::model()->findByAttributes(array("song_id"=>$contentId));
			$lyrics = ($songExtra)?nl2br($songExtra->lyrics) :"";
			if(isset($dataPost['AdminSongExtraModel']['lyrics']) && $lyrics!=$dataPost['AdminSongExtraModel']['lyrics']){
				$dataDiff['lyrics']['old'] = $lyrics;
				$dataDiff['lyrics']['new'] = $dataPost['AdminSongExtraModel']['lyrics'];
			}
			
			//genre
			$genreName="";
			if(isset($dataPost['genre_ids']) && count($dataPost['genre_ids'])>0){
				$i=0;
				foreach ($dataPost['genre_ids'] as $value){
					if($i>0){
						$genreName .= ", ";
					}
					$genreName .= AdminGenreModel::model()->findByPk($value)->name;
					$i++;
				}
			}
			if($genreName!=$songCate){
				$dataDiff['genre']['old'] = $songCate;
				$dataDiff['genre']['new'] = $genreName;
			}
			//artist
			$artistName="";
			$songArtist = AdminSongArtistModel::model()->getArtistBySong($contentId, true);
			if(isset($dataPost['artist_id_list']) && count($dataPost['artist_id_list'])>0){
				$i=0;
				foreach ($dataPost['artist_id_list'] as $value){
					if($i>0){
						$artistName .= ", ";
					}
					$artist = AdminArtistModel::model()->findByPk($value);
					$artistName .= ($artist)?$artist->name:'';
					$i++;
				}
			}
			if($artistName!=$songArtist){
				$dataDiff['artist']['old'] = $songArtist;
				$dataDiff['artist']['new'] = $artistName;
			}
			
		}elseif($contentType=='video'){
			$videoModel = AdminVideoModel::model()->findByPk($contentId);
			$metaModel = AdminVideoMetadataModel::model()->findByPk($contentId);
			unset($dataPost['AdminVideoModel']['status']);
			foreach ($dataPost['AdminVideoModel'] as $key => $value){
				if(isset($videoModel->$key) && $videoModel->$key!=$value){
					if($key=='composer_id'){
						$dataDiff[$key]['old'] = ($videoModel->$key>0)?AdminArtistModel::model()->findByPk($videoModel->$key)->name:"";
						$dataDiff[$key]['new'] = ($value>0)?AdminArtistModel::model()->findByPk($value)->name:"";
					}elseif($key=='cp_id'){
						$dataDiff[$key]['old'] = ($videoModel->$key>0)?AdminCpModel::model()->findByPk($videoModel->$key)->name:"";;
						$dataDiff[$key]['new'] = ($value>0)?AdminCpModel::model()->findByPk($value)->name:"";;;
					}elseif($key=='genre_id'){
						$dataDiff[$key]['old'] = $videoModel->$key>0?AdminGenreModel::model()->findByPk($videoModel->$key)->name:"";
						$dataDiff[$key]['new'] = $value>0?AdminGenreModel::model()->findByPk($value)->name:"";
					}else{
						$dataDiff[$key]['old'] = $videoModel->$key;
						$dataDiff[$key]['new'] = $value;
					}
				}
			}
			$videoExtra = AdminVideoExtraModel::model()->findByAttributes(array("video_id"=>$contentId));
			$lyrics = ($videoExtra)?nl2br($videoExtra->description) :"";
			if($lyrics!=$dataPost['AdminVideoModel']['description']){
				$dataDiff['lyrics']['old'] = $lyrics;
				$dataDiff['lyrics']['new'] = $dataPost['AdminVideoModel']['description'];
			}
			//artist
			$artistName="";
			$songArtist = AdminVideoArtistModel::model()->getArtistByVideo($contentId, true);
			if(isset($dataPost['artist_id_list']) && count($dataPost['artist_id_list'])>0){
				$i=0;
				foreach ($dataPost['artist_id_list'] as $value){
					if($i>0){
						$artistName .= ", ";
					}
					$artistName .= AdminArtistModel::model()->findByPk($value)->name;
					$i++;
				}
			}
			if($artistName!=$songArtist){
				$dataDiff['artist']['old'] = $songArtist;
				$dataDiff['artist']['new'] = $artistName;
			}
		}
		//echo '<pre>';print_r($dataDiff);
		$this->render('view',array(
			'model'=>$model,
			'dataDiff'=>$dataDiff
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ContentApproveModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ContentApproveModel']))
		{
			$model->attributes=$_POST['ContentApproveModel'];
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

		if(isset($_POST['AdminContentApproveModel']))
		{
			$model->attributes=$_POST['AdminContentApproveModel'];
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

		if(isset($_POST['ContentApproveModel']))
		{
                        $model=new ContentApproveModel;
			$model->attributes=$_POST['ContentApproveModel'];
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
        	ContentApproveModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			ContentApproveModel::model()->deleteAll($c);
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
		$model=AdminContentApproveModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='content-approve-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * 
	 */
	public function actionCancelApproved()
	{
		$this->layout=false;
		$id = Yii::app()->request->getParam('id',0);
		$data = AdminContentApproveModel::model()->findByPk($id);
		$data->status=2;
		$data->approved_id = Yii::app()->user->id;
		$data->approved_time = date('Y-m-d H:i:s');
		if($data->save(false)){
			echo CJSON::encode(array(
				'error_code'=>0,
				'error_msg'=>'Success'
			));
		}else{
			echo CJSON::encode(array(
					'error_code'=>1,
					'error_msg'=>$data->getError,
			));
		}
		Yii::app()->end();
	}
	protected function getAllUserByRole($role='CTVRole')
	{
		$sql = "SELECT c1.userid, c2.username
		FROM admin_access_assignments c1
		LEFT JOIN admin_user c2 ON c1.userid=c2.id
		WHERE c1.itemname='$role'";
		return Yii::app()->db->createCommand($sql)->queryAll();
	}
	
}
