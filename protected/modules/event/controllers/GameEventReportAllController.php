<?php

class GameEventReportAllController extends Controller
{
	
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý Game Event Report All ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        //$pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        //Yii::app()->user->setState('pageSize',$pageSize);

		$model=new GameEventReportAllModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GameEventReportAllModel']))
			$model->attributes=$_GET['GameEventReportAllModel'];
		
		$date = trim($_GET['GameEventReportAllModel']['date']);
		$splited = explode("-",$date);
		if (count($splited)>1) {
			$fromDate =  DateTime::createFromFormat('m/j/Y', trim($splited[0]))->format('Y-m-j');
			$toDate =  DateTime::createFromFormat('m/j/Y', trim($splited[1]))->format('Y-m-j');
			$model->date = array($fromDate.' 0:0:0',$toDate.' 23:59:59');
		} else {
			if ($date!="")
				$model->date = DateTime::createFromFormat('m/j/Y', $date)->format('Y-m-j');
		}
		
		$data = $model->searchTotal();
		$total = array(
				'total_sub' => 0,
				'total_unsub' => 0,
				'access_event' => 0,
				'access_play' => 0,
				'total_play_all' => 0,
				'total_msisdn_valid' => 0,
				'listen_music' => 0,
				'download_music' => 0,
				'play_video' => 0,
				'download_video' => 0,
				'have_transaction' => 0,		
		);
		foreach ($data as $row) {
			$total['total_sub'] += $row['total_sub'];
			$total['total_unsub'] += $row['total_unsub'];
			$total['access_event'] += $row['access_event'];
			$total['access_play'] += $row['access_play'];
			$total['total_play_all'] += $row['total_play_all'];
			$total['total_msisdn_valid'] += $row['total_msisdn_valid'];
			$total['listen_music'] += $row['listen_music'];
			$total['download_music'] += $row['download_music'];
			$total['play_video'] += $row['play_video'];
			$total['download_video'] += $row['download_video'];
			$total['have_transaction'] += $row['have_transaction'];
		}
		$this->render('index',array(
			'model'=>$model,
            //'pageSize'=>$pageSize,
			'data' => $data,
			'total' => $total,
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
		$model=new GameEventReportAllModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['GameEventReportAllModel']))
		{
			$model->attributes=$_POST['GameEventReportAllModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->date));
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

		if(isset($_POST['GameEventReportAllModel']))
		{
			$model->attributes=$_POST['GameEventReportAllModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->date));
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

		if(isset($_POST['GameEventReportAllModel']))
		{
                        $model=new GameEventReportAllModel;
			$model->attributes=$_POST['GameEventReportAllModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->date));
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
        	GameEventReportAllModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			GameEventReportAllModel::model()->deleteAll($c);
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
		$model=GameEventReportAllModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='game-event-report-all-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
