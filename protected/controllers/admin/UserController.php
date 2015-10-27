<?php

class UserController extends Controller
{
	
    public function init()
	{
            parent::init();
            $this->pageTitle = "Manage  User";
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminUserModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminUserModel']))
			$model->attributes=$_GET['AdminUserModel'];
			/*
		foreach ($model->search()->getData() as $data){
			//echo "<pre>";print_r($data);exit();
			echo $data->username."<br />";
		}
		exit;
		 */

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
		$model=new AdminUserModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminUserModel']))
		{
            //if($_POST['AdminUserModel']['password']) $_POST['AdminUserModel']['password'] = md5($_POST['AdminUserModel']['password']);
			$model->attributes=$_POST['AdminUserModel'];
			$model->setAttribute("password", Common::endcoderPassword($_POST['AdminUserModel']['password']));
			$model->setAttribute("created_time", date("Y-m-d H:i:s"));
			$model->setAttribute("updated_time", date("Y-m-d H:i:s"));
			
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
		$password = $model->password;
		if(isset($_POST['AdminUserModel']))
		{
            //if($_POST['AdminUserModel']['password']) $_POST['AdminUserModel']['password'] = md5($_POST['AdminUserModel']['password']);
			$model->attributes=$_POST['AdminUserModel'];
			if(isset($_POST['AdminUserModel']['password']) && $_POST['AdminUserModel']['password'] != ""){
				$model->setAttribute("password", Common::endcoderPassword($_POST['AdminUserModel']['password']));
			}else{
				$model->setAttribute("password", $password);
			}
			$model->setAttribute("updated_time", date("Y-m-d H:i:s"));
			
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

		if(isset($_POST['AdminUserModel']))
		{
           	$model=new AdminUserModel;
			$model->attributes=$_POST['AdminUserModel'];
			$model->setAttribute("password", Common::endcoderPassword($_POST['AdminUserModel']['password']));
			$model->setAttribute("created_time", date("Y-m-d H:i:s"));
			$model->setAttribute("updated_time", date("Y-m-d H:i:s"));
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('copy',array(
			'model'=>$data,
		));
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
    	die('Your Request Invalid!');
    	
    	/* if(isset($_POST['all-item'])){
        	AdminUserModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			AdminUserModel::model()->deleteAll($c);
		}
        $this->redirect(array('index')); */
	}

    public function actionAutoList() {
		if(Yii::app()->request->isAjaxRequest && isset($_GET['q'])){
          $name = $_GET['q']; 

          $limit = min($_GET['limit'], 50); 
          $criteria = new CDbCriteria;
          $criteria->condition = "username LIKE :sterm";
          $criteria->params = array(":sterm"=>"$name%");
          $criteria->limit = $limit;
          $userArray = AdminUserModel::model()->findAll($criteria);
          $returnVal = '';
          foreach($userArray as $userAccount)
          {
             $returnVal .= $userAccount->getAttribute('username').'|'
                                         .$userAccount->getAttribute('id')."\n";
          }
          echo $returnVal;
       }
    	
    }
    
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminUserModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-user-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
