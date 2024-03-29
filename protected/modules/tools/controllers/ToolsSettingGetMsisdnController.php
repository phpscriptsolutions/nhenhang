<?php

class ToolsSettingGetMsisdnController extends Controller
{
	
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý  Tools Setting Get Msisdn ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminToolsSettingGetMsisdnModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminToolsSettingGetMsisdnModel']))
			$model->attributes=$_GET['AdminToolsSettingGetMsisdnModel'];

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
		$model=new AdminToolsSettingGetMsisdnModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminToolsSettingGetMsisdnModel']))
		{
			$model->attributes=$_POST['AdminToolsSettingGetMsisdnModel'];
			$model->created_datetime = new CDbExpression("NOW()");
			
			if($_POST['params']['type']==1){
				if(empty($_POST['params']['datefrom']) || empty($_POST['params']['dateto'])){
					$model->addError('params', 'Thời gian lọc thuê bao không hợp lệ');
				}
			}elseif($_POST['params']['type']==2){
				if(empty($_POST['params']['subs_datefrom']) || empty($_POST['params']['subs_datefrom'])){
					$model->addError('params', 'Thời gian đăng ký gói cước không hợp lệ');
				}
			}
			$model->params = json_encode($_POST['params']);
			if($model->validate(null, false)){
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
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
		if(isset($_POST['AdminToolsSettingGetMsisdnModel']))
		{
			$model->attributes=$_POST['AdminToolsSettingGetMsisdnModel'];
			if($_POST['params']['type']==1){
				if(empty($_POST['params']['datefrom']) || empty($_POST['params']['dateto'])){
					$model->addError('params', 'Thời gian lọc thuê bao không hợp lệ');
				}
			}elseif($_POST['params']['type']==2){
				if(empty($_POST['params']['subs_datefrom']) || empty($_POST['params']['subs_datefrom'])){
					$model->addError('params', 'Thời gian đăng ký gói cước không hợp lệ');
				}
			}
			$model->params = json_encode($_POST['params']);
			if($model->validate(null, false)){
				if($model->save())
					$this->redirect(array('view','id'=>$model->id));
			}
			
		}
		$params = json_decode($model->params);
		$this->render('update',array(
			'model'=>$model,
			'params'=>$params
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

		if(isset($_POST['AdminToolsSettingGetMsisdnModel']))
		{
                        $model=new AdminToolsSettingGetMsisdnModel;
			$model->attributes=$_POST['AdminToolsSettingGetMsisdnModel'];
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
		echo 'Can not delete setting';
		exit;
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
    	echo 'Can not delete setting';
    	exit;
    	if(isset($_POST['all-item'])){
        	AdminToolsSettingGetMsisdnModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			AdminToolsSettingGetMsisdnModel::model()->deleteAll($c);
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
		$model=AdminToolsSettingGetMsisdnModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-tools-setting-get-msisdn-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
