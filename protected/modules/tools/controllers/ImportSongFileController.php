<?php

class ImportSongFileController extends Controller
{
	
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý Import Song File ") ;
	}
	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);
		$model=new ImportSongFileModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ImportSongFileModel']))
			$model->attributes=$_GET['ImportSongFileModel'];
			$model->_order="id DESC";
		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize
		));
	}
	public function actionReloadParams()
    {
    	sleep(2);
    	try{
	    	$this->layout=false;
	    	$fileId = Yii::app()->request->getParam('fileId',0);
	    	ImportSongFileModel::updateStatImport($fileId);
	    	$params = ImportSongFileModel::model()->findByPk($fileId)->params;
	    	echo CJSON::encode(array(
	    			'error_code'=>0,
	    			'data'=>$params
	    	));
    	}catch (Exception $e){
    		echo CJSON::encode(array(
    				'error_code'=>1,
    				'data'=>$e->getMessage()
    		));
    	}
    	Yii::app()->end();
    }
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$stat = ImportSongFileModel::updateStatImport($id);
		//echo '<pre>';print_r($stat);
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
		$model=new ImportSongFileModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ImportSongFileModel']))
		{
			$model->attributes=$_POST['ImportSongFileModel'];
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

		if(isset($_POST['ImportSongFileModel']))
		{
			$model->attributes=$_POST['ImportSongFileModel'];
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

		if(isset($_POST['ImportSongFileModel']))
		{
                        $model=new ImportSongFileModel;
			$model->attributes=$_POST['ImportSongFileModel'];
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
			$deletedFile = $this->loadModel($id)->delete();
			if($deletedFile){
				ImportSongModel::model()->deleteAll("file_id=:fileId", array(':fileId'=>$id));
			}

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
        	ImportSongFileModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			ImportSongFileModel::model()->deleteAll($c);
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
		$model=ImportSongFileModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='import-song-file-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
