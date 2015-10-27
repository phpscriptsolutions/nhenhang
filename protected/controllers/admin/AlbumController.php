<?php

Yii::import("ext.xupload.models.XUploadForm");

class AlbumController extends Controller {

    public $type = AdminAlbumModel::ALL;
    public $albumArtist = array();
    public $tags = array();
    public $genreList = array();

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', 'Quản lý album');
        $type = Yii::app()->request->getParam('AdminAlbumModel');
        $this->type = isset($type['status']) ? $type['status'] : AdminAlbumModel::ALL;
        $genreList = AdminGenreModel::model()->findAll();
        $this->genreList = CHtml::listData($genreList, "id", "name");
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

        $model = new AdminAlbumModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AdminAlbumModel']))
            $model->attributes = $_GET['AdminAlbumModel'];
        $model->setAttribute("status", $this->type);
        $description='';
        if (isset($_GET['description']) && $_GET['description']>0) {
        	$description = $_GET['description'];
        }
        
        $categoryList = AdminGenreModel::model()->gettreelist(2,false,0,1,false,'album');
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
    public function actionView($id) {
        $metaModel = AdminAlbumMetadataModel::model()->findByAttributes(array("album_id"=>$id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'metaModel' => $metaModel
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new AdminAlbumModel;
        $albumMeta = new AdminAlbumMetadataModel();
        if (isset($_POST['AdminAlbumModel'])) {
            $cpId = $this->cpId;
            if ($cpId == 0) {
                $cpId = $_POST['AdminAlbumModel']['cp_id'];
            }
            /*
            $artistList = $_POST['AdminAlbumModel']['artist_id_list'];
            $artist_id = $artistList[0];
            $artistModel = AdminArtistModel::model()->findByPk($artist_id);
            $artist_name = empty($artistModel)?"":$artistModel->name;
			*/
            $model->attributes = $_POST['AdminAlbumModel'];
            $model->setAttributes(
                    array(
                        'created_time' => date("Y-m-d H:i:s"),
                        'updated_time' => date("Y-m-d H:i:s"),
                        'price' => Yii::app()->params['price']['albumListen'],
                        'cp_id' => $cpId,
            ));

            $albumMeta->attributes = $_POST['albumMeta'];

            if ($model->save()) {

                $fileAvatar = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS . $_POST['AdminAlbumModel']['source_path'];
                if (file_exists($fileAvatar)) {
                    AvatarHelper::processAvatar($model, $fileAvatar);
                }

                //Update Album meta
                $albumMeta->save();
                AdminAlbumArtistModel::model()->updateArtist($model->id, $_POST['AdminAlbumModel_artist_id_list']);
                $model->artist_name = AdminAlbumArtistModel::model()->getArtistByAlbum($model->id, 'name');
                $model->save(false);
                
                //Update Tag
                TagContentModel::model()->updateTag($model->id,$_POST['tags'],"album");

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
            'albumMeta' => $albumMeta
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if ($model->albumstatus->approve_status == AdminAlbumStatusModel::REJECT) {
            $this->forward("album/view", true);
        }
        //$beforeArtist = $model->artist_id;

        if (isset($_POST['AdminAlbumModel'])) {
            $model->attributes = $_POST['AdminAlbumModel'];
            if(!$model->url_key || $model->url_key =='') $model->url_key = Common::url_friendly($model->name);
            

            $model->setAttributes(array(
            						'updated_time' => date("Y-m-d H:i:s"),
				            		//'artist_id' => $artist_id,
				            		//'artist_name' => $artist_name,
            ));
            AdminAlbumArtistModel::model()->updateArtist($model->id, $_POST['AdminAlbumModel_artist_id_list']);
            $model->artist_name = AdminAlbumArtistModel::model()->getArtistByAlbum($model->id, 'name');
            if ($model->save()) {
                $fileAvatar = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS . $_POST['AdminAlbumModel']['source_path'];
                
                if (file_exists($fileAvatar)) {
                    AvatarHelper::processAvatar($model, $fileAvatar);
                }

                //UPDATE ALBUM STATUS TO  APPROVED
                if (isset($_POST['AdminAlbumModel']['appstatus']) && $_POST['AdminAlbumModel']['appstatus'] == AdminAlbumStatusModel::APPROVED) {
                    $listAlbum[] = $id;
                    AdminAlbumModel::model()->setApproved($listAlbum, $this->userId);
                } else if (isset($_POST['AdminAlbumModel']['appstatus']) && $_POST['AdminAlbumModel']['appstatus'] == AdminAlbumStatusModel::WAIT_APPROVED) {
                    $listAlbum[] = $id;
                    AdminAlbumModel::model()->setWaitApproved($listAlbum, $this->userId);
                } else if (isset($_POST['AdminAlbumModel']['appstatus']) && $_POST['AdminAlbumModel']['appstatus'] == AdminAlbumStatusModel::REJECT) {
                    $listAlbum[] = $id;
                    AdminAlbumModel::model()->setDelete($listAlbum, $this->userId);
                }

                //CHANGE ARTISTID & ARTIST_STATUS
                /*
                $afterAritst = $model->artist_id;
                if ($beforeArtist != $afterAritst) {
                    $albumStatusModel = AdminAlbumStatusModel::model()->findByPk($model->id);
                    $albumStatusModel->artist_status = AdminAlbumStatusModel::ARTIST_PUBLISH;
                    $albumStatusModel->artist_id = $model->artist_id;
                    $albumStatusModel->save();
                }

                */
                
                //Update Tag
                TagContentModel::model()->updateTag($model->id,$_POST['tags'],"album");
                
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $categoryList = AdminGenreModel::model()->gettreelist(2);
        $uploadModel = new XUploadForm();
        $cpList = AdminCpModel::model()->findAll();
        $this->albumArtist = AdminAlbumArtistModel::model()->getArtistByAlbum($model->id);
        $this->tags = TagContentModel::model()->getTagByContent($id,"album");
        $this->render('update', array(
            'model' => $model,
            'categoryList' => $categoryList,
            'uploadModel' => $uploadModel,
            'cpList' => $cpList,
        ));
    }

    public function actionApprovedAll() {
        if (Yii::app()->getRequest()->ispostRequest) {
            $isAll = isset($_POST['all-item']) ? $_POST['all-item'] : null;
            $type = Yii::app()->request->getParam('type', AdminAlbumModel::ALL);
            if ($isAll) {
                $albumMass = AdminAlbumModel::model()->getListByStatus($type, $this->cpId);
                $albumMass = CHtml::listData($albumMass, "id", "id");
            } else {
                $albumMass = $_POST['cid'];
            }
            AdminAlbumModel::model()->setApproved($albumMass, $this->userId);
            $this->redirect(array('index', 'AdminAlbumModel[status]' => AdminAlbumModel::WAIT_APPROVED));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $model = $this->loadModel($id)->delete();
            $c = new CDbCriteria();
            $c->condition = "album_id = :ID";
            $c->params = array(':ID' => $id);
            $albumSong = AdminAlbumSongModel::model()->deleteAll($c);

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
        $albumList = array();
        if (!isset($_POST['all-item'])) {
            $albumList = $_POST['cid'];
        }
        AdminAlbumModel::model()->setDelete($this->userId, $albumList);
        $this->redirect(array('index'));
    }

    public function actionReorder() {
        $data = Yii::app()->request->getParam('sorder');
        $data = ArrayHelper::reorder($data);
        $maxArray = max($data);

        $c = new CDbCriteria();
        $c->condition = "status=:STATUS";
        $c->params = array(":STATUS" => AdminAlbumModel::ACTIVE);
        $c->order = "sorder ASC";
        $c->limit = 100;
        $albumObj = AdminAlbumModel::model()->findAll($c);

        $i = 1;
        foreach ($albumObj as $album) {
            if (!isset($data[$album->id])) {
                $order = $maxArray + $i;
            } else {
                $order = $data[$album->id];
            }
            $albumModel = AdminAlbumModel::model()->findByPk($album->id);
            $albumModel->sorder = $order;
            if (!$albumModel->save()) {
                $error = $albumModel->getErrors();
                echo $album->id . "\n";
                echo "<pre>";
                print_r($error);
                echo "</pre>\n";
                continue;
            }
            $i++;
        }
    }

    public function actionReorderItems() {
        $albumId = Yii::app()->request->getParam('id');
        $data = Yii::app()->request->getParam('sorder');

        $data = ArrayHelper::reorder($data);
        $maxArray = max($data);

        $c = new CDbCriteria();
        $c->condition = "album_id=:AID";
        $c->params = array(':AID' => $albumId);
        $c->order = "sorder ASC, id DESC";
        $albumSong = AdminAlbumSongModel::model()->findAll($c);

        $i = 1;
        foreach ($albumSong as $alSong) {
            if (!isset($data[$alSong->id])) {
                $order = $maxArray + $i;
            } else {
                $order = $data[$alSong->id];
            }
            $albumSongObj = AdminAlbumSongModel::model()->findByPk($alSong->id);
            $albumSongObj->sorder = $order;
            $albumSongObj->save();
            $i++;
        }
    }

    public function actionSonglist($id) {
        $model = $this->loadModel($id);
        $songList = new AdminAlbumSongModel("search");
        $songList->unsetAttributes();
        $songList->setAttributes(array('album_id' => $id));
        Yii::app()->user->setState('pageSize', 1000000);

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_songInList', array(
                'model' => $model,
                'songList' => $songList,
                'id' => $id
            ));
        } else {
            $this->render('songlist', array(
                'model' => $model,
                'songList' => $songList,
                'id' => $id
            ));
        }
    }

    public function actionPublishItems() {
        $items = yii::app()->request->getparam('cid');
        $items = implode(",", $items);
        $attributes['status'] = 1;
        $condition = "id IN ($items)";
        AdminAlbumSongModel::model()->updateAll($attributes, $condition);
    }

    public function actionUnpublishItems() {
        $items = yii::app()->request->getparam('cid');
        $items = implode(",", $items);
        $attributes['status'] = 0;
        $condition = "id IN ($items)";
        AdminAlbumSongModel::model()->updateAll($attributes, $condition);
    }

    public function actionAddItems() {
        $albumId = Yii::app()->request->getParam('album_id', null);
        $flag = true;
        if (Yii::app()->getRequest()->ispostRequest) {
            $flag = false;
            $songInAlbum = AdminAlbumSongModel::model()->findAll("album_id=:ALBUMID", array(':ALBUMID' => $albumId));
            $songData = CHtml::listData($songInAlbum, 'id', 'song_id');
            $contentId = Yii::app()->request->getParam('cid');
            for ($i = 0; $i < count($contentId); $i++) {
                if (!in_array($contentId[$i], $songData)) {
                    $model = new AdminAlbumSongModel();
                    $model->song_id = $contentId[$i];
                    $model->album_id = $albumId;
                    $model->save();
                }
            }
            AdminAlbumModel::model()->updateTotalSong($albumId);
        }
        if ($flag) {
            Yii::app()->user->setState('pageSize', 20);
            $songModel = new AdminSongModel('search');
            $songModel->unsetAttributes();

            if (isset($_GET['AdminSongModel'])) {
                $songModel->attributes = $_GET['AdminSongModel'];
            }

            //$songModel->setAttribute("status", "<>".AdminSongModel::DELETED);
            $songModel->setAttribute("status", 1);
            $lyric = 2;
            if (isset($_GET['lyric'])) {
            	$lyric = $_GET['lyric'];
            }
            $songModel->lyric = $lyric;
            
            $categoryList = AdminGenreModel::model()->gettreelist(2,false,0,1,false,'album');
            $cpList = AdminCpModel::model()->findAll();
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_addItems', array(
                'songModel' => $songModel,
                'album_id' => $albumId,
            	'lyric'=>$lyric,
                'categoryList' => $categoryList,
                'cpList' => $cpList,
                    ), false, true);
        }
    }

    public function actionDeleteItems() {
        if (Yii::app()->request->isPostRequest) {
            $items = yii::app()->request->getparam('cid');
            //$albumSongId =  $items[0];
            $items = implode(",", $items);
            $condition = "id IN ($items)";
            $albumSongModel = AdminAlbumSongModel::model()->find($condition);
            $albumId = $albumSongModel->album_id;

            AdminAlbumSongModel::model()->deleteAll($condition);
            AdminAlbumModel::model()->updateTotalSong($albumId);
        }else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionFavList($id) {
        $favlist = new AdminFavouriteAlbumModel("search");
        $favlist->unsetAttributes();
        $favlist->setAttribute('playlist_id', $id);
        $this->renderPartial('_favList', array('favlist' => $favlist, 'id' => $id));
    }

    public function actionMassUpdate() {
        $massList = Yii::app()->request->getParam('cid', 0);
        $isAll = Yii::app()->request->getParam('all-item', 0);
        $isPopup = Yii::app()->request->getParam('popup', null);
        $type = Yii::app()->request->getParam('type', AdminAlbumModel::ALL);

        $flag = true;
        if (Yii::app()->getRequest()->ispostRequest && $isPopup == 1) {
            $flag = false;
            $contentId = Yii::app()->request->getParam('conten_id');
            $contentAll = Yii::app()->request->getParam('is_all');
            $dataInput = $_POST['album'];
            if (!empty($dataInput)) {

                if ($contentAll == 0) {
                    $albumMass = explode(",", $contentId);
                } else {
                    $albumMass = AdminAlbumModel::model()->getListByStatus($type, $this->cpId);
                    $albumMass = CHtml::listData($albumMass, "id", "id");
                }

                if (!empty($dataInput)) {
                    $countExe = AdminAlbumModel::model()->massupdate($dataInput, $albumMass);
                    //UPDATE ALBUM FEATURE
                    if (isset($dataInput['feature']) && 1 == $dataInput['feature']) {
                        AdminFeatureAlbumModel::model()->addList($this->userId, $albumMass);
                    }
                }
            }
        }

        if ($flag) {
            $massList = implode(",", $massList);
            $categoryList = AdminGenreModel::model()->gettreelist(2,false,0,1,false,'album');
            $artistList = AdminArtistModel::model()->findAll();
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_massUpdate', array(
                'categoryList' => $categoryList,
                'artistList' => $artistList,
                'massList' => $massList,
                'isAll' => $isAll,
                'type' => $type,
                    ), false, true);
        }
    }

    public function actionConfirmDel() {
        $isAll = Yii::app()->request->getParam('all-item', 0);
        $isPopup = Yii::app()->request->getParam('popup', null);
        $massList = Yii::app()->request->getParam('cid', 0);
        $type = Yii::app()->request->getParam('type', AdminAlbumModel::ALL);
        $reqsource = Yii::app()->request->getParam('reqsource', 'list');
        $flag = true;

        if (Yii::app()->getRequest()->ispostRequest && $isPopup == 1) {
            $flag = false;
            $contentId = Yii::app()->request->getParam('conten_id');
            $contentAll = Yii::app()->request->getParam('is_all', 0);

            if (intval($contentAll) == 0) {
                $albumMass = explode(",", $contentId);
            } else {
                $albumMass = AdminAlbumModel::model()->getListByStatus($type, $this->cpId);
                $albumMass = CHtml::listData($albumMass, "id", "id");
            }

            if (!empty($albumMass)) {
                $reason = Yii::app()->request->getParam('reason');
                AdminAlbumModel::model()->setdelete($this->userId, $reason, $albumMass);
            } else {
                throw new CDbException(Yii::t('admin', 'Không có bản ghi nào được chọn'));
            }
        }

        if ($flag) {
            $massList = implode(",", $massList);
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_confirmDel', array(
                'massList' => $massList,
                'isAll' => $isAll,
                'type' => $type,
                'reqsource' => $reqsource,
                    ), false, true);
        }
    }

    public function actionRestore() {
        $isAll = Yii::app()->request->getParam('all-item', 0);
        $massList = Yii::app()->request->getParam('cid', 0);
        $returnUrl = Yii::app()->request->getParam('return', null);
        if (intval($isAll) == 0) {
            $massList = $massList;
        } else {
            $albumMass = AdminAlbumModel::model()->getListByStatus(AdminAlbumModel::DELETED, $this->cpId);
            $massList = CHtml::listData($albumMass, "id", "id");
        }
        AdminAlbumModel::model()->restore($massList, $this->userId);
        if ($returnUrl) {
            $url = Yii::app()->createUrl("album/view", array('id' => $massList[0]));
            $this->redirect($url);
        }
        $this->redirect(array('index', 'AdminAlbumModel[status]' => AdminAlbumModel::DELETED));
    }

    public function actionExport() {

        $isAll = Yii::app()->request->getParam('all-item', 0);
        $massList = Yii::app()->request->getParam('cid', 0);
        $type = Yii::app()->request->getParam('type', AdminAlbumModel::ALL);

        $c = new CDbCriteria();
        if ($isAll == 0) {
            $c->condition = "t.id IN (" . implode(",", $massList) . ")";
        } else {
            // Get list song by cpId and status
            if ($this->cpId != 0) {
                if ($type != AdminAlbumModel::ALL) {
                    $c->condition = "status = :STATUS AND cp_id=:CP";
                    $c->params = array(":STATUS" => $type, ':CP' => $this->cpId);
                } else {
                    $c->condition = "cp_id=:CP";
                    $c->params = array(':CP' => $this->cpId);
                }
            } else {
                if ($type != AdminAlbumModel::ALL) {
                    $c->condition = "status = :STATUS";
                    $c->params = array(":STATUS" => $type);
                }
            }
        }
        $albumMass = AdminAlbumModel::model()->findAll($c);

        $label = array(
            'name' => Yii::t('admin', 'Video'),
            'genre_id' => Yii::t('admin', 'Thể loại'),
            'artist_name' => Yii::t('admin', 'Ca sỹ'),
            'created_time' => Yii::t('admin', 'Ngày tạo'),
        );
        $title = Yii::t('admin', 'Danh sách album');
        $excelObj = new ExcelExport($albumMass, $label, $title);
        $excelObj->export();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = AdminAlbumModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-album-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }



    public function actionexclusive() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AlbumModel::model()->updateAll(array('exclusive' => 1));
        } else {
            AlbumModel::model()->updateAll(array('exclusive' => 1), "id IN (" . implode(',', $cids) . ")");
        }

        $this->redirect(array('index'));
    }

    public function actionUnexclusive() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AlbumModel::model()->updateAll(array('exclusive' => 0));
        } else {
            AlbumModel::model()->updateAll(array('exclusive' => 0), "id IN (" . implode(',', $cids) . ")");
        }
        $this->redirect(array('index'));
    }

    public function actionNew() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AlbumModel::model()->updateAll(array('new_release' => 1));
        } else {
            AlbumModel::model()->updateAll(array('new_release' => 1), "id IN (" . implode(',', $cids) . ")");
        }

        $this->redirect(array('index'));
    }

    public function actionUnnew() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            AlbumModel::model()->updateAll(array('new_release' => 0));
        } else {
            AlbumModel::model()->updateAll(array('new_release' => 0), "id IN (" . implode(',', $cids) . ")");
        }
        $this->redirect(array('index'));
    }
    
    protected function getGenreName($data,$row)
    {
    	if(isset($this->genreList[$data->genre_id])) return $this->genreList[$data->genre_id];
    	else return $data->genre_id."-UnknowName";
    }

}