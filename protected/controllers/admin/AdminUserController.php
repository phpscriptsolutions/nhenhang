<?php

class AdminUserController extends Controller
{

    public function init()
	{
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý   Admin User") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{

        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminAdminUserModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminAdminUserModel']))
			$model->attributes=$_GET['AdminAdminUserModel'];

		$cpList = AdminCpModel::model()->findAll();
		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize,
			'cpList'=>$cpList
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$user = $this->loadModel($id);
		$cp = AdminCpModel::model()->findByPk($user->cp_id);
		$this->render('view',array(
			'model'=>$user,
			'cp'=>$cp
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AdminAdminUserModel;

		if(isset($_POST['AdminAdminUserModel']))
		{
			$model->attributes=$_POST['AdminAdminUserModel'];
			$model->setAttribute("password", Common::endcoderPassword($_POST['AdminAdminUserModel']['password']));
			$model->setAttribute("ccp_id", $_POST['AdminAdminUserModel']['ccp_id']);

			if($model->save()){
				$role = $_POST['role'];
				$this->setRole($model->id, $role);
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		$cpList = AdminCpModel::model()->findAll();
		$roles = AdminAdminAccessItemsModel::model()->getListRoles();

		$this->render('create',array(
			'model'=>$model,
			'cpList'=>$cpList,
			'roles'=>$roles,
			'userRole'=>''
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
		if(isset($_POST['AdminAdminUserModel']))
		{
			$model->attributes=$_POST['AdminAdminUserModel'];


			if($_POST['AdminAdminUserModel']['require_changepass']==1)
            	$model->setAttribute ('require_changepass', 1);
			else
            	$model->setAttribute ('require_changepass', 0);

			if(isset($_POST['AdminAdminUserModel']['password']) && $_POST['AdminAdminUserModel']['password'] != ""){
				$model->setAttribute("password", Common::endcoderPassword($_POST['AdminAdminUserModel']['password']));
			}else{
				$model->setAttribute("password", $password);
			}
			$model->setAttribute("ccp_id", $_POST['AdminAdminUserModel']['ccp_id']);

			if($model->save()){
				$role = $_POST['role'];
				$this->setRole($model->id, $role);
				$this->redirect(array('view','id'=>$model->id));
			}

		}

		$cpList = AdminCpModel::model()->findAll();
		$roles = AdminAdminAccessItemsModel::model()->getListRoles();
		$userRole = $this->getRole($id);
		$this->render('update',array(
			'model'=>$model,
			'cpList'=>$cpList,
			'roles'=>$roles,
			'userRole'=>$userRole
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
			$model->status=0;
			$model->save(false);
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	public function actionProfile()
	{
		if(Yii::app()->user->isGuest) Yii::app()->user->loginRequired();

		$model = AdminAdminUserModel::model()->findByPk($this->userId);
		$password = $model->password;
		
		if(isset($_POST['AdminAdminUserModel']))
		{
			$model->attributes=$_POST['AdminAdminUserModel'];
			$flag = true;
			if(isset($_POST['AdminAdminUserModel']['password']) && $_POST['AdminAdminUserModel']['password'] != ""
				&& $_POST['AdminAdminUserModel']['password'] == $_POST['AdminAdminUserModel']['re-password']
			){
				$newPass = $_POST['AdminAdminUserModel']['password'];
				if($this->validatePassword($newPass)){
					$model->setAttribute("password", Common::endcoderPassword($newPass));
					$model->setAttribute("require_changepass",0);
					$model->setAttribute("last_updatepass",new CDbExpression("NOW()"));
				}else{
					$flag = false;
					$model->addError("err", Yii::t('admin','Password chưa đủ độ mạnh'));
				}
			}else{
				if($_POST['AdminAdminUserModel']['password'] != $_POST['AdminAdminUserModel']['re-password']){
					$flag = false;
					$model->addError("err", Yii::t('admin','Password chưa giống nhau'));
				}else{
					$model->setAttribute("password", $password);
				}
			}
			if($flag){
				if($model->save()){
					$msg = Yii::t('admin','System will auto logout. Please login again!');
					$linkLogin = Yii::app()->createUrl('admin/logout');
					echo "<script>
							alert('$msg');
							window.location.href = '$linkLogin';
						</script>";
					
					//$this->redirect(array('admin/logout'));
				}
					
			}
		}
		
		$cp = AdminCpModel::model()->findByPk($model->cp_id);
		
		$view = "adminInfo";
		if(Yii::app()->request->getParam('_layout') == 'update'){
			$view = "profile";
		}
		$this->render($view ,array(
							'model'=>$model,
							'cp'=>$cp,
						));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminAdminUserModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-admin-user-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	private function setRole($userId,$role)
	{
		//Reset role
		$c = new CDbCriteria();
		$c->condition = "userid=:UID";
		$c->params = array(':UID'=>$userId);
		AdminAdminAccessAssignmentsModel::model()->deleteAll($c);
		//CREATE NEW
		$roleAss = new 	AdminAdminAccessAssignmentsModel();
		$roleAss->itemname = $role;
		$roleAss->userid = $userId;
		$roleAss->bizrule = '';
		$roleAss->data = 's:0:"";';
		$roleAss->save();
	}

	private function getRole($userId)
	{
		$c = new CDbCriteria();
		$c->condition = "userid=:UID";
		$c->params = array(':UID'=>$userId);
		$roles = AdminAdminAccessAssignmentsModel::model()->find($c);
		if(!empty($roles)){
			return $roles->itemname;
		}
		return '';
	}

	private function validatePassword($string)
	{
		//$ret =  preg_match("/^[A-Za-z]([\w]){7,}$/",$string) && preg_match("/\d/",$string);
		$ret =  preg_match("/^[A-Za-z](.){7,}$/",$string) && preg_match("/\d/",$string);
		return $ret;
	}
}
