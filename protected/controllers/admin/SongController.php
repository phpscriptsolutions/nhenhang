<?php

Yii::import("ext.xupload.models.XUploadForm");

class SongController extends Controller {

    public $type = AdminSongModel::ALL;
    public $songCate = array();
    public $songArtist = array();
    public $tags = array();
    

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', 'Quản lý bài hát');
        $type = Yii::app()->request->getParam('AdminSongModel');
        $this->type = (isset($type['status']) && $type['status'] != "") ? $type['status'] : AdminSongModel::ALL;
    }

    public function actions() {
        return array(
            'upload' => array(
                'class' => 'ext.xupload.actions.XUploadAction',
                'subfolderVar' => 'parent_id',
                'path' => _APP_PATH_ . DS . "data",
                'alowType' => 'audio/mpeg,audio/mp3'
            ),
        );
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new AdminSongModel('search');
        $copyrightType = Yii::app()->request->getParam('ccp_type',null);
        $model->unsetAttributes();  // clear any default values
        $model->ccp_type = $copyrightType;
        if (isset($_GET['AdminSongModel'])) {
            $model->attributes = $_GET['AdminSongModel'];
            if (isset($_GET['AdminSongModel']['created_time']) && $_GET['AdminSongModel']['created_time'] != "") {
                // Re-setAttribute create datetime
                $createdTime = $_GET['AdminSongModel']['created_time'];
                if (strrpos($createdTime, "-")) {
                    $createdTime = explode("-", $createdTime);
                    $fromDate = explode("/", trim($createdTime[0]));
                    $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                    $fromDate .=" 00:00:00";
                    $toDate = explode("/", trim($createdTime[1]));
                    $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                    $toDate .=" 23:59:59";
                } else {
                    $fromDate = date("Y-m-d", strtotime($_GET['AdminSongModel']['created_time'])) . " 00:00:00";
                    $toDate = date("Y-m-d", strtotime($_GET['AdminSongModel']['created_time'])) . " 23:59:59";
                }
                $model->setAttribute("created_time", array(0 => $fromDate, 1 => $toDate));
            }
        }

        $is_composer="";
        if (isset($_GET['is_composer']) && $_GET['is_composer']>0) {
        	if($_GET['is_composer']==1){
        		$model->setAttribute("composer_id", ">0");
        	}else{
        		$model->setAttribute("composer_id", "<=0");
        	}
        	$is_composer = $_GET['is_composer'];
        }

        $copyright="";
        if (isset($_GET['copyright']) && $_GET['copyright']>0) {
        	if($_GET['copyright']==1){
        		$model->setAttribute("copyright", ">0");
        	}else{
        		$model->setAttribute("copyright", "<=0");
        	}
        	$copyright = $_GET['copyright'];
        }
        /* if (!isset($_GET['created_by'])) {
            $model->setAttribute("created_by", "<>441");
        } */
        if (isset($_GET['created_by']) && $_GET['created_by'] == 'import') {
            $model->setAttribute("created_by", "import");
        }

        if (isset($_GET['unknow_cat'])) {
            $model->setAttribute("genre_id", 1111);
        }

        // Default none display song delete
        /*
          if($this->type == AdminSongModel::ALL){
          $model->setAttribute("status", "<>".AdminSongModel::DELETED);
          }else{
          $model->setAttribute("status", $this->type);
          }
         */
        $lyrics = 2;
        if (isset($_GET['lyrics'])) {
            $lyrics = $_GET['lyrics'];
        }
        $model->lyric = $lyrics;
        
    	if (isset($_GET['AdminSongModel']['artist_id'])) {
             $model->artist_id = $_GET['AdminSongModel']['artist_id'];
        }

        $model->setAttribute("status", $this->type);
        /* if ($this->cpId != 0) {
            $model->setAttribute("cp_id", $this->cpId);
        } */
        ///$model->setAttribute("created_by", "<>441");

        $categoryList = AdminGenreModel::model()->gettreelist(2,false,0,1,false,'all');
        $cpList = AdminCpModel::model()->findAll();

        $this->render('index', array(
            'model' => $model,
            'categoryList' => $categoryList,
            'cpList' => $cpList,
            'pageSize' => $pageSize,
            'lyric' => $lyrics,
        	'is_composer'=>$is_composer,
        	'copyright'=>$copyright,
        	'copyrightType'=>$copyrightType
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        $this->songCate = AdminSongGenreModel::model()->getCatBySong($id, true);
        $metaModel = AdminSongMetadataModel::model()->findByAttributes(array("song_id"=>$id));
        $songModel = $this->loadModel($id);
        $this->render('view', array(
            'model' => $songModel,
            'metaModel' => $metaModel,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
    	throw new CHttpException(404,'Featured disable by admin');
    	
        $model = new AdminSongModel;
		// set default value
		$defaultValue = array(
			'allow_download' => 1,
			'download_price' => Yii::app()->params['price']['songDownload'],
			'listen_price' => Yii::app()->params['price']['songListen']
		);
		$model->setAttributes($defaultValue);

        //$songMeta = new AdminSongMetadataModel;
        $valcopy0 = Yii::app()->request->getParam('valcopy0');
        $valcopy1 = Yii::app()->request->getParam('valcopy1');

        if (isset($_POST['AdminSongModel'])) {
            if (isset($_POST['active_time']) && $_POST['active_time'] != "") {
                $active_time = $_POST['active_time'];
                if (strrpos($active_time, "-")) {
                    $createdTime = explode("-", $active_time);
                    $fromDate = explode("/", trim($createdTime[0]));
                    $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                    $fromDate .=" 00:00:00";
                    $toDate = explode("/", trim($createdTime[1]));
                    $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                    $toDate .=" 23:59:59";
                } else {
                    $fromDate = date("Y-m-d", strtotime($_GET['active_time'])) . " 00:00:00";
                    $toDate = date("Y-m-d", strtotime($_GET['active_time'])) . " 23:59:59";
                }
                $model->setAttribute("active_totime", $toDate);
                $model->setAttribute("active_fromtime", $fromDate);
            }

            $adminUser = AdminAdminUserModel::model()->findByPk($this->userId);
            $cpId = $adminUser->cp_id;
            if ($cpId == 0 || $cpId == '0' || !isset($cpId)) {
                $cpId = $_POST['AdminSongModel']['cp_id'];
            }

            if ($cpId == 0 || $cpId == '0' || !isset($cpId)) {
                $_GET['msg'] = Yii::t('admin', 'Tài khoản chưa được gán quyền CP');
                $this->forward("admin/error", true); // exit
            }
            $songCode = AdminAdminUserModel::model()->getMaxContentCode($cpId, 'song');

            if (!$songCode) {
                $_GET['msg'] = Yii::t('admin', 'Tài khoản đã hết quyền upload bài hát');
                $this->forward("admin/error", true); // exit
            }

            $songexits = AdminSongModel::model()->findAllByAttributes(array('name' => $_POST['AdminSongModel']['name']));
            $isExits = false;
            $hadsong = null;
            foreach ($songexits as $songexit) {
                if ($songexit->cp_id == $cpId && $songexit->songstatus->approve_status <> 2) {
                    $tmp = array();
                    foreach($songexit->song_artist as $artist){
                        $tmp[] = $artist->artist_id;
                    }
                    sort($tmp);
                    sort($_POST['artist_id_list']);
                    if($tmp == $_POST['artist_id_list']){
                        $isExits = true;
                        $hadsong = $songexit;
                        break;
                    }
                }
            }
            $data = array(
                'code' => $songCode,
                'created_time' => date("Y-m-d H:i:s"),
                'updated_time' => date("Y-m-d H:i:s"),
                'created_by' => $this->userId,
                'cp_id' => $cpId,
                'genre_id' => 0,
				'allow_download' => 1,
				'download_price' => Yii::app()->params['price']['songDownload'],
				'listen_price' => Yii::app()->params['price']['songListen'],
            );

			// can edit price
			if($this->canEditPrice()) {
				unset($data['allow_download']);
				unset($data['download_price']);
				unset($data['listen_price']);
			}

			unset($_POST['AdminSongModel']['cp_id']);
			$model->attributes = $_POST['AdminSongModel'];
            $model->setAttributes($data);

            $videoId = ($_POST['AdminSongModel']['video_id']) ? (int)$_POST['AdminSongModel']['video_id'] : 0;
            $video = AdminVideoModel::model()->findByPk($videoId);
            if ($video) {
            	$model->setAttribute('video_id', $video->id);
            	$model->setAttribute('video_name', $video->name);
            }

            $model->unsetAttributes('source_path');

            //check exits file
            $fileMp3 = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS . $_POST['tmp_source_path'];

            if (file_exists($fileMp3) && !$isExits) {
                if ($model->save()) {
                    if($valcopy0){
                        $arr = explode(',', $valcopy0);
                        foreach($arr as $copy){
                            $sCopy = new AdminSongCopyrightModel();
                            if(Yii::app()->request->getParam('cpy0')==$copy){
                                $sCopy->setAttribute('active', 1);
                            }
                            $sCopy->setAttribute('song_id', $model->id);
                            $sCopy->setAttribute('copryright_id', $copy);
                            $sCopy->setAttribute('type', 0);
                            $sCopy->setAttribute('from_date', Yii::app()->request->getParam('start_date_'.$copy));
                            $sCopy->setAttribute('due_date', Yii::app()->request->getParam('due_date_'.$copy));
                            $sCopy->setAttribute('copyright_method', Yii::app()->request->getParam('copy_type_'.$copy));
                            $sCopy->save();
                        }
                    }
                    if($valcopy1){
                        $arr = explode(',', $valcopy1);
                        foreach($arr as $copy){
                            $sCopy = new AdminSongCopyrightModel();
                            if(Yii::app()->request->getParam('cpy1')==$copy){
                                $sCopy->setAttribute('active', 1);
                            }
                            $sCopy->setAttribute('song_id', $model->id);
                            $sCopy->setAttribute('copryright_id', $copy);
                            $sCopy->setAttribute('type', 1);
                            $sCopy->setAttribute('from_date', Yii::app()->request->getParam('start_date_'.$copy));
                            $sCopy->setAttribute('due_date', Yii::app()->request->getParam('due_date_'.$copy));
                            $sCopy->setAttribute('copyright_method', Yii::app()->request->getParam('copy_type_'.$copy));
                            $sCopy->save();
                        }
                    }
                    $this->moveFile($model, $fileMp3);
                    //Create Convert Song
                    $songlist[] = $model->id;
                    AdminConvertSongModel::model()->updateStatus($songlist, AdminConvertSongModel::NOT_CONVERT);

                    //Update groupID
                    AdminSongModel::model()->updateSongGroupId($model, $_POST['artist_id_list']);

                    //update song meta
                    AdminSongMetadataModel::model()->updateData($model->id, $_POST['songMeta']);
                    /*$songMeta->song_id = $model->id;
                    $songMeta->attributes = $_POST['songMeta'];
                    $songMeta->save();*/

                    //Update songCate
                    AdminSongGenreModel::model()->updateSongCate($model->id, $_POST['genre_ids']);

                    //Update songartist
                    AdminSongArtistModel::model()->updateArtist($model->id, $_POST['artist_id_list']);
                    $model->artist_name = AdminSongArtistModel::model()->getArtistBySong($model->id, 'name');
                    $model->save();

                    $this->redirect(array('view', 'id' => $model->id));
                }
            } else {
                if(!file_exists($fileMp3))
                    $model->addError("file", Yii::t('admin', 'Chưa upload file'));
                if($isExits)
                    $model->addError("artist_id", Yii::t('admin', 'Hệ thống đã tồn tại bài hát cùng tên và cùng CP với bài bạn muốn Upload lên!'));
            }
        }
        $categoryList = AdminGenreModel::model()->gettreelist(2, false, 0, 0,false,'all');
        $uploadModel = new XUploadForm();
        $cpList = AdminCpModel::model()->findAll();

        $this->render('create', array(
            'model' => $model,
            'categoryList' => $categoryList,
            'uploadModel' => $uploadModel,
            //'songMeta' => $songMeta,
            'cpList' => $cpList,
            'copyright' => isset($copyright)?$copyright:array(),
            'hadsong' => isset($hadsong)?$hadsong:0,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
    	
    	if(!is_numeric($id)) throw new CHttpException(404);

        $model = $this->loadModel($id);
        if ($model->songstatus->approve_status == AdminSongStatusModel::REJECT || $model->songstatus->convert_status == AdminSongStatusModel::NOT_CONVERT) {
            $this->forward("song/view", true);
        }
        /*$crit = new CDbCriteria();
        $crit->condition = 'song_id=:song_id';
        $crit->params = array(':song_id'=>$id);
        $songMeta = AdminSongMetadataModel::model()->findAll($crit);
        //echo '<pre>';print_r($songMeta);exit;
        if (empty($songMeta)) {
            $songMeta = new AdminSongMetadataModel();
            $songMeta->song_id = $id;
        }*/

        if (isset($_POST['AdminSongModel'])) {

            $data = array(
                'updated_time' => date("Y-m-d H:i:s"),
                'genre_id' => 0,
				'allow_download' => 1,
				'download_price' => Yii::app()->params['price']['songDownload'],
				'listen_price' => Yii::app()->params['price']['songListen']
            );

			// can edit price
			if($this->canEditPrice()) {
				unset($data['allow_download']);
				unset($data['download_price']);
				unset($data['listen_price']);
			}
            if (isset($_POST['active_time']) && $_POST['active_time'] != "") {
                $active_time = $_POST['active_time'];
                if (strrpos($active_time, "-")) {
                    $createdTime = explode("-", $active_time);
                    $fromDate = explode("/", trim($createdTime[0]));
                    $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                    $fromDate .=" 00:00:00";
                    $toDate = explode("/", trim($createdTime[1]));
                    $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                    $toDate .=" 23:59:59";
                } else {
                    $fromDate = date("Y-m-d", strtotime($_GET['active_time'])) . " 00:00:00";
                    $toDate = date("Y-m-d", strtotime($_GET['active_time'])) . " 23:59:59";
                }
                $model->setAttribute("active_totime", $toDate);
                $model->setAttribute("active_fromtime", $fromDate);
            }
            //check exits file
            $fileMp3 = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS . $_POST['tmp_source_path'];
            if (file_exists($fileMp3)) {
                $sourcePath = $this->moveFile($model, $fileMp3);
                $data['approved_by'] = 0;
                $data['source_path'] = $sourcePath;
                //Recovert
                $_POST['AdminSongModel']['status'] = AdminSongModel::NOT_CONVERT;
            }
            $songStatus = $_POST['AdminSongModel']['status'];
            unset($_POST['AdminSongModel']['status']);

            $model->attributes = $_POST['AdminSongModel'];
            $model->setAttributes($data);

            $videoId = ($_POST['AdminSongModel']['video_id']) ? (int)$_POST['AdminSongModel']['video_id'] : 0;
            $video = AdminVideoModel::model()->findByPk($videoId);
            if ($video) {
            	$model->setAttribute('video_id', $video->id);
            	$model->setAttribute('video_name', $video->name);
            }
            
            $model->lyrics = $_POST['AdminSongModel']['lyrics'] ? $_POST['AdminSongModel']['lyrics'] : "";
            
            if ($model->save()) {

                //Update song meta
                //$songMeta->save();
                //AdminSongMetadataModel::model()->updateData($model->id, $_POST['songMeta']);
                //UPDATE SONG STATUS
                $songList[] = $id;
                if (isset($songStatus)) {
                    switch ($songStatus) {
                        case AdminSongModel::NOT_CONVERT:
                            //Create Convert Song
                            AdminConvertSongModel::model()->updateStatus($songList, AdminConvertSongModel::NOT_CONVERT);
                            AdminSongModel::model()->setReconvert($songList);
                            $model->sync_status = 0;
                            $model->status=0;
                            //Re sync song
                            AdminSongModel::model()->setReSync($songList);

                            break;
                        case AdminSongModel::WAIT_APPROVED:
                            AdminSongModel::model()->setWaitApproved($songList, $this->userId);
                            break;
                    }
                }

                //Update songCate
                AdminSongGenreModel::model()->updateSongCate($model->id, $_POST['genre_ids']);

                //Update songartist
                AdminSongArtistModel::model()->updateArtist($model->id, $_POST['artist_id_list']);
                $model->artist_name = AdminSongArtistModel::model()->getArtistBySong($model->id, 'name');
                $model->save();
                
                //Update Tag
                TagContentModel::model()->updateTag($model->id,$_POST['tags'],"song");
                

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $categoryList = AdminGenreModel::model()->gettreelist(2,false,0,1,false,'all');
        $uploadModel = new XUploadForm();
        $cpList = AdminCpModel::model()->findAll();
        $this->songCate = AdminSongGenreModel::model()->getCatBySong($model->id);
        $activetime[] = date("m/d/Y", strtotime($model->active_fromtime));
        $activetime[] = date("m/d/Y", strtotime($model->active_totime));
        $this->songArtist = AdminSongArtistModel::model()->getArtistBySong($model->id);
        $this->tags = TagContentModel::model()->getTagByContent($id,"song");
        $this->render('update', array(
            'model' => $model,
            //'songMeta' => $songMeta,
            'categoryList' => $categoryList,
            'uploadModel' => $uploadModel,
            'cpList' => $cpList,
            'activetime' => $activetime,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $cids[] = $id;
            AdminSongModel::model()->setdelete($this->userId, "", $cids);

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
        $adminId = $this->userId;
        if (isset($_POST['all-item'])) {
            AdminSongModel::model()->setdelete($adminId);
        } else {
            AdminSongModel::model()->setdelete($adminId, $_POST['cid']);
        }
        $this->redirect(array('index'));
    }

    public function actionMassUpdate() {
        $massList = Yii::app()->request->getParam('cid', 0);
        $isAll = Yii::app()->request->getParam('all-item', 0);
        $isPopup = Yii::app()->request->getParam('popup', null);
        $type = Yii::app()->request->getParam('type', AdminSongModel::ALL);
        $copy0 = Yii::app()->request->getParam('valcopy0', 0);
        $copy1 = Yii::app()->request->getParam('valcopy1', 0);

        $copyright0 = AdminCopyrightModel::model()->findAllByAttributes(array('type' => 0));
        $copyright1 = AdminCopyrightModel::model()->findAllByAttributes(array('type' => 1));

        $flag = true;
        if (Yii::app()->getRequest()->ispostRequest && $isPopup == 1) {
            $flag = false;
            $contentId = Yii::app()->request->getParam('conten_id');
            $contentAll = Yii::app()->request->getParam('is_all');
            $dataInput = $_POST['song'];

            if ($copy0) {
                $cr = new CDbCriteria();
                $cr->condition = "song_id in ({$contentId}) and type=0";
                AdminSongCopyrightModel::model()->deleteAll($cr);
                $cr = new CDbCriteria();
                $cr->condition = "id in ({$copy0})";
                $copys = AdminCopyrightModel::model()->findAll($cr);
                $sId = explode(',', $contentId);
                $active = 0;
                $arr = explode(',', $copy0);
                foreach ($copys as $cp) {
                    if($cp['id']==$arr[0])
                        $active = 1;
                    foreach ($sId as $sid) {
                        $sCopy = new AdminSongCopyrightModel();
                        $sCopy->setAttribute('song_id', $sid);
                        $sCopy->setAttribute('copryright_id', $cp['id']);
                        $sCopy->setAttribute('type', $cp['type']);
                        $sCopy->setAttribute('from_date', $cp['start_date']);
                        $sCopy->setAttribute('due_date', $cp['due_date']);
                        $sCopy->setAttribute('copyright_method', 0);
                        $sCopy->setAttribute('active', $active);
                        $sCopy->save();
                    }
                    $active = 0;
                }
            }
            if ($copy1) {
                $cr = new CDbCriteria();
                $cr->condition = "song_id in ({$contentId}) and type=1";
                AdminSongCopyrightModel::model()->deleteAll($cr);
                $cr = new CDbCriteria();
                $cr->condition = "id in ({$copy1})";
                $copys = AdminCopyrightModel::model()->findAll($cr);
                $sId = explode(',', $contentId);
                $active = 0;
                $arr = explode(',', $copy1);
                foreach ($copys as $cp) {
                    if($cp['id']==$arr[0])
                        $active = 1;
                    foreach ($sId as $sid) {
                        $sCopy = new AdminSongCopyrightModel();
                        $sCopy->setAttribute('song_id', $sid);
                        $sCopy->setAttribute('copryright_id', $cp['id']);
                        $sCopy->setAttribute('type', $cp['type']);
                        $sCopy->setAttribute('from_date', $cp['start_date']);
                        $sCopy->setAttribute('due_date', $cp['due_date']);
                        $sCopy->setAttribute('copyright_method', 0);
                        $sCopy->setAttribute('active', $active);
                        $sCopy->save();
                    }
                    $active = 0;
                }
            }

            if (!empty($dataInput)) {
                if ($contentAll == 0) {
                    $songMass = explode(",", $contentId);
                } else {
                    $songMass = AdminSongModel::model()->getListByStatus($type, $this->cpId);
                    $songMass = CHtml::listData($songMass, "id", "id");
                }

                if (!empty($dataInput)) {
                    AdminSongModel::model()->massupdate($dataInput, $songMass);

                    //UPDATE FEATUER_SONG
                    if ($dataInput['feature'] && $dataInput['feature'] == 1) {
                        AdminFeatureSongModel::model()->addList($this->userId, $songMass);
                    }

                    //UPDATE TOTAL SONG FOR ARTIST [[ NOT USE ]]
                    //AdminArtistModel::model()->updateTotalSongBySongList($songMass);
                }
            }
        }
        if ($flag) {
            $massList = implode(",", $massList);
            $categoryList = AdminGenreModel::model()->gettreelist(2,false,0,1,false,'all');
            $artistList = AdminArtistModel::model()->findAll();
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('massUpdate', array(
                'categoryList' => $categoryList,
                'artistList' => $artistList,
                'copyright0' => $copyright0,
                'copyright1' => $copyright1,
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
        $type = Yii::app()->request->getParam('type', AdminSongModel::ALL);
        $reqsource = Yii::app()->request->getParam('reqsource', 'list');
        $flag = true;

        if (Yii::app()->getRequest()->ispostRequest && $isPopup == 1) {
            $flag = false;
            $contentId = Yii::app()->request->getParam('conten_id');
            $contentAll = Yii::app()->request->getParam('is_all', 0);

            if (intval($contentAll) == 0) {
                $songMass = explode(",", $contentId);
            } else {
                $songMass = AdminSongModel::model()->getListByStatus($type, $this->cpId);
                $songMass = CHtml::listData($songMass, "id", "id");
            }

            if (!empty($songMass)) {
                $reason = Yii::app()->request->getParam('reason');
                AdminSongModel::model()->setdelete($this->userId, $reason, $songMass);
            } else {
                throw new CDbException(Yii::t('admin', 'Không có bản ghi nào được chọn'));
            }
        }

        if ($flag) {
            $massList = implode(",", $massList);
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('confirmDel', array(
                'massList' => $massList,
                'isAll' => $isAll,
                'type' => $type,
                'reqsource' => $reqsource,
                    ), false, true);
        }
    }

    public function actionApprovedAll() {
        if (Yii::app()->getRequest()->ispostRequest) {
            $isAll = isset($_POST['all-item']) ? $_POST['all-item'] : null;
            $type = Yii::app()->request->getParam('type', AdminSongModel::ALL);
            if ($isAll) {
                $songMass = AdminSongModel::model()->getListByStatus($type, $this->cpId);
                $songMass = CHtml::listData($songMass, "id", "id");
            } else {
                $songMass = $_POST['cid'];
            }
            AdminSongModel::model()->setApproved($songMass, $this->userId);

            //UPDATE TOTAL SONG FOR ARTIST
            //AdminArtistModel::model()->updateTotalSongBySongList($songMass);

            $params = Yii::app()->request->getParam('params');
            $params = CJSON::decode($params, true);
            $res = array();
            foreach ($params as $k => $v) {
                if (isset($v) && $v != '')
                    $res["AdminSongModel[$k]"] = $v;
            }
            $urlRollback = Yii::app()->createUrl('/song/index', $res);
            $this->redirect($urlRollback);
            //$this->redirect(array('index','AdminSongModel[status]'=>AdminSongModel::WAIT_APPROVED));
        }
    }

    public function actionApproved($id) {
        if (Yii::app()->getRequest()->ispostRequest) {
            $songList[] = $id;
            if (isset($_POST['approved'])) {
                AdminSongModel::model()->setApproved($songList, $this->userId);

                //UPDATE TOTAL SONG FOR ARTIST
                //$songObj = AdminSongModel::model()->findByPk($id);
                //AdminArtistModel::model()->updateTotalSongById($songObj->artist_id);
            }

            if (isset($_POST['reject'])) {
                $reason = Yii::app()->request->getParam('reason', 'Từ chối bài hát');
                AdminSongModel::model()->setdelete($this->userId, $reason, $songList);
            }

            $data = Yii::app()->session->get('approvedList');
            $data[$id] = $id;
            Yii::app()->session->add('approvedList', $data);

            // DELETE SESSION
            AdminApproveSessionModel::model()->removeSession("song", $this->userId);

            // NEXT SONG
            $song = AdminSongModel::model()->getListByStatus(AdminSongModel::WAIT_APPROVED);
            foreach ($song as $song) {
                $sessionCheckout = AdminApproveSessionModel::model()->contentCheckout("song", $song['id']);
                if (empty($sessionCheckout) && !in_array($song['id'], Yii::app()->session['approvedList'])) {
                    $songId = $song['id'];
                    break;
                }
            }
            if (isset($songId)) {
                $url = $this->createUrl("song/approved", array("id" => $songId));
            } else {
                $url = $this->createUrl('song/index', array('AdminSongModel[status]' => AdminSongModel::ACTIVE));
            }
            $this->redirect($url);
        }

        $checkout = AdminApproveSessionModel::model()->contentCheckout("song", $id);
        if (!empty($checkout)) {
            $userSession = AdminAdminUserModel::model()->findByPk($checkout['admin_id']);
        } else {
            $userSession = null;
            AdminApproveSessionModel::model()->addSession("song", $id, $this->userId);
        }
        $song = AdminSongModel::model()->findByPk($id);
        $this->render("approved", array(
            'song' => $song,
            'checkout' => $checkout,
            'userSession' => $userSession,
        ));
    }

    public function actionReturnApproved() {
        Yii::app()->session['approvedList'] = null;
        AdminApproveSessionModel::model()->removeSession("song", $this->userId);
        $url = $this->createUrl('song/index', array('AdminSongModel[status]' => AdminSongModel::ACTIVE));
        $this->redirect($url);
    }

    public function actionList() {
        $flag = true;

        $object = Yii::app()->request->getParam('object', "");

        $collect_id = Yii::app()->request->getParam('collect_id', "");
        if (Yii::app()->getRequest()->ispostRequest) {
            if ($object == "songfree") {
                $flag = false;
                $songList = Yii::app()->request->getParam('cid');
                AdminSongFreeModel::model()->addList($this->userId, $songList);
            } elseif ($object == "collection") {
                $flag = false;
                $songList = Yii::app()->request->getParam('cid');
                AdminCollectionItemModel::model()->addList($this->userId, $collect_id, $songList, 'song');
            } elseif ($object == "mgChannel") {
                $flag = false;
                $collect_id = Yii::app()->request->getParam('collect_id', "");
                $songList = Yii::app()->request->getParam('cid');
                AdminMgChannelSongModel::model()->addList($collect_id, $songList);
            } elseif ($object == "top-hot") {
                $flag = false;
                $songList = Yii::app()->request->getParam('cid');
                $songId = $songList[0];
                $songCode = 0;
                $song = AdminSongModel::model()->findByAttributes(array('id' => $songId));
                $songCode = ($song) ? $song['code'] : 0;
                $data = array(
                            "id" => $songId,
                            "code" => $songCode,
                    );
                echo json_encode($data);
                Yii::app()->end();
            } else {
                $flag = false;
                $songList = Yii::app()->request->getParam('cid');
                AdminFeatureSongModel::model()->addList($this->userId, $songList);
            }
        }
        if ($flag) {
            $categoryList = AdminGenreModel::model()->gettreelist(2,false,0,1,false,'all');
            $cpList = AdminCpModel::model()->findAll();
            $pageSize = Yii::app()->request->getParam('pageSize', 20);
            Yii::app()->user->setState('pageSize', $pageSize);
            $model = new AdminSongModel('search');
            $model->unsetAttributes();  // clear any default values

            if (isset($_GET['AdminSongModel'])) {
                $model->attributes = $_GET['AdminSongModel'];
            }
            $model->setAttribute("status", 1);
            //$model->setAttribute("sync_status", 1);
			$model->object_type = $object;
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
            $this->renderPartial('list', array(
                'model' => $model,
                'categoryList' => $categoryList,
                'cpList' => $cpList,
                'object' => $object,
                'collect_id' => $collect_id
                    ), false, true);
        }
    }

    public function actionListFavourite($id) {
        $favModel = new AdminFavouriteSongModel("search");
        $favModel->unsetAttributes();
        $favModel->setAttributes(array("song_id" => $id));

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('listFavourite', array(
                'model' => $favModel,));
        } else {
            $this->render('listFavourite', array(
                'model' => $favModel,));
        }
    }

    public function actionReorder() {
        $data = Yii::app()->request->getParam('sorder');
        $data = ArrayHelper::reorder($data);
        $maxArray = max($data);

        $c = new CDbCriteria();
        $c->condition = "status=:STATUS";
        $c->params = array(":STATUS" => AdminSongModel::ACTIVE);
        $c->order = "sorder ASC, id DESC";
        $c->limit = 100;
        $songList = AdminSongModel::model()->findAll($c);
        $i = 1;
        foreach ($songList as $song) {
            if (!isset($data[$song->id])) {
                $order = $maxArray + $i;
            } else {
                $order = $data[$song->id];
            }
            $songModel = AdminSongModel::model()->findByPk($song->id);
            if ($songModel->url_key == "") {
                $songModel->url_key = Common::url_friendly($songModel->name);
            }
            $songModel->sorder = $order;

            if (!$songModel->save()) {
                $error = $songModel->getErrors();
                echo $song->id . "\n";
                echo "<pre>";
                print_r($error);
                echo "</pre>\n";
                continue;
            }
            $i++;
        }
    }

    public function actionReconvert() {
        $isAll = Yii::app()->request->getParam('all-item', 0);
        $massList = Yii::app()->request->getParam('cid', 0);
        $type = Yii::app()->request->getParam('type', AdminSongModel::ALL);

        if (intval($contentAll) == 0) {
            $songMass = $massList;
        } else {
            $songMass = AdminSongModel::model()->getListByStatus($type, $this->cpId);
            $songMass = CHtml::listData($songMass, "id", "id");
        }

        AdminSongModel::model()->setReconvert($songMass);

        $params = Yii::app()->request->getParam('params');
        $params = CJSON::decode($params, true);
        $res = array();
        foreach ($params as $k => $v) {
            if (isset($v) && $v != '')
                $res["AdminSongModel[$k]"] = $v;
        }
        $urlRollback = Yii::app()->createUrl('/song/index', $res);
        $this->redirect($urlRollback);


        //$url = $this->createUrl('song/index',array('AdminSongModel[status]'=>$type));
        //$this->redirect($url);
    }

    public function actionExport() {

        $isAll = Yii::app()->request->getParam('all-item', 0);
        $massList = Yii::app()->request->getParam('cid', 0);
        $type = Yii::app()->request->getParam('type', AdminSongModel::ALL);

        if ($isAll == 0) {
            $c = new CDbCriteria();
            $c->condition = "id IN (" . implode(",", $massList) . ")";
            $songMass = AdminSongModel::model()->findAll($c);
        } else {
            $songMass = AdminSongModel::model()->getListByStatus($type, $this->cpId);
        }

        $label = array(
            'name' => Yii::t('admin', 'Bài hát'),
            'code' => Yii::t('admin', 'Mã'),
            'genre_id' => Yii::t('admin', 'Thể loại'),
            'artist_name' => Yii::t('admin', 'Ca sỹ'),
            'download_price' => Yii::t('admin', 'Giá download'),
            'listen_price' => Yii::t('admin', 'Giá nghe'),
            'created_time' => Yii::t('admin', 'Ngày tạo'),
        );

        $title = Yii::t('admin', 'Danh sách bài hát');
        $excelObj = new ExcelExport($songMass, $label, $title);
        $excelObj->export();
    }

    public function actionRestore() {
        $cid = Yii::app()->request->getParam('cid', array());
        $returnUrl = Yii::app()->request->getParam('return', null);
        AdminSongModel::model()->restore($cid, $this->userId);
        if ($returnUrl) {
            $url = Yii::app()->createUrl("song/view", array('id' => $cid[0]));
            $this->redirect($url);
        }
        $this->redirect(Yii::app()->createUrl("song/index", array("AdminSongModel[status]" => AdminSongModel::DELETED)));
    }

    public function actionExits() {
        $name = Yii::app()->request->getParam('name', '');
        $artist_name = Yii::app()->request->getParam('artist_name', '');
        $cp_id = (int) Yii::app()->request->getParam('cp_id', 0);
        $song = AdminSongModel::model()->findByAttributes(array('name' => $name, 'artist_name' => $artist_name, 'cp_id' => $cp_id));
        if ($song) {
            $cp = AdminCpModel::model()->findByPk($song['cp_id']);
            $this->renderPartial('exits', array('cp_name' => $cp['name'], 'song' => $song), false, true);
        }
    }

   /*  public function actionLyric() {
        $id = Yii::app()->request->getParam('id', '');
        $song = AdminSongModel::model()->findByPk($id);
        $isPopup = Yii::app()->request->getParam('popup', 0);
        $songExtra = AdminSongExtraModel::model()->findByAttributes(array("song_id" => $id));
        if ($songExtra == null) {
            $songExtra = new AdminSongExtraModel();
            $songExtra->song_id = (int) $id;
            $songExtra->old_id = $song->old_id;
            $songExtra->lyrics = '';
        }
        $lyrics = ($songExtra) ? ($songExtra->lyrics) : "";
        $flag = true;
        if ($isPopup) {
            $flag = false;
            $lyrics = Yii::app()->request->getParam('lyric', '');
            if ($lyrics == " ")
                $lyrics = '';
            $songExtra->lyrics = $lyrics;
            $songExtra->save();
            $result = 1;
            if ($lyrics == '') {
                $result = 0;
            }
            $data['id'] = $id;
            $data['flag'] = $result;
            print json_encode($data);
        }
        if ($flag) {
            $this->renderPartial('lyric', array('id' => $id, 'model' => $songExtra), false, true);
        }
    } */

    public function actionCopyright() {
        $flag=true;
		$type =  Yii::app()->request->getParam('type');
		if(Yii::app()->getRequest()->ispostRequest){
			$flag = false;
		}
        if($flag){
			Yii::app()->user->setState('pageSize',20);
			$model = new AdminCopyrightModel('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['AdminCopyrightModel']))
                $model->attributes=$_GET['AdminCopyrightModel'];
			$model->setAttribute("type", $type);
            $adminUser = AdminAdminUserModel::model()->findByPk($this->userId);
            $cp = $adminUser->cp_id;
            if ($cp == 0 || $cp == '0' || !isset($cp)) {
                $cp = 1;
            }
            $model->setAttribute("added_by", $cp);
			$this->renderPartial('copyright',array(
	                                'model'=>$model,
                                    'type'=>$type
			),false,true);
			Yii::app()->user->setState('pageSize',Yii::app()->params['pageSize']);
		}
    }

    public function actionGetcopy(){
        $ids =  Yii::app()->request->getParam('ids');
        $cr = new CDbCriteria();
        $cr->condition = "id in ({$ids})";
        $copyright = AdminCopyrightModel::model()->findAll($cr);
        $return = array();
        foreach ($copyright as $item){
            $tmp = array();
            $tmp['id'] = $item['id'];
            $tmp['appendix_no'] = $item['appendix_no'];
            $tmp['start_date'] = $item['start_date'];
            $tmp['due_date'] = $item['due_date'];
            $return[] = $tmp;
        }
        print json_encode($return);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = AdminSongModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-song-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function moveFile($model, $filePath) {
        $saveFilePath = $model->getSongOriginPath($model->id);
        $saveDbPath = $model->getSongOriginPath($model->id, false);
        $fileSystem = new Filesystem();

        $ret = $fileSystem->copy($filePath, $saveFilePath);
        $model->source_path = $saveDbPath;
        $model->save();
        if ($this->userId == 14) {
            Yii::log("Copy file $filePath: $saveFilePath", "error");
        }
        $fileSystem->remove($filePath);
        if (!$ret) {
            Yii::log("Khong copy duoc file $filePath: $saveFilePath", "error");
        }
        return $saveDbPath;
    }
	public function actionGetCopyright()
	{
		$this->layout=false;
		$idArr = Yii::app()->request->getParam('ids','');
		$sql = "SELECT t1.*, t2.appendix_no
				FROM `song_copyright` t1
				LEFT JOIN copyright t2 ON t1.copryright_id = t2.id
				WHERE t1.song_id IN (".implode(',', $idArr).")
		";
		$result = Yii::app()->db->createCommand($sql)->queryAll();
		$data = array();
		foreach ($result as $key => $value){
			if($value['type']==0){
				$data["TQ_".$value['song_id']] = $value['appendix_no'];
			}else{
				$data["QLQ_".$value['song_id']] = $value['appendix_no'];
			}
		}
		echo CJSON::encode($data);
		Yii::app()->end();
	}
	public function actionApprovedAndApplySong()
	{
		ini_set('display_error', 0);
		try{
			$response= array(
					'error_code'=>0,
					'error_msg'=>'success'
			);
			$id = Yii::app()->request->getParam('id');
			$dataContentApprove = AdminContentApproveModel::model()->findByPk($id);
			$dataPost = CJSON::decode($dataContentApprove->data_change);
			$songId = $dataContentApprove->content_id;

			$valcopy0 = $dataPost['valcopy0'];
			$valcopy1 = $dataPost['valcopy1'];
			$cr = new CDbCriteria();
			$cr->condition = "t.song_id = ".$songId;
			$cr->with = array('copyr');
			$copyright = AdminSongCopyrightModel::model()->findAll($cr);

			$model =  AdminSongModel::model()->findByPk($songId);

			/*$songMeta = AdminSongMetadataModel::model()->findByPk($songId);
			if (empty($songMeta)) {
				$songMeta = new AdminSongMetadataModel();
				$songMeta->song_id = $songId;
			}*/

			if (isset($dataPost['AdminSongModel'])) {
				$data = array(
						'updated_time' => date("Y-m-d H:i:s"),
						'genre_id' => 0,
						'allow_download' => 1,
						'download_price' => Yii::app()->params['price']['songDownload'],
						'listen_price' => Yii::app()->params['price']['songListen']
				);

				// can edit price
				if($this->canEditPrice()) {
					unset($data['allow_download']);
					unset($data['download_price']);
					unset($data['listen_price']);
				}

				if (isset($dataPost['active_time']) && $dataPost['active_time'] != "") {
					$active_time = $dataPost['active_time'];
					if (strrpos($active_time, "-")) {
						$createdTime = explode("-", $active_time);
						$fromDate = explode("/", trim($createdTime[0]));
						$fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
						$fromDate .=" 00:00:00";
						$toDate = explode("/", trim($createdTime[1]));
						$toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
						$toDate .=" 23:59:59";
					} else {
						$fromDate = date("Y-m-d", strtotime($_GET['active_time'])) . " 00:00:00";
						$toDate = date("Y-m-d", strtotime($_GET['active_time'])) . " 23:59:59";
					}
					$model->setAttribute("active_totime", $toDate);
					$model->setAttribute("active_fromtime", $fromDate);
				}

				//check exits file
				$fileMp3 = _APP_PATH_ . DS . "data" . DS . "tmp" . DS . $dataPost['tmp_source_path'];
				if (file_exists($fileMp3)) {
					$sourcePath = $this->moveFile($model, $fileMp3);
					$data['approved_by'] = 0;
					$data['source_path'] = $sourcePath;
					//Recovert
					$dataPost['AdminSongModel']['status'] = AdminSongModel::NOT_CONVERT;
				}
				$songStatus = $dataPost['AdminSongModel']['status'];
				unset($dataPost['AdminSongModel']['status']);


				$model->attributes = $dataPost['AdminSongModel'];
				$model->setAttributes($data);
				//$songMeta->attributes = $dataPost['songMeta'];

				if ($model->save()) {
					// Copyright
					$cr = new CDbCriteria();
					$cr->condition = "song_id = {$model->id}";
					AdminSongCopyrightModel::model()->deleteAll($cr);
					if($valcopy0){
						$arr = explode(',', $valcopy0);
						foreach($arr as $copy){
							$sCopy = new AdminSongCopyrightModel();
							if(Yii::app()->request->getParam('cpy0')==$copy){
								$sCopy->setAttribute('active', 1);
							}
							$sCopy->setAttribute('song_id', $model->id);
							$sCopy->setAttribute('copryright_id', $copy);
							$sCopy->setAttribute('type', 0);
							$sCopy->setAttribute('from_date', $dataPost['start_date_'.$copy]);
							$sCopy->setAttribute('due_date', $dataPost['due_date_'.$copy]);
							$sCopy->setAttribute('copyright_method', $dataPost['copy_type_'.$copy]);
							$sCopy->save();
						}
					}
					if($valcopy1){
						$arr = explode(',', $valcopy1);
						foreach($arr as $copy){
							$sCopy = new AdminSongCopyrightModel();
							if($dataPost['cpy1']==$copy){
								$sCopy->setAttribute('active', 1);
							}
							$sCopy->setAttribute('song_id', $model->id);
							$sCopy->setAttribute('copryright_id', $copy);
							$sCopy->setAttribute('type', 1);
							$sCopy->setAttribute('from_date', $dataPost['start_date_'.$copy]);
							$sCopy->setAttribute('due_date', $dataPost['due_date_'.$copy]);
							$sCopy->setAttribute('copyright_method', $dataPost['copy_type_'.$copy]);
							$sCopy->save();
						}
					}

					//Update song meta
					//$songMeta->save();

					//UPDATE SONG STATUS
					$songList[] = $songId;
					if (isset($songStatus)) {
						switch ($songStatus) {
							case AdminSongModel::NOT_CONVERT:
								//Create Convert Song
								AdminConvertSongModel::model()->updateStatus($songList, AdminConvertSongModel::NOT_CONVERT);
								AdminSongModel::model()->setReconvert($songList);
								$model->sync_status = 0;
								$model->status=0;
								//Re sync song
								AdminSongModel::model()->setReSync($songList);

								break;
							case AdminSongModel::WAIT_APPROVED:
								AdminSongModel::model()->setWaitApproved($songList, $this->userId);
								break;
						}
					}

					//Update songCate
					AdminSongGenreModel::model()->updateSongCate($model->id, $dataPost['genre_ids']);

					//Update songartist
					AdminSongArtistModel::model()->updateArtist($model->id, $dataPost['artist_id_list']);
					$model->artist_name = AdminSongArtistModel::model()->getArtistBySong($model->id, 'name');
					$model->save();

					$dataContentApprove->status=1;
					$dataContentApprove->approved_id = Yii::app()->user->id;
					$dataContentApprove->approved_time = date('Y-m-d H:i:s');
					$dataContentApprove->save(false);
					//$this->redirect(array('view', 'id' => $model->id));
				}
			}
		}catch (Exception $e)
		{
			$response = array(
					'error_code'=>2,
					'error_msg'=>$e->getMessage()
			);
		}
		echo CJSON::encode($response);
		$this->layout=false;
		Yii::app()->end();
	}
}
