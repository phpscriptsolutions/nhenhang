<?php

class CollectionController extends Controller
{
	
    public function init()
	{
		
            parent::init();
            $this->pageTitle = Yii::t('admin', "Quản lý Radio Collection ") ;
	}
	public function actionReorder() {
		$data = Yii::app()->request->getParam('sorder');
		$channel_id = Yii::app()->request->getParam('channel_id',0);
		$c = new CDbCriteria();
		$c->condition = "radio_id=$channel_id";
		$songF = AdminRadioCollectionModel::model()->findAll($c);
	
		foreach ($songF as $songF) {
			if (array_key_exists($songF->id, $data)) {
				$order = $data[$songF->id];
				$songObj = AdminRadioCollectionModel::model()->findByPk($songF->id);
				$songObj->ordering = $order;
				$songObj->save();
			}
		}
		echo 'success';
	}
	public function actionAddItems() {
		$channelId = Yii::app()->request->getParam('channel_id', 0);
		$type = AdminRadioModel::model()->findByPk($channelId)->type;
		$flag = true;
		if (Yii::app()->getRequest()->ispostRequest) {
			$flag = false;
			$collInRadio = AdminRadioCollectionModel::model()->findAll("radio_id=:radio_id", array(':radio_id' => $channelId));
			$collData = CHtml::listData($collInRadio, 'id', 'collection_id');
			$contentId = Yii::app()->request->getParam('cid');
			for ($i = 0; $i < count($contentId); $i++) {
				if (!in_array($contentId[$i], $collData)) {
					$model = new AdminRadioCollectionModel();
					$model->collection_id = $contentId[$i];
					$model->radio_id = $channelId;
					$model->created_time = date('Y-m-d H:i:s');
					$model->save();
				}
			}
			//AdminAlbumModel::model()->updateTotalSong($albumId);
		}
		if ($flag) {
			Yii::app()->user->setState('pageSize', 20);
			if($type=='artist'){
				//artist
				$CollModel = new AdminArtistModel('search');
				$CollModel->unsetAttributes();
				if (isset($_GET['AdminArtistModel'])) {
					$CollModel->attributes = $_GET['AdminArtistModel'];
				}
				$CollModel->setAttribute("status", 1);
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				$this->renderPartial('_addItemsArtist', array(
						'CollModel' => $CollModel,
						'channelId' => $channelId,
				), false, true);
			}elseif($type=='genre'){
				//genre
				$CollModel = new AdminGenreModel('search');
				$CollModel->unsetAttributes();
				if (isset($_GET['AdminSongModel'])) {
					$CollModel->attributes = $_GET['AdminSongModel'];
				}
				$CollModel->setAttribute("status", 1);
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				$this->renderPartial('_addItemsArtist', array(
						'CollModel' => $CollModel,
						'channelId' => $channelId,
				), false, true);
			}elseif($type=='playlist'){
				$CollModel = new AdminPlaylistModel('search');
				$CollModel->unsetAttributes();
				if (isset($_GET['AdminPlaylistModel'])) {
					$CollModel->attributes = $_GET['AdminPlaylistModel'];
				}
				$CollModel->setAttribute("status", 1);
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				$this->renderPartial('_addItemsPlaylist', array(
						'CollModel' => $CollModel,
						'channelId' => $channelId,
				), false, true);
			}elseif($type=='album'){
				$CollModel = new AdminAlbumModel('search');
				$CollModel->unsetAttributes();
				if (isset($_GET['AdminAlbumModel'])) {
					$CollModel->attributes = $_GET['AdminAlbumModel'];
				}
				$CollModel->setAttribute("status", 1);
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				$this->renderPartial('_addItemsAlbum', array(
						'CollModel' => $CollModel,
						'channelId' => $channelId,
				), false, true);
			}else{
				//channel
				$CollModel = new AdminCollectionModel('newsearch');
				$CollModel->unsetAttributes();
				if (isset($_GET['AdminSongModel'])) {
					$CollModel->attributes = $_GET['AdminSongModel'];
				}
				$CollModel->setAttribute("status", 1);
				$CollModel->_onlySong = true;
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				$this->renderPartial('_addItems', array(
						'CollModel' => $CollModel,
						'channelId' => $channelId,
				), false, true);
			}
			
		}
	}
	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);
		$channelId = Yii::app()->request->getParam('id',0);
		$type = AdminRadioModel::model()->findByPk($channelId)->type;
		$model=new AdminRadioCollectionModel('search');
		$model->unsetAttributes();  // clear any default values
		$model->radio_id=$channelId;
		if(isset($_GET['AdminRadioCollectionModel']))
			$model->attributes=$_GET['AdminRadioCollectionModel'];

		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize,
			'channelId'=>$channelId,
			'type'=>$type
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
		$model=new AdminRadioCollectionModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminRadioCollectionModel']))
		{
			$model->attributes=$_POST['AdminRadioCollectionModel'];
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

		if(isset($_POST['AdminRadioCollectionModel']))
		{
			$model->attributes=$_POST['AdminRadioCollectionModel'];
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

		if(isset($_POST['AdminRadioCollectionModel']))
		{
                        $model=new AdminRadioCollectionModel;
			$model->attributes=$_POST['AdminRadioCollectionModel'];
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
        	AdminRadioCollectionModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			AdminRadioCollectionModel::model()->deleteAll($c);
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
		$model=AdminRadioCollectionModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='radio-collection-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
