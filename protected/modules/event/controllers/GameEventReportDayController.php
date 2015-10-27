<?php

class GameEventReportDayController extends Controller
{
	
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý Game Event Report day ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{		
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new GameEventReportDayModel('search');
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['GameEventReportDayModel']))
			$model->attributes=$_GET['GameEventReportDayModel'];
		
		$time_start = trim($_GET['GameEventReportDayModel']['time_start']);
		$splited = explode("-",$time_start);
		if (count($splited)>1) {
			$fromDate =  DateTime::createFromFormat('m/j/Y', trim($splited[0]))->format('Y-m-j');
			$toDate =  DateTime::createFromFormat('m/j/Y', trim($splited[1]))->format('Y-m-j');
			$model->time_start = array($fromDate.' 0:0:0',$toDate.' 23:59:59');
		} else {
			if ($time_start!="")
				$model->time_start = DateTime::createFromFormat('m/j/Y', $date)->format('Y-m-j');
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
	public function actionView()
	{ 
		//$model = $this->loadModel($id);		
		$phone = Yii::app()->request->getParam('phone');		
		$date = Yii::app()->request->getParam('date');
		
		
		if ($phone && $date) {
			$date = date("Y-m-d", strtotime($date));
			$data = GameEventUserLogModel::model()->getLogByPhone($date, $phone);
			$this->render('view',array(
				//'model'=>$model,
				'data'=>$data,
			));
		} else {
			throw new CHttpException(404,'The requested page does not exist.');
		}
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
        	GameEventReportDayModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			GameEventReportDayModel::model()->deleteAll($c);
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
		$model=GameEventReportDayModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='game-event-report-day-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
