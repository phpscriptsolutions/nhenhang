<?php

class ChannelController extends Controller
{
	const _PATH_ICONS_UPLOAD = '/music_storage/chacha2.0/radio/icons/';
	//const _PATH_ICONS_UPLOAD = 'E:\phuongnv\Vega\chacha_cloud\src\trunk\chacha\data\tmp\\';
	const _URL_ICONS_RADIO = 'http://s2.chacha.vn/radio/icons/';
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý  Radio ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminRadioModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminRadioModel']))
			$model->attributes=$_GET['AdminRadioModel'];

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
		
		$model=new AdminRadioModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminRadioModel']))
		{
			$model->attributes=$_POST['AdminRadioModel'];
			if(isset($_POST['AdminRadioModel']['time_point'])){
				$time_point = implode(',', $_POST['AdminRadioModel']['time_point']);
				$model->setAttribute('time_point', $time_point);
			}else{
				$model->setAttribute('time_point', 1);
			}
			if(isset($_POST['AdminRadioModel']['day_week'])){
				$day_week = implode(',', $_POST['AdminRadioModel']['day_week']);
				$model->setAttribute('day_week', $day_week);
			}else{
				$model->setAttribute('day_week', 1);
			}
			if(isset($_POST['AdminRadioModel']['daytotime'])){
				$dayToTime = json_encode($_POST['AdminRadioModel']['daytotime']);
				$model->setAttribute('day_to_time', $dayToTime);
			}else{
				$model->setAttribute('day_to_time', '');
			}
			$model->setAttribute('created_time', date('Y-m-d H:i:s'));
			if($model->save()){
				if(isset($_POST['AdminRadioModel']['weather_id'])){
					$radioWModel = new AdminRadioWeatherModel();
					$sql = "INSERT INTO radio_weather(radio_id, weather_id) VALUES";
					foreach ($_POST['AdminRadioModel']['weather_id'] as $w){
						$radioId = $model->id;
						$sqlArr[] ="('$radioId','$w')";
					}
					$sql .=implode(',', $sqlArr);
					$sql .="ON DUPLICATE KEY UPDATE radio_id = '$radioId'";
					//echo '<pre>';print_r($sqlArr);exit;
					$res = Yii::app()->db->createCommand($sql)->execute();
				}
				if(isset($_POST['tmp_file_path']) && $_POST['tmp_file_path']!=''){
                    $tmpFile = _APP_PATH_.DS."data".DS."tmp".DS.$_POST['tmp_file_path'];
					if(file_exists($tmpFile)){
						//$this->moveFile($model->id, $model->type, $tmpFile);
						AvatarHelper::processAvatar($model, $tmpFile);
					}
				}
				if(isset($_POST['yt0']) && $_POST['yt0']='Create'){
					$this->redirect(array('view','id'=>$model->id));
				}else{
					$this->redirect(array('update','id'=>$model->id));
				}
				
			}
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

		if(isset($_POST['AdminRadioModel']))
		{
			//echo '<pre>';print_r($_POST);exit;
			$model->attributes=$_POST['AdminRadioModel'];
			if(isset($_POST['AdminRadioModel']['time_point'])){
				$time_point = implode(',', $_POST['AdminRadioModel']['time_point']);
				$model->setAttribute('time_point', $time_point);
			}else{
				$model->setAttribute('time_point', 1);
			}
			if(isset($_POST['AdminRadioModel']['day_week'])){
				$day_week = implode(',', $_POST['AdminRadioModel']['day_week']);
				$model->setAttribute('day_week', $day_week);
			}else{
				$model->setAttribute('day_week', 1);
			}
			
			if(isset($_POST['AdminRadioModel']['weather_code'])){
				$weather_code = implode(',', $_POST['AdminRadioModel']['weather_code']);
				$model->setAttribute('weather_code', $weather_code);
			}else{
				$model->setAttribute('weather_code', '');
			}
			
			if(isset($_POST['AdminRadioModel']['daytotime'])){
				$dayToTime = json_encode($_POST['AdminRadioModel']['daytotime']);
				$model->setAttribute('day_to_time', $dayToTime);
			}else{
				$model->setAttribute('day_to_time', '');
			}
			if($model->save()){
				$res = Yii::app()->db->createCommand("DELETE FROM radio_weather WHERE radio_id=".intval($model->id))->execute();
				if(isset($_POST['AdminRadioModel']['weather_id'])){
					$radioWModel = new AdminRadioWeatherModel();
					$sql = "INSERT INTO radio_weather(radio_id, weather_id) VALUES";
					foreach ($_POST['AdminRadioModel']['weather_id'] as $w){
						$radioId = $model->id;
						$sqlArr[] ="('$radioId','$w')";
					}
					$sql .=implode(',', $sqlArr);
					$sql .="ON DUPLICATE KEY UPDATE radio_id = '$radioId'";
					$res = Yii::app()->db->createCommand($sql)->execute();
				}
				
				
				if(isset($_POST['tmp_file_path']) && $_POST['tmp_file_path']!=''){
					$tmpFile = _APP_PATH_.DS."data".DS."tmp".DS.$_POST['tmp_file_path'];
					
					if(file_exists($tmpFile)){
						//$this->moveFile($model->id, $model->type, $tmpFile);
						$res = AvatarHelper::processAvatar($model, $tmpFile);
						
					}
				}
				if(isset($_POST['yt0']) && $_POST['yt0']='Save'){
					$this->redirect(array('view','id'=>$model->id));
				}else{
					$this->redirect(array('update','id'=>$model->id));
				}
			}
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

		if(isset($_POST['AdminRadioModel']))
		{
                        $model=new AdminRadioModel;
			$model->attributes=$_POST['AdminRadioModel'];
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
			$sql = "SELECT count(*) FROM radio where parent_id=:id";
			$cm = Yii::app()->db->createCommand($sql);
			$cm->bindParam(':id', $id, PDO::PARAM_INT);
			$count = $cm->queryScalar();
			
			if($count>0){
				echo 'Hãy xóa các kênh con của kênh hiện tại trước khi xóa kênh này.';
			}else{
				// we only allow deletion via POST request
				$model = $this->loadModel($id);
				if($model->delete()){
					$weatherDelete = Yii::app()->db->createCommand("DELETE FROM radio_weather WHERE radio_id=$id")->execute();
					echo '';
				}
			}
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			/* if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index')); */
		}
		else
			echo 'Invalid request. Please do not repeat this request again.';
	}
	
	public function actionActive($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel($id);
			if($model->status==1){
				$model->setAttribute('status', 0);
			}else{
				$model->setAttribute('status', 1);
			}
			$model->save();

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
        	AdminRadioModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			AdminRadioModel::model()->deleteAll($c);
		}
        $this->redirect(array('index'));
	}

	public function actionPopupCollection()
	{
		Yii::app()->user->setState('pageSize',20);
		$model = new AdminArtistModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminArtistModel']))
			$model->attributes=$_GET['AdminArtistModel'];
		$model->setAttribute("status", ArtistModel::ACTIVE);
		
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		$this->renderPartial('popup_list',array(
				'model'=>$model,
				/*'id_field'=>$id_field,
				'id_dialog'=>$id_dialog,
				'index'=>$index*/
		),false,true);
		Yii::app()->user->setState('pageSize',Yii::app()->params['pageSize']);
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminRadioModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-radio-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	private function moveFile($id, $type, $fileSource)
	{
		try{
			$pathUpload = Yii::app()->params['storage']['radioDir'].DS."channel".DS;
			$filePath = $pathUpload.$id.".png";
			$fileSystem = new Filesystem();
			$fileSystem->copy($fileSource, $filePath);
			//$fileSystem->remove($fileSource);
		}catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}
}
