<?php

class TagController extends Controller{

	public function init()
	{
		parent::init();
		$this->pageTitle = Yii::t('admin', "Quản lý  Tag ") ;
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$flag=true;
		
		$pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
		Yii::app()->user->setState('pageSize',10);

		$model=new AdminTagModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminTagModel']))
			$model->attributes=$_GET['AdminTagModel'];

		$this->renderPartial('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize
		),false,true);
		Yii::app()->user->setState('pageSize',Yii::app()->params['pageSize']);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if(Yii::app()->request->isPostRequest) 
		{
			$name = strip_tags($_POST["tag_name"]);
			$model = AdminTagModel::model()->findByAttributes(array("name"=>$name));
			if(empty($model)){
				$model=new AdminTagModel;				
			}
			$model->name = $name;
			$model->save();
		}
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
			$c = new CDbCriteria();
			$c->condition = "tag_id=:ID";
			$c->params = array(":ID"=>$id);
			$count = TagContentModel::model()->count($c);
			if($count>0){
				throw new CHttpException(400,'Không xóa được tag này vì vẫn còn nội dung');
			}
			
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminTagModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-tag-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
