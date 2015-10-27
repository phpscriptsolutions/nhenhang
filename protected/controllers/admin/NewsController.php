<?php
Yii::import("ext.xupload.models.XUploadForm");
class NewsController extends Controller
{
	
    public function init()
	{
         parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý  News") ;
	}
	
    public function actions()
    {
        return array(
            'upload'=>array(
                'class'=>'ext.xupload.actions.XUploadAction',
                'subfolderVar' => 'parent_id',
                'path' => _APP_PATH_.DS."data",
        		'alowType'=>'image/jpeg,image/png,image/gif,image/x-png,image/pjpeg'
            ),
        );
    }	

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminNewsModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminNewsModel']))
			$model->attributes=$_GET['AdminNewsModel'];

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
		$model=new AdminNewsModel;

		if(isset($_POST['AdminNewsModel']))
		{
			$model->attributes=$_POST['AdminNewsModel'];
			$model->setAttributes(
							array(
								'created_by'=>$this->userId,
								'created_time'=>date("Y-m-d H:i:s") 
							)
						);
			if($model->save()){
				$fileAvatar = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS .$_POST['AdminNewsModel']['source_path'];
				if(file_exists($fileAvatar)){
				    AvatarHelper::processAvatar($model, $fileAvatar, 'news', 16, 9);
				}
				$this->redirect(array('view','id'=>$model->id));
			}				
		}
		
		$uploadModel = new XUploadForm();
		$this->render('create',array(
			'model'=>$model,
			'uploadModel'=>$uploadModel,
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

		if(isset($_POST['AdminNewsModel']))
		{
			$model->attributes=$_POST['AdminNewsModel'];
			if($model->save()){
				$fileAvatar = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS .$_POST['AdminNewsModel']['source_path'];
				if(file_exists($fileAvatar)){
				    AvatarHelper::processAvatar($model, $fileAvatar, 'news', 16, 9);
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		
		$uploadModel = new XUploadForm();
		$this->render('update',array(
			'model'=>$model,
			'uploadModel'=>$uploadModel,
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

		if(isset($_POST['AdminNewsModel']))
		{
			$model=new AdminNewsModel;
			$model->attributes=$_POST['AdminNewsModel'];
			$model->setAttributes(
				array(
					'created_by'=>$this->userId,
					'created_time'=>date("Y-m-d H:i:s") 
				)
			);
			if($model->save()){
				$fileAvatar = _APP_PATH_.DS."data".DS."tmp".DS.$_POST['AdminNewsModel']['source_path'];
				if(file_exists($fileAvatar)){
				    AvatarHelper::processAvatar($model, $fileAvatar);
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		
		$uploadModel = new XUploadForm();
		$this->render('copy',array(
			'model'=>$data,
			'uploadModel'=>$uploadModel,
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
        
        
     public function actionHot(){
		$cids = Yii::app()->request->getParam('cid');
		if(isset($_POST['all-item'])){
			 AdminNewsModel::model()->updateAll(array('featured'=>1));
		}else{
		  AdminNewsModel::model()->updateAll(array('featured'=>1),"id IN (".implode(',', $cids).")");
		}
		
		$this->redirect(array('index'));
	}
    public function actionUnhot(){
     	$cids = Yii::app()->request->getParam('cid');
        if(isset($_POST['all-item'])){
             AdminNewsModel::model()->updateAll(array('featured'=>0));
        }else{
          AdminNewsModel::model()->updateAll(array('featured'=>0),"id IN (".implode(',', $cids).")");
        }
        $this->redirect(array('index'));
    }    
        
        
    /**
    * Delete all record Action.
    * @param string the action
    */
    public function actionDeleteAll() {           
    	if(isset($_POST['all-item'])){
        	AdminNewsModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			AdminNewsModel::model()->deleteAll($c);
		}
        $this->redirect(array('index'));
	}
	
	public function actionReorder()
	{
        $data = Yii::app()->request->getParam('sorder');
        $data = ArrayHelper::reorder($data);
        $maxArray = max($data);
        
	    $c = new CDbCriteria();
	    $c->order = "sorder ASC, id DESC";
		$newsModel= AdminNewsModel::model()->findAll($c);
		
		$i=1;	
		foreach ($newsModel as $news){
			if(!isset($data[$news->id])){
				$order = $maxArray + $i;
			}else{
				$order = $data[$news->id];
			}
			$newsObj = AdminNewsModel::model()->findByPk($news->id);
		 	$newsObj->sorder = $order;
            $newsObj->save();
            $i++;
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminNewsModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-news-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
