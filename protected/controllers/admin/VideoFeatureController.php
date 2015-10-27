<?php

class VideoFeatureController extends Controller
{

    public function init()
	{
		parent::init();
        $this->pageTitle = "Manage  Feature Video";
		$this->slidebar=array(
					        array('label'=>'Tất cả', 'url'=>array('video/index')),
					        array('label'=>'Chưa convert', 'url'=>array('video/index',"AdminSongModel[status]"=>0)),
					        array('label'=>'Convert lỗi', 'url'=>array('video/index',"AdminSongModel[status]"=>3)),
					        array('label'=>'Chờ duyệt', 'url'=>array('video/index',"AdminSongModel[status]"=>1)),
					        array('label'=>'Đã duyệt', 'url'=>array('video/index',"AdminSongModel[status]"=>2)),
					        array('label'=>'Chọn lọc', 'url'=>array('/videoFeature'),"active"=>"active"),
					        array('label'=>'Đã xóa', 'url'=>array('video/index',"AdminSongModel[status]"=>5)),
        				);
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminFeatureVideoModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminFeatureVideoModel']))
			$model->attributes=$_GET['AdminFeatureVideoModel'];

		$categoryList = AdminGenreModel::model()->gettreelist(2);
		$cpList = AdminCpModel::model()->findAll();
		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize,
			'categoryList'=>$categoryList,
			'cpList'=>$cpList,
		));
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AdminFeatureVideoModel;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AdminFeatureVideoModel']))
		{
			$model->attributes=$_POST['AdminFeatureVideoModel'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
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
        	AdminFeatureVideoModel::model()->deleteAll();
        }else{
        	$item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
			AdminFeatureVideoModel::model()->deleteAll($c);
		}
        $this->redirect(array('index'));
	}

    public function actionReorder(){
        $data = Yii::app()->request->getParam('sorder');
        $data = ArrayHelper::reorder($data);
        $maxArray = max($data);

        $c = new CDbCriteria();
	    $c->order = "sorder ASC, id DESC";
		$videoF= AdminFeatureVideoModel::model()->findAll($c);

    	$i=1;
		foreach ($videoF as $videoF){
			if(!isset($data[$videoF->id])){
				$order = $maxArray + $i;
			}else{
				$order = $data[$videoF->id];
			}
			$videoObj = AdminFeatureVideoModel::model()->findByPk($videoF->id);
		 	$videoObj->sorder = $order;
            $videoObj->save();
            $i++;
		}
    }

	public function actionPublish(){
		$cids = Yii::app()->request->getParam('cid');
		if(isset($_POST['all-item'])){
			AdminFeatureVideoModel::model()->updateAll(array('status'=>0));
		}else{
		  	AdminFeatureVideoModel::model()->updateAll(array('status'=>0),"id IN (".implode(',', $cids).")");
		}

		$this->redirect(array('index'));
	}
    public function actionUnpublish(){
     	$cids = Yii::app()->request->getParam('cid');
        if(isset($_POST['all-item'])){
             AdminFeatureVideoModel::model()->updateAll(array('status'=>1));
        }else{
          AdminFeatureVideoModel::model()->updateAll(array('status'=>1),"id IN (".implode(',', $cids).")");
        }
        $this->redirect(array('index'));
    }

     public function actionHot(){
		$cids = Yii::app()->request->getParam('cid');
		if(isset($_POST['all-item'])){
			 AdminFeatureVideoModel::model()->updateAll(array('featured'=>1));
		}else{
		  AdminFeatureVideoModel::model()->updateAll(array('featured'=>1),"id IN (".implode(',', $cids).")");
		}

		$this->redirect(array('index'));
	}
    public function actionUnhot(){
     	$cids = Yii::app()->request->getParam('cid');
        if(isset($_POST['all-item'])){
             AdminFeatureVideoModel::model()->updateAll(array('featured'=>0));
        }else{
          AdminFeatureVideoModel::model()->updateAll(array('featured'=>0),"id IN (".implode(',', $cids).")");
        }
        $this->redirect(array('index'));
    }

	public function actionAddVideo()
	{
        $object = Yii::app()->request->getParam('object',"");
        $collect_id = Yii::app()->request->getParam('collect_id',"");

		$flag=true;
		if(Yii::app()->getRequest()->ispostRequest){
            if($object == "collection"){
				$flag = false;
				$videoList = Yii::app()->request->getParam('cid');
				AdminCollectionItemModel::model()->addList($this->userId, $collect_id, $videoList,'video');
			}
            else{
                $videoList = Yii::app()->request->getParam('cid');
                AdminFeatureVideoModel::model()->addList($this->userId,$videoList);
            }
		}
		if($flag){
			Yii::app()->user->setState('pageSize',20);
			$videoModel = new AdminVideoModel('search');
			$videoModel->unsetAttributes();
			if(isset($_GET['AdminVideoModel'])){
				$videoModel->attributes=$_GET['AdminVideoModel'];
				if(isset($_GET['AdminVideoModel']['genre_id'])){
					$videoModel->genre_id = $_GET['AdminVideoModel']['genre_id'];
				}
			}
			//$videoModel->setAttribute("sync_status", 1);

			$videoModel->setAttribute('status',AdminVideoModel::ACTIVE);
			$categoryList = AdminGenreModel::model()->gettreelist(2);

			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_addVideo',array(
	                            'videoModel'=>$videoModel,
	                            'categoryList'=>$categoryList,
                                'object' => $object,
                                'collect_id' => $collect_id
			),false,true);
		}
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminFeatureVideoModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-feature-video-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
