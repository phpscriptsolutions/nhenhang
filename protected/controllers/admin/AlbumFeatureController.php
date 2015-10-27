<?php

class AlbumFeatureController extends Controller
{
	
    public function init()
	{
            parent::init();
            $this->pageTitle = "Manage  Feature Album";
	}


	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
        $pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminFeatureAlbumModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminFeatureAlbumModel']))
			$model->attributes=$_GET['AdminFeatureAlbumModel'];
		$this->render('index',array(
			'model'=>$model,
			'pageSize'=>$pageSize,
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
        } else {
            $this->redirect(array('index'));
        }
    }

    /**
    * Delete all record Action.
    * @param string the action
    */
    public function actionDeleteAll() {           
    	if(isset($_POST['all-item'])){
        	AdminFeatureAlbumModel::model()->deleteAll();
        }else{

            $item = $_POST['cid'];
            $c =  new CDbCriteria;
            $c->condition = ('id in ('.implode($item, ",").')');
            $c->params = null;
            AdminFeatureAlbumModel::model()->deleteAll($c);
		}
        $this->redirect(array('index'));
	}
	
	public function actionAddAlbum()
	{
		$flag=true;
        $object = Yii::app()->request->getParam('object',"");
        $collect_id = Yii::app()->request->getParam('collect_id',"");
        $albumList = Yii::app()->request->getParam('cid');
		if(Yii::app()->getRequest()->ispostRequest){
            if($object == "collection"){
				$flag = false;
				$albumList = Yii::app()->request->getParam('cid');
				AdminCollectionItemModel::model()->addList($this->userId, $collect_id, $albumList, 'album');
			}
			 if($object=='mgChannel'){
			 	$flag = false;
				$albumList = Yii::app()->request->getParam('cid');
                
                $albInChannel = AdminMgChannelSongModel::model()->findAllByAttributes(array('channel_id'=>$collect_id));
                $arr = array();
                foreach ($albInChannel as $cl){
                    $arr[] = $cl['song_id'];
                }
                
                
                $c = new CDbCriteria();
                $c->addInCondition("id", $albumList);
                if(count($arr)>0)
                    $c->addNotInCondition("id", $arr);
                $albAdding = AdminAlbumModel::model()->findAll($c);
                foreach ($albAdding as $alb) {
                    $md = new AdminMgChannelSongModel();
                    $md->channel_id = $collect_id;
                    $md->song_id = $alb->id;
                    $md->sorder = 0;
                    $md->save();
                }
			}
            else{
                $albumList = Yii::app()->request->getParam('cid');		
                $albumFeature = AdminFeatureAlbumModel::model()->findAll();
                $albumFeature =  CHtml::listData($albumFeature,'album_id','album_id');
                for($i=0;$i<count($albumList);$i++){
                    if(!in_array($albumList[$i],$albumFeature)){
                        $albumFeatureObj = new AdminFeatureAlbumModel();
                        $albumFeatureObj->album_id = $albumList[$i];
                        $albumFeatureObj->created_by = $this->userId;
                        $albumFeatureObj->created_time = date("Y-m-d H:i:s");
                        $albumFeatureObj->save();
                    }
                }
            }
		}
		if($flag){
			Yii::app()->user->setState('pageSize',20);
			$albumModel = new AdminAlbumModel();
			$albumModel->unsetAttributes();
			if(isset($_GET['AdminAlbumModel']))
				$albumModel->attributes=$_GET['AdminAlbumModel'];
			$albumModel->setAttributes(array('status'=>AdminAlbumModel::ACTIVE));

			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$categoryList = AdminGenreModel::model()->gettreelist(2);
			$this->renderPartial('addAlbum',array(
	                            'albumModel'=>$albumModel,
								'categoryList'=>$categoryList,
                                'object' => $object,
                                'collect_id' => $collect_id,
								'$channel_Id'=>$$channel_Id,
			),false,true);
		}		
	}
	
	public function actionPublish(){
		$cids = Yii::app()->request->getParam('cid');
		if(isset($_POST['all-item'])){
			 AdminFeatureAlbumModel::model()->updateAll(array('status'=>0));
		}else{
		  AdminFeatureAlbumModel::model()->updateAll(array('status'=>0),"id IN (".implode(',', $cids).")");
		}
		
		$this->redirect(array('index'));
	}

	public function actionUnpublish(){
     	$cids = Yii::app()->request->getParam('cid');
        if(isset($_POST['all-item'])){
             AdminFeatureAlbumModel::model()->updateAll(array('status'=>1));
        }else{
          AdminFeatureAlbumModel::model()->updateAll(array('status'=>1),"id IN (".implode(',', $cids).")");
        }
        $this->redirect(array('index'));
    }
    
    public function actionHot(){
		$cids = Yii::app()->request->getParam('cid');
		if(isset($_POST['all-item'])){
			 AdminFeatureAlbumModel::model()->updateAll(array('featured'=>1));
		}else{
		  AdminFeatureAlbumModel::model()->updateAll(array('featured'=>1),"id IN (".implode(',', $cids).")");
		}
		
		$this->redirect(array('index'));
	}
    public function actionUnhot(){
     	$cids = Yii::app()->request->getParam('cid');
        if(isset($_POST['all-item'])){
             AdminFeatureAlbumModel::model()->updateAll(array('featured'=>0));
        }else{
          AdminFeatureAlbumModel::model()->updateAll(array('featured'=>0),"id IN (".implode(',', $cids).")");
        }
        $this->redirect(array('index'));
    }
    
    
    public function actionReorder(){
        $data = Yii::app()->request->getParam('sorder');
        
        $data = ArrayHelper::reorder($data);
        $maxArray = max($data);
        
	    $c = new CDbCriteria();
	    $c->order = "sorder ASC";
		$albumFeatureObj = AdminFeatureAlbumModel::model()->findAll($c);
		
		$i=1;	
		foreach ($albumFeatureObj as $album){
			if(!isset($data[$album->id])){
				$order = $maxArray + $i;
			}else{
				$order = $data[$album->id];
			}
			$albumFeature = AdminFeatureAlbumModel::model()->findByPk($album->id);
		 	$albumFeature->sorder = $order;
            $albumFeature->save();
            $i++;
		}
		Yii::app()->user->setFlash('FeatureAlbum',"Cập nhật thành công");
    }
    
    
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminFeatureAlbumModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-feature-album-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
