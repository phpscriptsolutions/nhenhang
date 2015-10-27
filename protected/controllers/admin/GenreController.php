<?php

class GenreController extends Controller {
	public $genreCmcIds = "";
	
    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', 'Quản lý thể loại');
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', 9999);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new AdminGenreModel('search');
        $model->unsetAttributes();
        /*
          $totalRow = $model->search()->getTotalItemCount();
          $page = new CPagination($totalRow);
          $page->pageSize = $pageSize;
         */

        $treeData = AdminGenreModel::model()->gettreelist(1,false,0,1);
//        $treeData = AdminGenreModel::model()->gettreelist(1);

        if (isset($_GET['AdminGenreModel']))
            $model->attributes = $_GET['AdminGenreModel'];

        $categoryList = AdminGenreModel::model()->gettreelist(2);
        $this->render('index', array(
            'model' => $model,
            'treeData' => $treeData,
            'categoryList' => $categoryList,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new AdminGenreModel;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['AdminGenreModel'])) {
            $model->attributes = $_POST['AdminGenreModel'];
            $model->setAttribute('created_by', $this->userId);
            if ($model->save()){
            	if(isset($_POST['METADATA'])){
            		$genreMetaData = new AdminGenreMetadataModel();
            		$genreMetaData->attributes = $_POST['METADATA'];
            		$genreMetaData->genre_id = $model->id;
            		$genreMetaData->save();
            	}
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $categoryList = AdminGenreModel::model()->gettreelist(2);
        $this->render('create', array(
            'model' => $model,
            'categoryList' => $categoryList,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        //$genreMetaData = AdminGenreMetadataModel::model()->findByAttributes(array("genre_id"=>$id));
        $crit = new CDbCriteria();
        $crit->condition = 'genre_id=:genre_id';
        $crit->params = array(':genre_id'=>$id);
        $genreMetaData = GenreMetadataModel::model()->findAll($crit);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['AdminGenreModel'])) {
            $model->attributes = $_POST['AdminGenreModel'];
            if ($_POST['AdminGenreModel']['parent_id'] == $id) {
                $model->setAttribute('parent_id', 0);
                echo "<pre>";
                print_r($model->attributes);
                exit();
            }
            if ($model->save()){
            	if(isset($_POST['genreMeta'])){
                    GenreMetadataModel::model()->updateData($model->id,$_POST['genreMeta']);
            		///echo '<pre>';print_r($_POST['METADATA']);exit;
            		/*if(empty($genreMetaData)){
            			$genreMetaData = new AdminGenreMetadataModel();
            		}
            		$genreMetaData->attributes = $_POST['METADATA'];
            		$genreMetaData->genre_id = $id;
            		$genreMetaData->save();*/
            	}
            	
            	$cmcIds = explode(",", $_POST["cmc_ids"]);
            	$this->setGenreMap($model->id,$cmcIds);
            	
            	$this->redirect(array('view', 'id' => $model->id));
            }
                
        }
		
        $categoryList = AdminGenreModel::model()->gettreelist(2);
        $this->genreCmcIds = $this->getGenreMap($id);
        
        $this->render('update', array(
            'model' => $model,
            'categoryList' => $categoryList,
        	'genreMetaData'=>$genreMetaData
        ));
    }

    /**
     * Copy record
     * If copy is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be copy
     */
    public function actionCopy($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['AdminGenreModel'])) {
            $model = new AdminGenreModel;
            $model->attributes = $_POST['AdminGenreModel'];
            $model->setAttribute('created_by', $this->userId);
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $categoryList = AdminGenreModel::model()->gettreelist(2);
        $this->render('copy', array(
            'model' => $model,
            'categoryList' => $categoryList,
        ));
    }

    public function actionReorder() {
        $data = Yii::app()->request->getParam('sorder');

        $data = ArrayHelper::reorder($data);
        $maxArray = max($data);

        foreach ($data as $k => $v) {
            $genreModel = AdminGenreModel::model()->findByPk($k);
            $genreModel->sorder = $v;
            $genreModel->save();

            // Order for child
            $c = new CDbCriteria();
            $c->condition = "parent_id = :PID";
            $c->params = array(":PID" => $genreModel->id);
            $c->order = "sorder ASC, id DESC";

            $childList = AdminGenreModel::model()->findAll($c);
            $childList = CHtml::listData($childList, 'id', 'sorder');
            $childList = ArrayHelper::reorder($childList);
            foreach ($childList as $childKey => $childVal) {
                $genreModel = AdminGenreModel::model()->findByPk($childKey);
                $genreModel->sorder = $childVal;
                $genreModel->save();
            }
        }
    }

