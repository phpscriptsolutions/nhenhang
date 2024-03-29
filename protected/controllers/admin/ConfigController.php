<?php

class ConfigController extends Controller
{

    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý Config ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$timeStamp = Yii::app()->user->getState('__timeout');
		
        $category = Yii::app()->request->getParam('category','basic');
        if(!UserAccess::checkAccess('ConfigSupper_Index',true) && $category == 'advance')
            throw new CHttpException(403, 'Bạn không có quyền truy cập');
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new ConfigModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ConfigModel']))
			$model->attributes=$_GET['ConfigModel'];

        //$model->category = $category;
		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize
		));
	}

    public function actionSupper_Index(){
        $this->redirect(Yii::app()->createUrl('/config/index',array('category' => 'advance')));
    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $model = $this->loadModel($id);
        if($model->category == 'advance' && !UserAccess::checkAccess('ConfigSupper_Index',true))
            throw new CHttpException(403, 'Bạn không có quyền truy cập');
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        if(!UserAccess::checkAccess('ConfigSupper_Index',true))
            throw new CHttpException(403, 'Bạn không có quyền truy cập');
		$model=new ConfigModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ConfigModel']))
		{
			$model->attributes=$_POST['ConfigModel'];
			$flag = true;
            if($model->type == "array"){
            	$value = json_decode($model->value,true);
            	if(is_array($value)){
            		$model->value = serialize ($value);
            	}else{
            		$model->addError("value", "Sai kiểu dữ liệu nhập vào");
            		$flag = false;
            	}
            }

            $arr_channels = $_POST['channels'];
            $channels = implode(',',$arr_channels);
            $model->channel = $channels;
            if($flag){
				if($model->save()){
					$this->redirect(array('view','id'=>$model->id));
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
        $model = $this->loadModel($id);
        if($model->category == 'advance' && !UserAccess::checkAccess('ConfigSupper_Index',true))
            throw new CHttpException(403, 'Bạn không có quyền truy cập');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ConfigModel']))
		{
			$model->attributes=$_POST['ConfigModel'];
			$flag = true;
            if($model->type == "array"){
            	$value = json_decode($model->value,true);
            	if(is_array($value)){
            		$model->value = serialize ($value);
            	}else{
            		$model->addError("value", "Sai kiểu dữ liệu nhập vào");
            		$flag = false;
            	}
            }

            $arr_channels = $_POST['channels'];
            $channels = implode(',',$arr_channels);
            $model->channel = $channels;
            if($flag){
            	if($model->save()){
            		$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['ConfigModel']))
		{
                        $model=new ConfigModel;
			$model->attributes=$_POST['ConfigModel'];
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
            $model = $this->loadModel($id);
            if($model->category == 'advance' && !UserAccess::checkAccess('ConfigSupper_Index',true))
                throw new CHttpException(403, 'Bạn không có quyền truy cập');

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
        if(!UserAccess::checkAccess('ConfigSupper_Index',true))
            throw new CHttpException(403, 'Bạn không có quyền truy cập');
    	if(isset($_POST['all-item'])){
        	ConfigModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			ConfigModel::model()->deleteAll($c);
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
		$model=ConfigModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='config-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
