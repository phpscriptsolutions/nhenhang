<?php

class ToolsMsisdnController extends Controller
{
	
    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý  Tools Msisdn ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);
		$id = intval(Yii::app()->request->getParam('id'));
		$count = Yii::app()->db->createCommand("select count(*) from tools_msisdn where setting_id=$id")->queryScalar();
		$perPage = 50000;
		if ($count <= $perPage) {
			$numPage = 1;
		} elseif (($count % $perPage) == 0) {
			$numPage = ($count / $perPage) ;
		} else {
			$numPage = ($count / $perPage) + 1;
			$numPage = (int) $numPage;
		}
		$model = new AdminToolsMsisdnModel('search');
		$model->unsetAttributes();  // clear any default values
		$model->setting_id = $id;
		if(isset($_GET['AdminToolsMsisdnModel']))
			$model->attributes=$_GET['AdminToolsMsisdnModel'];

		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize,
			'numPage'=>$numPage,
			'id'=>$id
		));
	}
	public function actionExport()
	{
		$id = Yii::app()->request->getParam('id');
		$page = Yii::app()->request->getParam('page',1);
		$limit = 50000;
		$offset = ($page - 1) * $limit;
		$sql = "SELECT msisdn from tools_msisdn 
				WHERE setting_id=:sid 
				LIMIT :limit
				OFFSET :offset
				";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindParam(':sid', $id, PDO::PARAM_STR);
		$command->bindParam(':offset', $offset, PDO::PARAM_INT);
		$command->bindParam(':limit', $limit, PDO::PARAM_INT);
		$data = $command->queryAll();
		$label = array(
				'msisdn'=>'Thuê bao'
		);
		$title = Yii::t('admin', 'Export_'.$page);
		$excelObj = new ExcelExport($data, $label, $title);
		$excelObj->export();
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
		$model=new AdminToolsMsisdnModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminToolsMsisdnModel']))
		{
			$model->attributes=$_POST['AdminToolsMsisdnModel'];
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

		if(isset($_POST['AdminToolsMsisdnModel']))
		{
			$model->attributes=$_POST['AdminToolsMsisdnModel'];
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

		if(isset($_POST['AdminToolsMsisdnModel']))
		{
                        $model=new AdminToolsMsisdnModel;
			$model->attributes=$_POST['AdminToolsMsisdnModel'];
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
        	AdminToolsMsisdnModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			AdminToolsMsisdnModel::model()->deleteAll($c);
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
		$model=AdminToolsMsisdnModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-tools-msisdn-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