    public function actionUplever($id) {
        $genre = AdminGenreModel::model()->findByPk($id);
        if (0 !== $genre->sorder) {
            $orgOrder = $genre->sorder;
            $c = new CDbCriteria();
            $c->condition = "parent_id = :PID";
            $c->params = array(":PID" => $genre->parent_id);
            $c->order = "sorder ASC, id DESC";
            $genreList = AdminGenreModel::model()->findAll($c);
            $genreList = CHtml::listData($genreList, 'id', 'sorder');
            $listKey = array_keys($genreList);
            for ($i = 0; $i < count($listKey); $i++) {
                if ($listKey[$i] == $genre->id) {
                    $before = isset($listKey[$i - 1]) ? $listKey[$i - 1] : -1;
                    break;
                }
            }
            //swap with before element
            if (isset($genreList[$before])) {
                $genre->sorder = $genreList[$before];
                $genre->save();
                $beforeElement = AdminGenreModel::model()->findByPk($before);
                $beforeElement->sorder = $orgOrder;
                $beforeElement->save();
            }
        }
        $this->redirect(array('index'));
    }

    public function actionDownlever($id) {
        $genre = AdminGenreModel::model()->findByPk($id);
        if (0 !== $genre->sorder) {
            $orgOrder = $genre->sorder;
            $c = new CDbCriteria();
            $c->condition = "parent_id = :PID";
            $c->params = array(":PID" => $genre->parent_id);
            $c->order = "sorder ASC, id DESC";
            $genreList = AdminGenreModel::model()->findAll($c);
            $genreList = CHtml::listData($genreList, 'id', 'sorder');
            $listKey = array_keys($genreList);
            for ($i = 0; $i < count($listKey); $i++) {
                if ($listKey[$i] == $genre->id) {
                    $after = isset($listKey[$i + 1]) ? $listKey[$i + 1] : -1;
                    break;
                }
            }
            //swap with after element
            if (isset($genreList[$after])) {
                $genre->sorder = $genreList[$after];
                $genre->save();
                $afterElement = AdminGenreModel::model()->findByPk($after);
                $afterElement->sorder = $orgOrder;
                $afterElement->save();
            }
        }
        $this->redirect(array('index'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $child = AdminGenreModel::model()->findAll("parent_id=:PID", array(":PID" => $id));
            $song = AdminSongGenreModel::model()->findAll("genre_id=:CID", array(":CID" => $id));
            if (empty($child) && empty($song)) {
                $this->loadModel($id)->delete();
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * bulk Action.
     * @param string the action
     */
    public function actionBulk() {
        $act = Yii::app()->request->getParam('bulk_action', null);
        if (isset($act) && $act != "") {
            $this->forward($this->getId() . "/" . $act);
        } else {
            $this->redirect(array('index'));
        }
    }

    /**
     * Delete all record Action.
     * @param string the action
     */
    public function actionDeleteAll() {
        if (isset($_POST['all-item'])) {
            AdminGenreModel::model()->deleteAll();
        } else {
            $item = $_POST['cid'];
            $c = new CDbCriteria;
            $c->condition = ('id in (' . implode($item, ",") . ')');
            $c->params = null;
            AdminGenreModel::model()->deleteAll($c);
        }
        $this->redirect(array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = AdminGenreModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-genre-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionHot() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AdminGenreModel::model()->updateAll(array('is_hot' => 1));
        } else {
            AdminGenreModel::model()->updateAll(array('is_hot' => 1), "id IN (" . implode(',', $cids) . ")");
        }

        $this->redirect(array('index'));
    }

    public function actionUnhot() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AdminGenreModel::model()->updateAll(array('is_hot' => 0));
        } else {
            AdminGenreModel::model()->updateAll(array('is_hot' => 0), "id IN (" . implode(',', $cids) . ")");
        }
        $this->redirect(array('index'));
    }

    public function actionNew() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AdminGenreModel::model()->updateAll(array('is_new' => 1));
        } else {
            AdminGenreModel::model()->updateAll(array('is_new' => 1), "id IN (" . implode(',', $cids) . ")");
        }

        $this->redirect(array('index'));
    }

