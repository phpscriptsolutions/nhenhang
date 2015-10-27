<?php

class PackageController extends Controller
{
	
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý  Package ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminPackageModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminPackageModel']))
			$model->attributes=$_GET['AdminPackageModel'];

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
		$model=new AdminPackageModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminPackageModel']))
		{
			$model->attributes=$_POST['AdminPackageModel'];
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

		if(isset($_POST['AdminPackageModel']))
		{
			$model->attributes=$_POST['AdminPackageModel'];
			if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
			}							
			else{
				echo "<pre>";print_r($model->getErrors());exit(); 
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

		if(isset($_POST['AdminPackageModel']))
		{
                        $model=new AdminPackageModel;
			$model->attributes=$_POST['AdminPackageModel'];
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
		die('Your Request Invalid');
		/* if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.'); */
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
    	die('Your Request Invalid');
    	/* if(isset($_POST['all-item'])){
        	AdminPackageModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			AdminPackageModel::model()->deleteAll($c);
		}
        $this->redirect(array('index')); */
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminPackageModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-package-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
