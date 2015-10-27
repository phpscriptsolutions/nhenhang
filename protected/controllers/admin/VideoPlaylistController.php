<?php

Yii::import("ext.xupload.models.XUploadForm");

class VideoPlaylistController extends Controller {

    public $type = AdminVideoPlaylistModel::ALL;
    public $videoPlaylistArtist = array();

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', 'Quản lý video playlist');
        $type = Yii::app()->request->getParam('AdminVideoPlaylistModel');
        $this->type = isset($type['status']) ? $type['status'] : AdminVideoPlaylistModel::ALL;
    }

    public function actions() {
        return array(
            'upload' => array(
                'class' => 'ext.xupload.actions.XUploadAction',
                'subfolderVar' => 'parent_id',
                'path' => _APP_PATH_ . DS . "data",
                'alowType' => 'image/jpeg,image/png,image/gif,image/x-png,image/pjpeg'
            ),
        );
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new AdminVideoPlaylistModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AdminVideoPlaylistModel']))
            $model->attributes = $_GET['AdminVideoPlaylistModel'];
        $model->setAttribute("status", $this->type);
        $description='';
        if (isset($_GET['description']) && $_GET['description']>0) {
        	$description = $_GET['description'];
        }
        
        $categoryList = AdminGenreModel::model()->gettreelist(2);
        $cpList = AdminCpModel::model()->findAll();
        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize,
            'categoryList' => $categoryList,
            'cpList' => $cpList,
        	'description'=>$description
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id, $return='view') {        
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'return' => $return
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new AdminVideoPlaylistModel();
        if (isset($_POST['AdminVideoPlaylistModel'])) {
            $cpId = 0;            
            $model->attributes = $_POST['AdminVideoPlaylistModel'];
            $model->setAttributes(
                                    array(
                                        'status'=>1,
                                        'created_time' => date("Y-m-d H:i:s"),
                                        'updated_time' => date("Y-m-d H:i:s"),
                                        'price' => Yii::app()->params['price']['videoPlaylistListen'],
                                        'cp_id' => $cpId,
                                ));

            if ($model->save()) {
                $fileAvatar = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS . $_POST['AdminVideoPlaylistModel']['source_path'];
                if (file_exists($fileAvatar)) {
                    AvatarHelper::processAvatar($model, $fileAvatar);
                }

                AdminVideoPlaylistArtistModel::model()->updateArtist($model->id, $_POST['AdminVideoPlaylistModel_artist_id_list']);
                $model->artist_name = AdminVideoPlaylistArtistModel::model()->getArtistByVideoPlaylist($model->id, 'name');
                $model->save();

                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $categoryList = AdminGenreModel::model()->gettreelist(2);
        $uploadModel = new XUploadForm();
        $cpList = AdminCpModel::model()->findAll();
        $this->render('create', array(
            'model' => $model,
            'categoryList' => $categoryList,
            'uploadModel' => $uploadModel,
            'cpList' => $cpList,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if ($model->status == AdminVideoPlaylistModel::DELETED) {
            $this->redirect(Yii::app()->createUrl("videoPlaylist/view", array('id' => $id, 'return' => 'update')));
        }
        
        if (isset($_POST['AdminVideoPlaylistModel'])) {
            $model->attributes = $_POST['AdminVideoPlaylistModel'];
            
            $model->setAttributes(array(
                'updated_time' => date("Y-m-d H:i:s"),
            ));
            
            AdminVideoPlaylistArtistModel::model()->updateArtist($model->id, $_POST['AdminVideoPlaylistModel_artist_id_list']);
            $model->artist_name = AdminVideoPlaylistArtistModel::model()->getArtistByVideoPlaylist($model->id, 'name');
            if ($model->save()) {
                $fileAvatar = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS . $_POST['AdminVideoPlaylistModel']['source_path'];
                if (file_exists($fileAvatar)) {
                    AvatarHelper::processAvatar($model, $fileAvatar);
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $categoryList = AdminGenreModel::model()->gettreelist(2);
        $uploadModel = new XUploadForm();
        $cpList = AdminCpModel::model()->findAll();
        $this->videoPlaylistArtist = AdminVideoPlaylistArtistModel::model()->getArtistByVideoPlaylist($model->id);
        $this->render('update', array(
            'model' => $model,
            'categoryList' => $categoryList,
            'uploadModel' => $uploadModel,
            'cpList' => $cpList,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if($this->userId > 0){
            //$this->loadModel($id)->delete();
            AdminVideoPlaylistModel::model()->delete(array($id));
            
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * Delete all record Action.
     * @param string the action
     */
    public function actionDeleteAll() {
        $item = array();
        if(isset($_POST['cid']))
            $item = $_POST['cid'];
        AdminVideoPlaylistModel::model()->delete($item);
        $this->redirect(array('index'));
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

    public function actionReorder() {
        $data = Yii::app()->request->getParam('sorder');
        $data = ArrayHelper::reorder($data);
        $maxArray = max($data);

        $c = new CDbCriteria();
        $c->condition = "status=:STATUS";
        $c->params = array(":STATUS" => AdminVideoPlaylistModel::ACTIVE);
        $c->order = "sorder ASC";
        $c->limit = 100;
        $videoPlaylistObj = AdminVideoPlaylistModel::model()->findAll($c);

        $i = 1;
        foreach ($videoPlaylistObj as $videoPlaylist) {
            if (!isset($data[$videoPlaylist->id])) {
                $order = $maxArray + $i;
            } else {
                $order = $data[$videoPlaylist->id];
            }
            $videoPlaylistModel = AdminVideoPlaylistModel::model()->findByPk($videoPlaylist->id);
            $videoPlaylistModel->sorder = $order;
            if (!$videoPlaylistModel->save()) {
                $error = $videoPlaylistModel->getErrors();
                echo $videoPlaylist->id . "\n";
                echo "<pre>";
                print_r($error);
                echo "</pre>\n";
                continue;
            }
            $i++;
        }
    }

    public function actionReorderItems() {
        $videoPlaylistId = Yii::app()->request->getParam('id');
        $data = Yii::app()->request->getParam('sorder');

        $data = ArrayHelper::reorder($data);
        $maxArray = max($data);

        $c = new CDbCriteria();
        $c->condition = "video_playlist_id=:AID";
        $c->params = array(':AID' => $videoPlaylistId);
        $c->order = "sorder ASC, id DESC";
        $videoPlaylistVideo = AdminVideoPlaylistVideoModel::model()->findAll($c);

        $i = 1;
        foreach ($videoPlaylistVideo as $alVideo) {
            if (!isset($data[$alVideo->id])) {
                $order = $maxArray + $i;
            } else {
                $order = $data[$alVideo->id];
            }
            $videoPlaylistVideoObj = AdminVideoPlaylistVideoModel::model()->findByPk($alVideo->id);
            $videoPlaylistVideoObj->sorder = $order;
            $videoPlaylistVideoObj->save();
            $i++;
        }
    }

    public function actionVideolist($id) {
        $model = $this->loadModel($id);
        $videoList = new AdminVideoPlaylistVideoModel("search");
        $videoList->unsetAttributes();
        $videoList->setAttributes(array('video_playlist_id' => $id));
        Yii::app()->user->setState('pageSize', 1000000);

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_videoInList', array(
                'model' => $model,
                'videoList' => $videoList,
                'id' => $id
            ));
        } else {
            $this->render('videolist', array(
                'model' => $model,
                'videoList' => $videoList,
                'id' => $id
            ));
        }
    }

    public function actionPublishItems() {
        $items = yii::app()->request->getparam('cid');
        $items = implode(",", $items);
        $attributes['status'] = 1;
        $condition = "id IN ($items)";
        AdminVideoPlaylistVideoModel::model()->updateAll($attributes, $condition);
    }

    public function actionUnpublishItems() {
        $items = yii::app()->request->getparam('cid');
        $items = implode(",", $items);
        $attributes['status'] = 0;
        $condition = "id IN ($items)";
        AdminVideoPlaylistVideoModel::model()->updateAll($attributes, $condition);
    }

    public function actionAddItems() {
        $videoPlaylistId = Yii::app()->request->getParam('video_playlist_id', null);
        $flag = true;
        if (Yii::app()->getRequest()->ispostRequest) {
            $flag = false;
            $videoInVideoPlaylist = AdminVideoPlaylistVideoModel::model()->findAll("video_playlist_id=:VIDEOPLAYLISTID", array(':VIDEOPLAYLISTID' => $videoPlaylistId));
            $videoData = CHtml::listData($videoInVideoPlaylist, 'id', 'video_id');
            $contentId = Yii::app()->request->getParam('cid');
            for ($i = 0; $i < count($contentId); $i++) {
                if (!in_array($contentId[$i], $videoData)) {
                    $model = new AdminVideoPlaylistVideoModel();
                    $model->video_id = $contentId[$i];
                    $model->video_playlist_id = $videoPlaylistId;
                    $model->save();
                }
            }
            AdminVideoPlaylistModel::model()->updateTotalVideo($videoPlaylistId);
        }
        if ($flag) {
            Yii::app()->user->setState('pageSize', 20);
            $videoModel = new AdminVideoModel('search');
            $videoModel->unsetAttributes();

            if (isset($_GET['AdminVideoModel'])) {
                $videoModel->attributes = $_GET['AdminVideoModel'];
            }

            $videoModel->setAttribute("status", 1);                    
            $categoryList = AdminGenreModel::model()->gettreelist(2);
            $cpList = AdminCpModel::model()->findAll();
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_addItems', array(
                'videoModel' => $videoModel,
                'video_playlist_id' => $videoPlaylistId,
                'categoryList' => $categoryList,
                'cpList' => $cpList,
                    ), false, true);
        }
    }

    public function actionDeleteItems() {
        if (Yii::app()->request->isPostRequest) {
            $items = yii::app()->request->getparam('cid');
            //$videoPlaylistVideoId =  $items[0];
            $items = implode(",", $items);
            $condition = "id IN ($items)";
            $videoPlaylistVideoModel = AdminVideoPlaylistVideoModel::model()->find($condition);
            $videoPlaylistId = $videoPlaylistVideoModel->video_playlist_id;

            AdminVideoPlaylistVideoModel::model()->deleteAll($condition);
            AdminVideoPlaylistModel::model()->updateTotalVideo($videoPlaylistId);
        }else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionFavList($id) {
        $favlist = new AdminFavouriteVideoPlaylistModel("search");
        $favlist->unsetAttributes();
        $favlist->setAttribute('playlist_id', $id);
        $this->renderPartial('_favList', array('favlist' => $favlist, 'id' => $id));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = AdminVideoPlaylistModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-video-playlist-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    //set độc quyền
    public function actionexclusive() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            VideoPlaylistModel::model()->updateAll(array('exclusive' => 1));
        } else {
            VideoPlaylistModel::model()->updateAll(array('exclusive' => 1), "id IN (" . implode(',', $cids) . ")");
        }

        $this->redirect(array('index'));
    }
    
    //unset độc quyền
    public function actionUnexclusive() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            VideoPlaylistModel::model()->updateAll(array('exclusive' => 0));
        } else {
            VideoPlaylistModel::model()->updateAll(array('exclusive' => 0), "id IN (" . implode(',', $cids) . ")");
        }
        $this->redirect(array('index'));
    }

    public function actionNew() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            VideoPlaylistModel::model()->updateAll(array('new_release' => 1));
        } else {
            VideoPlaylistModel::model()->updateAll(array('new_release' => 1), "id IN (" . implode(',', $cids) . ")");
        }

        $this->redirect(array('index'));
    }

    public function actionUnnew() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            VideoPlaylistModel::model()->updateAll(array('new_release' => 0));
        } else {
            VideoPlaylistModel::model()->updateAll(array('new_release' => 0), "id IN (" . implode(',', $cids) . ")");
        }
        $this->redirect(array('index'));
    }
    
    public function actionAdd2Collection() {
        $object = Yii::app()->request->getParam('object', "");
        $collect_id = Yii::app()->request->getParam('collect_id', "");

        $flag = true;
        if (Yii::app()->getRequest()->ispostRequest) {
            if ($object == "collection") {
                $flag = false;
                $videoPlaylistList = Yii::app()->request->getParam('cid');
                AdminCollectionItemModel::model()->addList($this->userId, $collect_id, $videoPlaylistList, 'video_playlist');
            } 
        }
        if ($flag){
            Yii::app()->user->setState('pageSize', 20);
            $videoPlaylistModel = new AdminVideoPlaylistModel('search');
            $videoPlaylistModel->unsetAttributes();
            if (isset($_GET['AdminVideoPlaylistModel'])) {
                $videoPlaylistModel->attributes = $_GET['AdminVideoPlaylistModel'];
            }
            //$videoPlaylistModel->setAttribute("sync_status", 1);

            //$videoPlaylistModel->setAttribute('status', AdminVideoPlaylistModel::ACTIVE);
            $categoryList = AdminGenreModel::model()->gettreelist(2);

            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_add2Collection', array(
                'videoPlaylistModel' => $videoPlaylistModel,
                'categoryList' => $categoryList,
                'object' => $object,
                'collect_id' => $collect_id
                    ), false, true);
        }
    }
}