    public function actionUnnew() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AdminGenreModel::model()->updateAll(array('is_new' => 0));
        } else {
            AdminGenreModel::model()->updateAll(array('is_new' => 0), "id IN (" . implode(',', $cids) . ")");
        }
        $this->redirect(array('index'));
    }

    public function actionCollection() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AdminGenreModel::model()->updateAll(array('is_collection' => 1));
        } else {
            AdminGenreModel::model()->updateAll(array('is_collection' => 1), "id IN (" . implode(',', $cids) . ")");
        }

        $this->redirect(array('index'));
    }

    public function actionUncollection() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AdminGenreModel::model()->updateAll(array('is_collection' => 0));
        } else {
            AdminGenreModel::model()->updateAll(array('is_collection' => 0), "id IN (" . implode(',', $cids) . ")");
        }
        $this->redirect(array('index'));
    }

    public function actionPublish() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AdminGenreModel::model()->updateAll(array('status' => 1));
        } else {
            AdminGenreModel::model()->updateAll(array('status' => 1), "id IN (" . implode(',', $cids) . ")");
        }

        $this->redirect(array('index'));
    }

    public function actionUnpublish() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AdminGenreModel::model()->updateAll(array('status' => 0));
        } else {
            AdminGenreModel::model()->updateAll(array('status' => 0), "id IN (" . implode(',', $cids) . ")");
        }
        $this->redirect(array('index'));
    }

    /*****************************************************************************************************
     * FUNCTIONS FOR GENRES WHICH HAVE is_collection = 1
     ****************************************************************************************************/

    /**
     * Hien thi danh sach bai hat cua Genre co is_collection = 1
     */
    public function actionSongList() {
        $id = yii::app()->request->getParam('id');
        $genre = AdminGenreModel::model()->findByPk($id);

        $playlistSong = new AdminSongModel('search');
        $playlistSong->unsetAttributes();

        if(intval($genre->is_collection) == 1){
            $playlistSong->setAttribute('genre_id_2',$id);
        }
        else{
            $playlistSong->setAttribute('genre_id',$id);
            $playlistSong->setAttribute('genre_id_2', -100);
        }
        //$playlistSong->setAttribute('status',2);

        $this->renderPartial('_songInList', array('listSong' => $playlistSong, 'id' => $id, 'is_collection' => $genre->is_collection));
    }
    public function actionAddItems()
	{
		$flag=true;
		$genre2Id = Yii::app()->request->getparam('genre_id');
		if(Yii::app()->getRequest()->ispostRequest){
			$flag = false;
			$songInPlaylist = AdminSongModel::model()->findAll("genre_id_2=:PID",array(':PID'=>$genre2Id));
			$songData = CHtml::listData($songInPlaylist,'id','id');
			$contentId = Yii::app()->request->getParam('cid');
			for($i=0;$i<count($contentId);$i++){
                            if(!in_array($contentId[$i],$songData) ){
                                $model= AdminSongModel::model()->findByPk($contentId[$i]);
                                $model->genre_id_2 = $genre2Id;
                                if(!$model->save()){
                                        $error = $model->geterrors();
                                        echo "<pre>";print_r($error);exit();
                                }
                            }
			}
		}
		if($flag){
			Yii::app()->user->setState('pageSize',20);
			$songModel = new AdminSongModel('search');
			$songModel->unsetAttributes();
			$songModel->setAttribute('status', AdminSongModel::ACTIVE);
			if(isset($_GET['AdminSongModel'])){
				$songModel->attributes=$_GET['AdminSongModel'];
			}

			$categoryList = AdminGenreModel::model()->gettreelist(2);
                        $cpList = AdminCpModel::model()->findAll();
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_addItems',array(
	                            'songModel'=>$songModel,
	                            'playListId'=>$genre2Id,
                                    'categoryList'=>$categoryList,
	                            'cpList'=>$cpList,
			),false,true);
		}
	}
    /**
     * Xoa 1 bai hat khoi genre
     */
    public function actionDeleteItems() {
        $items = yii::app()->request->getparam('cid');
        //$items = implode(",", $items);
        foreach ($items as $id) {
            $song = AdminSongModel::model()->findByPk($id);
            $song->genre_id_2 = 0;
            $song->save();
        }
        $this->actionSongList();
    }

    public function actionPublishItems() {
        $items = yii::app()->request->getparam('cid');
        $items = implode(",", $items);
        $attributes['status'] = 1;
        $condition = "id IN ($items)";
        AdminSongModel::model()->updateAll($attributes, $condition);
    }

    public function actionUnpublishItems() {
        $items = yii::app()->request->getparam('cid');
        $items = implode(",", $items);
        $attributes['status'] = 0;
        $condition = "id IN ($items)";
        AdminSongModel::model()->updateAll($attributes, $condition);
    }

    public function actionReorderItems() {
        $data = Yii::app()->request->getParam('sorder');
        foreach ($data as $k => $v) {
            if (isset($v) && $v != "") {
                $playlistSong = AdminSongModel::model()->findByPk($k);
                $playlistSong->sorder = $v;
                $playlistSong->save();
            }
        }
    }

    public function getGenreMap($genreID)
    {
    	$sql = "SELECT GROUP_CONCAT(cmc_id ORDER BY cmc_id ASC) AS cmc_ids
    			FROM genre_map
    			WHERE genre_id=:GID
    			";
    	$data = Yii::app()->db->createCommand($sql)
    	->bindParam(":GID", $genreID, PDO::PARAM_STR)
    	->queryRow();
    	return isset($data['cmc_ids'])?$data['cmc_ids']:"" ;
    }
    
    public function setGenreMap($genreID,$cmcIds = array())
    {
    	$sql = "DELETE  FROM genre_map WHERE genre_id=:GID";
    	$command = Yii::app()->db->createCommand($sql);
    	$command->bindParam(":GID", $genreID,PDO::PARAM_INT);
    	$command->execute();
    	 
    	foreach($cmcIds as $cmcId){
    		if($cmcId==0) continue;
    		$sql = "INSERT INTO genre_map (cmc_id,genre_id)
    				VALUES (:CMCID, :GID)";
    		$command = Yii::app()->db->createCommand($sql);
    		$command->bindParam(":GID", $genreID,PDO::PARAM_INT);
    		$command->bindParam(":CMCID", $cmcId,PDO::PARAM_INT);
    		$command->execute();
    	}
    	 
    }
    
}
