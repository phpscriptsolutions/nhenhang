<?php

class AdsSourceController extends Controller
{
	
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý  Ads Source ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminAdsSourceModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminAdsSourceModel']))
			$model->attributes=$_GET['AdminAdsSourceModel'];

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
		$model=new AdminAdsSourceModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminAdsSourceModel']))
		{
			$model->attributes=$_POST['AdminAdsSourceModel'];
			$model->created_datetime = new CDbExpression('NOW()');
			if($model->save()){
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

		if(isset($_POST['AdminAdsSourceModel']))
		{
			$model->attributes=$_POST['AdminAdsSourceModel'];
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

		if(isset($_POST['AdminAdsSourceModel']))
		{
                        $model=new AdminAdsSourceModel;
			$model->attributes=$_POST['AdminAdsSourceModel'];
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
			$model = AdsSourceModel::model()->findByPk($id);
			$model->status=2;
			$model->save(false);

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
        	//AdminAdsSourceModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
			$cids = AdminAdsSourceModel::model()->updateAll(array('status'=>2), $c);
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
		$model=AdminAdsSourceModel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	public function actionPopupList()
	{
		$flag=true;
		$id_field =  Yii::app()->request->getParam('id_field');
		$name_field =  Yii::app()->request->getParam('name_field');
		$id_dialog =  Yii::app()->request->getParam('id_dialog','jobDialog');
		if(Yii::app()->getRequest()->ispostRequest){
			$flag = false;
		}
	
		if($flag){
			Yii::app()->user->setState('pageSize',20);
			$model = new AdminAdsSourceModel('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['AdminAdsSourceModel']))
				$model->attributes=$_GET['AdminAdsSourceModel'];
			$model->setAttribute("status", AdsSourceModel::ACTIVE);
	
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('popupList',array(
					'model'=>$model,
					'id_field'=>$id_field,
					'name_field'=>$name_field,
					'id_dialog'=>$id_dialog,
			),false,true);
			Yii::app()->user->setState('pageSize',Yii::app()->params['pageSize']);
		}
	}
	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-ads-source-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
