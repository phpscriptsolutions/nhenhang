<?php
@ini_set('max_execution_time', "600");
Yii::import("ext.xupload.models.XUploadForm");
class VideoController extends Controller
{
	public $type = AdminVideoModel::ALL;
	public $videoArtist = array();
	public $videoCate = null;
	public $liveVideoGenre = array();
	public $tags = array();
	
    public function init()
	{
		parent::init();
        $this->pageTitle = "Manage  Video ";
		$type = Yii::app()->request->getParam('AdminVideoModel');
		$this->type = (isset($type['status']) && $type['status']!="" )?$type['status']:AdminVideoModel::ALL;
		$this->liveVideoGenre = array(1140,1150,1138,1142);
	}

    public function actions()
    {
        return array(
            'upload'=>array(
                'class'=>'ext.xupload.actions.XUploadAction',
                'subfolderVar' => 'parent_id',
                'path' => _APP_PATH_.DS."data",
        		'alowType'=>'video/mp4'
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

		$model=new AdminVideoModel('search');
		$model->unsetAttributes();
		if(isset($_GET['AdminVideoModel'])){
			  $model->attributes=$_GET['AdminVideoModel'];

			  if(isset($_GET['AdminVideoModel']['created_time']) && $_GET['AdminVideoModel']['created_time'] != ""){
		  		  // Re setAttribute created time
			      $createdTime = $_GET['AdminVideoModel']['created_time'];
			      if(strrpos($createdTime, "-")){
			      	  $createdTime = explode("-", $createdTime);
			          $fromDate = explode("/", trim($createdTime[0]));
			          $fromDate = $fromDate[2]."-".str_pad($fromDate[0], 2, '0', STR_PAD_LEFT)."-".str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
			          $fromDate .=" 00:00:00";
			          $toDate = explode("/", trim($createdTime[1]));
			          $toDate = $toDate[2]."-".str_pad($toDate[0], 2, '0', STR_PAD_LEFT)."-".str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
			          $toDate .=" 23:59:59";
			          //$_GET['AdminVideoModel']['created_time'] = ">=$fromDate AND <=$toDate";
			      }else{
		      		  $fromDate = date("Y-m-d", strtotime($_GET['AdminVideoModel']['created_time']))." 00:00:00";
		      		  $toDate = date("Y-m-d", strtotime($_GET['AdminVideoModel']['created_time']))." 23:59:59";
			      }
			      $model->setAttribute("created_time", array(0=>$fromDate,1=>$toDate));
			  }

			  if(isset($_GET['AdminVideoModel']['created_by']) && $_GET['AdminVideoModel']['created_by']>0){
			  	$model->setAttribute('created_by', $_GET['AdminVideoModel']['created_by']);
			  }
		}
		/*
		if($this->type == AdminVideoModel::ALL){
			$model->setAttribute("status", "<>".AdminVideoModel::DELETED);
		}else{
			$model->setAttribute("status", $this->type);
		}
		*/


		$lyrics = 2;
		if (isset($_GET['lyrics'])) {
			$lyrics = $_GET['lyrics'];
		}
        $model->lyric = $lyrics;


		$model->setAttribute("status", $this->type);

		/* if($this->cpId != 0){
			$model->setAttribute("cp_id", $this->cpId);
		} */

		$categoryList = AdminGenreModel::model()->gettreelist(2,false,0,1,false,'all');
		$cpList = AdminCpModel::model()->findAll();
		$this->render('index',array(
			'model'=>$model,
			'categoryList'=>$categoryList,
			'cpList'=>$cpList,
            'pageSize'=>$pageSize,
            'lyric' => $lyrics
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$metaModel = AdminVideoMetadataModel::model()->findByAttributes(array("video_id"=>$id));
        $videoModel = $this->loadModel($id);
		$this->render('view',array(
			'model'=>$videoModel,
			'metaModel'=>$metaModel
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		throw new CHttpException(404,'Featured disable by admin');
		
		$model=new AdminVideoModel;

        $valcopy0 = Yii::app()->request->getParam('valcopy0');
        $valcopy1 = Yii::app()->request->getParam('valcopy1');

        $adminUser = AdminAdminUserModel::model()->findByPk($this->userId);
        $cp = $adminUser->cp_id;
        $supperAdmin = 0;
        if ($cp == 0 || $cp == '0' || !isset($cp) || $cp == 1 || $cp == '1') {
            $supperAdmin = 1;
        }

		if(isset($_POST['AdminVideoModel']))
		{

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

			$cpId = $this->cpId;
			if($cpId == 0){
				$cpId = $_POST['AdminVideoModel']['cp_id'];
			}
			$videoCode = AdminAdminUserModel::model()->getMaxContentCode($cpId,'video');

			if(!$videoCode){
				$_GET['msg'] = Yii::t('admin','Tài khoản đã hết quyền upload video');
	     		$this->forward("admin/error",true);
			}

			//check exits file
			$videoFile = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS .$_POST['tmp_source_path'];
			if(file_exists($videoFile)){

				if(isset($_POST['AdminVideoModel']['genre_id']) && in_array($_POST['AdminVideoModel']['genre_id'], $this->liveVideoGenre)){
					//is live video
					$priceDownload = (isset($_POST['AdminVideoModel']['download_price']) && $_POST['AdminVideoModel']['download_price']>0)?$_POST['AdminVideoModel']['download_price']:0;
					$priceListen = (isset($_POST['AdminVideoModel']['listen_price']) && $_POST['AdminVideoModel']['listen_price']>0)?$_POST['AdminVideoModel']['listen_price']:0;
				}else{
					$priceDownload = Yii::app()->params['price']['videoDownload'];
					$priceListen = Yii::app()->params['price']['videoListen'];
				}

				$data = array(
							'code'			=>	$videoCode,
							'created_by'	=>	$this->userId,
							'cp_id'			=>	$cpId,
							//'download_price'=>	Yii::app()->params['price']['videoDownload'],
							//'listen_price'	=>	Yii::app()->params['price']['videoListen'],
							'download_price'=>	$priceDownload,
							'listen_price'	=>	$priceListen,
							'created_time'	=>	date("Y-m-d H:i:s"),
							'updated_time'	=>	date("Y-m-d H:i:s"),
						);
				$model->attributes=$_POST['AdminVideoModel'];
				$model->setAttributes($data);

				if($model->save()){
                    // Copyright

                    if($valcopy0){
                        $arr = explode(',', $valcopy0);
                        foreach($arr as $copy){
                            $sCopy = new AdminVideoCopyrightModel();
                            if(Yii::app()->request->getParam('cpy0')==$copy){
                                $sCopy->setAttribute('active', 1);
                            }
                            $sCopy->setAttribute('video_id', $model->id);
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
                            $sCopy = new AdminVideoCopyrightModel();
                            if(Yii::app()->request->getParam('cpy1')==$copy){
                                $sCopy->setAttribute('active', 1);
                            }
                            $sCopy->setAttribute('video_id', $model->id);
                            $sCopy->setAttribute('copryright_id', $copy);
                            $sCopy->setAttribute('type', 1);
                            $sCopy->setAttribute('from_date', Yii::app()->request->getParam('start_date_'.$copy));
                            $sCopy->setAttribute('due_date', Yii::app()->request->getParam('due_date_'.$copy));
                            $sCopy->setAttribute('copyright_method', Yii::app()->request->getParam('copy_type_'.$copy));
                            $sCopy->save();
                        }
                    }

					$this->moveFile($model,$videoFile);

					//update videoartist
					AdminVideoArtistModel::model()->updateArtist($model->id, $_POST['artist_id_list']);
					$model->artist_name = AdminVideoArtistModel::model()->getArtistByVideo($model->id,'name');
					$model->save();

					$this->redirect(array('view','id'=>$model->id));
				}
			}else{
				$model->addError("file", Yii::t('admin','Chưa upload file'));
			}

		}
		$categoryList = AdminGenreModel::model()->gettreelist(2,false,0,1,false,'all');
        $uploadModel = new XUploadForm();
        $cpList = AdminCpModel::model()->findAll();
		$this->render('create',array(
			'model'=>$model,
		    'categoryList'=>$categoryList,
		    'uploadModel'=>$uploadModel,
			'cpList'=>$cpList,
            'supperAdmin' => $supperAdmin
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if(!is_numeric($id)) throw new CHttpException(404);

		/* if(!AdminVideoModel::model()->checkpermision($id,$this->cpId)){
			$_GET['msg'] = Yii::t('admin','Bạn không có quyền chỉnh sửa thông tin video này');
			$this->forward("admin/error",true);
		} */

        $adminUser = AdminAdminUserModel::model()->findByPk($this->userId);
        $cp = $adminUser->cp_id;
        $supperAdmin = 0;
        if ($cp == 0 || $cp == '0' || !isset($cp) || $cp == 1 || $cp == '1') {
            $supperAdmin = 1;
        }

		$model=$this->loadModel($id);
		if($model->videostatus->approve_status == AdminVideoStatusModel::REJECT || $model->videostatus->convert_status==AdminVideoStatusModel::NOT_CONVERT){
			$this->forward("video/view",true);
		}
		
		if(isset($_POST['AdminVideoModel']))
		{
			$data = array('updated_time'=>date("Y-m-d H:i:s"));

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
			$videoFile = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS .$_POST['tmp_source_path'];
			if(file_exists($videoFile)){
				$this->moveFile($model,$videoFile);
				$data['approved_by'] = 0;
				$_POST['AdminVideoModel']['status'] = AdminVideoModel::NOT_CONVERT;
			}
			$videoStatus = $_POST['AdminVideoModel']['status'];
			unset($_POST['AdminVideoModel']['status']);

			$model->attributes=$_POST['AdminVideoModel'];
			$model->setAttributes($data);
			$model->lyrics = $_POST['AdminVideoModel']['lyrics'];
			
			$removeAtt[] = 'source_path';
			$model->unsetAttributes($removeAtt);

			//Update avatar
			$oldAvatar = AdminVideoModel::model()->getAvatarPath($model->id,"s0");
			$changeAvatar = Yii::app()->request->getParam("AdminVideoModel");

			if(isset($changeAvatar['avatar']) && $changeAvatar['avatar'] != ""){
				$avatar = $changeAvatar['avatar'].".jpg";
				$sourceAvatar = AdminVideoModel::model()->getAvatarListPath($model->id).DS.$avatar;
				AvatarHelper::processAvatar($model, $sourceAvatar,"video");
			}else if(!file_exists($oldAvatar)){
				$avatar = "2.jpg";
				$sourceAvatar = AdminVideoModel::model()->getAvatarListPath($model->id).DS.$avatar;
				//$this->createAvatar($model,$sourceAvatar);
				AvatarHelper::processAvatar($model, $sourceAvatar);
			}

			// Truong hop upload anh
			if(isset($_FILES['avatar_upload'])){
				if($_FILES['avatar_upload']['type']== 'image/jpeg' ){
					$fileUpload = $_FILES['avatar_upload'];
					$tmpPath =  Yii::app()->params['storage']['baseStorage'].DS. "tmp".DS.time().".jpg";
					if($fileUpload["error"]==0){
						$ret = move_uploaded_file($_FILES['avatar_upload']['tmp_name'],$tmpPath);
						if($ret){
							AvatarHelper::processAvatar($model, $tmpPath,"video");
							@unlink($tmpPath);
						}
					}
				}
			}
			if($model->save()){
				//Update video meta
				//UPDATE SONG STATUS
				$videoList[] = $id;
				if(isset($videoStatus)){
					switch ($videoStatus){
						case AdminVideoModel::NOT_CONVERT:
							AdminVideoModel::model()->setReconvert($videoList);
							break;
						case AdminVideoModel::WAIT_APPROVED:
							AdminVideoModel::model()->setWaitApproved($videoList,$this->userId);
							break;
					}
				}

                //Update songCate
                AdminVideoGenreModel::model()->updateVideoCate($model->id, $_POST['genre_ids']);

				//update videoartist
				AdminVideoArtistModel::model()->updateArtist($model->id, $_POST['artist_id_list']);
				$model->artist_name = AdminVideoArtistModel::model()->getArtistByVideo($model->id,'name');
				$a = $model->save();
				
				//Update Tag
				TagContentModel::model()->updateTag($model->id,$_POST['tags'],"video");
				
				$this->redirect(array('view','id'=>$model->id));
			}

		}
		$categoryList = AdminGenreModel::model()->gettreelist(2,false,0,1,false,'all');
        $this->videoCate = AdminVideoGenreModel::model()->getCatByVideo($model->id);
        $uploadModel = new XUploadForm();
        $cpList = AdminCpModel::model()->findAll();

        $activetime[] = date("m/d/Y", strtotime($model->active_fromtime));
        $activetime[] = date("m/d/Y", strtotime($model->active_totime));
		$this->videoArtist = AdminVideoArtistModel::model()->getArtistByVideo($model->id);
		$this->tags = TagContentModel::model()->getTagByContent($id,"video");
		
		$this->render('update',array(
			'model'=>$model,
		    'categoryList'=>$categoryList,
		    'uploadModel'=>$uploadModel,
			'cpList'=>$cpList,
            'activetime'=>$activetime,
            'supperAdmin' => $supperAdmin
		));
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

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			AdminVideoModel::model()->setDelete($this->userId,$id);

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    /**
    * Delete all record Action.
    * @param string the action
    */
    public function actionDeleteAll(){
    	if(isset($_POST['all-item'])){
        	AdminVideoModel::model()->setDelete($this->userId);
        }else{
        	AdminVideoModel::model()->setDelete($this->userId,$_POST['cid']);
		}
        $this->redirect(array('index'));
	}

	public function actionConfirmDel()
	{
		$isAll = Yii::app()->request->getParam('all-item',0);
		$isPopup = Yii::app()->request->getParam('popup',null);
		$massList = Yii::app()->request->getParam('cid',0);
		$type = Yii::app()->request->getParam('type',AdminVideoModel::ALL);
		$reqsource = Yii::app()->request->getParam('reqsource','list');
		$flag=true;

		if(Yii::app()->getRequest()->ispostRequest && $isPopup == 1){
			$flag=false;
			$contentId = Yii::app()->request->getParam('conten_id');
			$contentAll = Yii::app()->request->getParam('is_all',0);

			if(intval($contentAll) == 0){
				$videoMass = explode(",", $contentId);
			}else{
				$videoMass = AdminVideoModel::model()->getListByStatus($type,$this->cpId);
				$videoMass = CHtml::listData($videoMass, "id","id");
			}
			if(!empty($videoMass)){
				$reason = Yii::app()->request->getParam('reason');
				AdminVideoModel::model()->setdelete($this->userId, $reason, $videoMass);
			}else{
				throw new CDbException(Yii::t('admin','Không có bản ghi nào được chọn'));
			}
		}

		if($flag){
			$massList = implode(",", $massList);
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('confirmDel',array(
                                        'massList'=>$massList,
                                        'isAll'=>$isAll,
                                        'reqsource'=>$reqsource,
			),
			false,
			true);
		}
	}

	public function actionMassUpdate()
	{
		$isAll = Yii::app()->request->getParam('all-item',0);
		$isPopup = Yii::app()->request->getParam('popup',null);
		$massList = Yii::app()->request->getParam('cid',0);
        $copy0 = Yii::app()->request->getParam('valcopy0', 0);
        $copy1 = Yii::app()->request->getParam('valcopy1', 0);

        $copyright0 = AdminCopyrightModel::model()->findAllByAttributes(array('type' => 0));
        $copyright1 = AdminCopyrightModel::model()->findAllByAttributes(array('type' => 1));

		$flag=true;
		if(Yii::app()->getRequest()->ispostRequest && $isPopup == 1){
			$flag=false;
			$contentId = Yii::app()->request->getParam('conten_id');
			$contentAll = Yii::app()->request->getParam('is_all',0);
			$dataInput = $_POST['video'];

            if ($copy0) {
                $cr = new CDbCriteria();
                $cr->condition = "video_id in ({$contentId}) and type=0";
                AdminVideoCopyrightModel::model()->deleteAll($cr);
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
                        $sCopy = new AdminVideoCopyrightModel();
                        $sCopy->setAttribute('video_id', $sid);
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
                $cr->condition = "video_id in ({$contentId}) and type=1";
                AdminVideoCopyrightModel::model()->deleteAll($cr);
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
                        $sCopy = new AdminVideoCopyrightModel();
                        $sCopy->setAttribute('video_id', $sid);
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

			if($contentAll == 0){
				$videoMass = explode(",", $contentId);
			}else{
				$videoMass = AdminVideoModel::model()->getListByStatus($type,$this->cpId);
				$videoMass = CHtml::listData($videoMass, "id","id");
			}

			if(!empty($dataInput)){
				AdminVideoModel::model()->massupdate($dataInput,$videoMass);

				// UPDATE FEATURE_VIDEO
				if($dataInput['feature'] && $dataInput['feature'] == 1){
					AdminFeatureVideoModel::model()->addList($this->userId,$videoMass);
				}
			}
		}
		if($flag){
			$massList = implode(",", $massList);
			$categoryList = AdminGenreModel::model()->gettreelist(2,false,0,1,false,'all');
			$artistList = AdminArtistModel::model()->findAll();
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('massUpdate',array(
                                        'categoryList'=>$categoryList,
                                        'massList'=>$massList,
                                        'isAll'=>$isAll,
										'artistList'=>$artistList,
                                        'copyright0' => $copyright0,
                                        'copyright1' => $copyright1,
			),
			false,
			true);
		}
	}

	public function actionApprovedAll()
	{
		if(Yii::app()->getRequest()->ispostRequest){
			$isAll = isset($_POST['all-item'])?$_POST['all-item']:null;
			$type = Yii::app()->request->getParam('type',AdminVideoModel::ALL);
			if($isAll){
				$videoMass = AdminVideoModel::model()->getListByStatus($type,$this->cpId);
				$videoMass = CHtml::listData($videoMass, "id","id");
			}else{
				$videoMass = $_POST['cid'];
				foreach($_POST['cid'] as $id){
                	$video=AdminVideoModel::model()->findByPk($id);
                	if(!isset($video->cmc_id) || empty($video->cmc_id) || $video->cmc_id == 0 ){
                		$avatar = "1.jpg";
                		$sourceAvatar = AdminVideoModel::model()->getAvatarListPath($id).DS.$avatar;
                		AvatarHelper::processAvatar($video, $sourceAvatar ,"video");
                	}                    
				}
			}
			AdminVideoModel::model()->setApproved($videoMass,$this->userId);
			$this->redirect(array('index','AdminVideoModel[status]'=>AdminVideoModel::WAIT_APPROVED));
		}
	}

	public function actionApproved($id)
	{

		$video = AdminVideoModel::model()->findByPk($id);
		if(empty($video)){
			throw new CHttpException(Yii::t('admin','Video không tồn tại'));
		}

		if($video->status == AdminVideoModel::ACTIVE){
			$_GET['error'] = Yii::t('admin','Video này đã được duyệt');
			$this->forward("admin/error");
		}

		if(Yii::app()->getRequest()->ispostRequest){
			$videoList[] = $id;
			if(isset($_POST['approved'])){
				AdminVideoModel::model()->setApproved($videoList,$this->userId);
				if(!isset($video->cmc_id) || empty($video->cmc_id) || $video->cmc_id == 0 ){
					$avatar = "1.jpg";
					$sourceAvatar = AdminVideoModel::model()->getAvatarListPath($id).DS.$avatar;
					AvatarHelper::processAvatar($video, $sourceAvatar ,"video");
				}				
			}
			if(isset($_POST['reject'])){
				$reason = Yii::app()->request->getParam('reason','Từ chối bài hát') ;
				AdminVideoModel::model()->setdelete($this->userId,$reason,$videoList);
			}

			$data = Yii::app()->session->get('videoApprovedList');
			$data[$id] = $id;
			Yii::app()->session->add('videoApprovedList',$data);

			// DELETE SESSION APPROVED TABLE
			AdminApproveSessionModel::model()->removeSession("video",$this->userId);

			// NEXT SONG
			$video = AdminVideoModel::model()->getListByStatus(AdminVideoModel::WAIT_APPROVED);
			foreach($video as $video){
				$sessionCheckout = AdminApproveSessionModel::model()->contentCheckout("video",$video['id']);
				if(empty($sessionCheckout) && !in_array($video['id'], Yii::app()->session['videoApprovedList'])){
					$videoId = $video['id'];
					break;
				}
			}
			if(isset($videoId)){
				$url = $this->createUrl("video/approved",array("id"=>$videoId));
			}else{
				$url = $this->createUrl('video/index',array('AdminVideoModel[status]'=>AdminVideoModel::ACTIVE));
			}

			$this->redirect($url);
		}

		$checkout=AdminApproveSessionModel::model()->contentCheckout("video",$id);
		if(!empty($checkout)){
			$userSession = AdminAdminUserModel::model()->findByPk($checkout['admin_id']);
		}else{
			$userSession = null;
			AdminApproveSessionModel::model()->addSession("video",$id,$this->userId);
		}
		$video = AdminVideoModel::model()->findByPk($id);
		$this->render("approved",array(
								'video'=>$video,
								'checkout'=>$checkout,
								'userSession'=>$userSession,
								));

	}

	public function actionReturnApproved()
	{
		Yii::app()->session['videoApprovedList'] = null;
		AdminApproveSessionModel::model()->removeSession("video",$this->userId);
		$url = $this->createUrl('video/index',array('AdminVideoModel[status]'=>AdminVideoModel::ACTIVE));
		$this->redirect($url);
	}

	public function actionListFavourite($id)
	{
		$favModel  = new AdminFavouriteVideoModel("search");
		$favModel->unsetAttributes();
		$favModel->setAttributes(array("video_id"=>$id));
		if(Yii::app()->request->isAjaxRequest){
			$this->renderPartial('listFavourite',array(
			'model'=>$favModel,));
		}else{
			$this->render('listFavourite',array(
			'model'=>$favModel,));
		}
	}

    public function actionReconvert()
    {
    	$isAll = Yii::app()->request->getParam('all-item',0);
		$massList = Yii::app()->request->getParam('cid',0);
		$type = Yii::app()->request->getParam('type',AdminVideoModel::ALL);

		if(intval($contentAll) == 0){
			$videoMass = $massList;
		}else{
			$videoMass = AdminVideoModel::model()->getListByStatus($type,$this->cpId);
			$videoMass = CHtml::listData($videoMass, "id","id");
		}
		AdminVideoModel::model()->setReconvert($videoMass);
		$url = $this->createUrl('video/index',array('AdminVideoModel[status]'=>$type));
		$this->redirect($url);
    }


	public function actionExport()
	{

		$isAll = Yii::app()->request->getParam('all-item',0);
		$massList = Yii::app()->request->getParam('cid',0);
		$type = Yii::app()->request->getParam('type',AdminVideoModel::ALL);

		$c = new CDbCriteria();
		if($isAll == 0){
			$c->condition = "t.id IN (".implode(",", $massList).")";
		}else{
			// Get list song by cpId and status
			if($this->cpId != 0){
				if($type != AdminVideoModel::ALL){
					$c->condition = "status = :STATUS AND cp_id=:CP";
					$c->params = array(":STATUS"=>$type,':CP'=>$this->cpId);
				}else{
					$c->condition = "cp_id=:CP";
					$c->params = array(':CP'=>$this->cpId);
				}
			}else{
				if($type != AdminVideoModel::ALL){
					$c->condition = "status = :STATUS";
					$c->params = array(":STATUS"=>$type);
				}
			}
		}
		$videoMass = AdminVideoModel::model()->with('cp')->findAll($c);

		$listVideo = array();
		$label = array(
				'name'=>Yii::t('admin','Video'),
				'code'=>Yii::t('admin','Mã'),
				'genre_id'=>Yii::t('admin','Thể loại'),
				'artist_name'=>Yii::t('admin','Ca sỹ'),
				'download_price'=>Yii::t('admin','Giá download'),
				'listen_price'=>Yii::t('admin','Giá nghe'),
				'created_time'=>Yii::t('admin','Ngày tạo'),
				);
		$i=0;
		foreach ($videoMass as $video){
			foreach ($label as $k=>$v){
				$listVideo[$i][$k] = $video[$k];
			}
			$listVideo[$i]['cp_name'] = isset($video->cp->name)?$video->cp->name:"" ;
			$i++;
		}
		$label['cp_name'] = Yii::t('admin','CP');
		$title = Yii::t('admin','Danh sách video');
		$excelObj = new ExcelExport($listVideo, $label, $title);
		$excelObj->export();
	}

	public function actionRestore()
	{
		$cid = Yii::app()->request->getParam('cid',array());
		$returnUrl = Yii::app()->request->getParam('return',null);
		AdminVideoModel::model()->restore($cid,$this->userId);
		if($returnUrl){
			$url = Yii::app()->createUrl("video/view",array('id'=>$cid[0]));
			$this->redirect($url);
		}
		$this->redirect(Yii::app()->createUrl("video/index",array("AdminVideoModel[status]"=>AdminVideoModel::DELETED)));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminVideoModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-video-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	protected function moveFile($model,$filePath)
	{
	   $savePath = AdminVideoModel::model()->getVideoOriginPath($model->id,false);
	   $destPath = AdminVideoModel::model()->getVideoOriginPath($model->id);
	   $fileSystem = new Filesystem();
	   Utils::makeDir(dirname($destPath));
	   try {
	   		$ret = $fileSystem->copy($filePath,$destPath,array('override'=>true));
	   		if(!$ret || !file_exists($destPath)){
	   			$error ="";
	   			if($this->userId == 14){
	   				$error =  "FROM: {$filePath} -- TO: {$destPath}\n";
	   			}
	   			throw new CHttpException(404,'Lỗi hệ thống không lưu được file. Vui lòng báo cho kỹ thuật để được hỗ trợ.'.$error);
	   		}
   		}catch (Exception $e){
   			$error ="";
   			if($this->userId == 14){
   				$error =  $e->getMessage();
   			}
	   		throw new CHttpException(404,'Lỗi hệ thống không lưu được file. Vui lòng báo cho kỹ thuật để được hỗ trợ.'.$error);
	   }


	   $model->source_path = $savePath;
	   $model->save();
	   $fileSystem->remove($filePath);
	}

	protected function createAvatar($model,$outputImg)
	{
		$fileSystem = new Filesystem();

		// Create folder by ID
		$fileSystem->mkdirs(AdminVideoModel::model()->getAvatarPath($model->id,"s0",true));
		$fileSystem->mkdirs(AdminVideoModel::model()->getAvatarPath($model->id,"s1",true));
		$fileSystem->mkdirs(AdminVideoModel::model()->getAvatarPath($model->id,"s2",true));
		$fileSystem->mkdirs(AdminVideoModel::model()->getAvatarPath($model->id,"s3",true));
		$fileSystem->mkdirs(AdminVideoModel::model()->getAvatarPath($model->id,"s4",true));
		$fileSystem->mkdirs(AdminVideoModel::model()->getAvatarPath($model->id,"s5",true));

		// Get link file by ID
		$savePathS0 = AdminVideoModel::model()->getAvatarPath($model->id,"s0");
		$savePathS1 = AdminVideoModel::model()->getAvatarPath($model->id,"s1");
		$savePathS2 = AdminVideoModel::model()->getAvatarPath($model->id,"s2");
		$savePathS3 = AdminVideoModel::model()->getAvatarPath($model->id,"s3");
		$savePathS4 = AdminVideoModel::model()->getAvatarPath($model->id,"s4");
		$savePathS5 = AdminVideoModel::model()->getAvatarPath($model->id,"s5");

	    if(file_exists($savePathS0)){
            $listFile[] = $savePathS0;
            $listFile[] = $savePathS1;
            $listFile[] = $savePathS2;
            $listFile[] = $savePathS3;
            $listFile[] = $savePathS4;
            $listFile[] = $savePathS5;
            $fileSystem->remove($listFile);
       }
       if(file_exists($outputImg)){
	       list($width, $height) = getimagesize($outputImg);
		   $imgCrop = new ImageCrop($outputImg, 0, 0, $width, $height);
	       $imgCrop->resizeRatio($savePathS0, 1024, 1024);
	       $imgCrop->resizeCrop($savePathS1, 640, 640);
	       $imgCrop->resizeCrop($savePathS2, 320, 320);
	       $imgCrop->resizeCrop($savePathS3, 150, 150);
	       $imgCrop->resizeCrop($savePathS4, 75, 75);
	       $imgCrop->resizeCrop($savePathS5, 50, 50);
       }

	}



        public function actionExclusive(){
		$cids = Yii::app()->request->getParam('cid');
		if(isset($_POST['all-item'])){
			 AdminVideoModel::model()->updateAll(array('is_exclusive'=>1));
		}else{
		  AdminVideoModel::model()->updateAll(array('is_exclusive'=>1),"id IN (".implode(',', $cids).")");
		}

		$this->redirect(array('index'));
	}
    public function actionUnexclusive(){
     	$cids = Yii::app()->request->getParam('cid');
        if(isset($_POST['all-item'])){
             AdminVideoModel::model()->updateAll(array('is_exclusive'=>0));
        }else{
          AdminVideoModel::model()->updateAll(array('is_exclusive'=>0),"id IN (".implode(',', $cids).")");
        }
        $this->redirect(array('index'));
    }

    public function actionNew(){
		$cids = Yii::app()->request->getParam('cid');
		if(isset($_POST['all-item'])){
			 AdminVideoModel::model()->updateAll(array('is_new'=>1));
		}else{
		  AdminVideoModel::model()->updateAll(array('is_new'=>1),"id IN (".implode(',', $cids).")");
		}

		$this->redirect(array('index'));
	}
    public function actionUnnew(){
     	$cids = Yii::app()->request->getParam('cid');
        if(isset($_POST['all-item'])){
             AdminVideoModel::model()->updateAll(array('is_new'=>0));
        }else{
          AdminVideoModel::model()->updateAll(array('is_new'=>0),"id IN (".implode(',', $cids).")");
        }
        $this->redirect(array('index'));
    }

    /* public function actionLyric(){
        $id = Yii::app()->request->getParam('id', '');
        $video = AdminVideoModel::model()->findByPk($id);
        $isPopup = Yii::app()->request->getParam('popup', 0);
        $videoExtra = AdminVideoExtraModel::model()->findByAttributes(array("video_id" => $id));
        if($videoExtra == null){
            $videoExtra = new AdminVideoExtraModel();
            $videoExtra->video_id = (int)$id;
            $videoExtra->old_id = $video->old_id;
            $videoExtra->description = '';
        }
        $lyrics = ($videoExtra) ? ($videoExtra->description) : "";
        $flag = true;
        if ($isPopup) {
            $flag = false;
            $lyrics = Yii::app()->request->getParam('description', '');
            if ($lyrics==" ")
                $lyrics = '';
            $videoExtra->description = $lyrics;
            $videoExtra->save();
            $result = 1;
            if($lyrics == ''){
                $result = 0;
            }
            $data['id'] = $id;
            $data['flag'] = $result;
            print json_encode($data);
        }
        if ($flag) {
            $this->renderPartial('lyric', array('id' => $id, 'model' => $videoExtra), false, true);
        }
    } */

    /**
     * content approved before apply
     * @author phuongnv
     */
    public function actionApprovedAndApplyVideo($id)
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
			$videoId = $dataContentApprove->content_id;

	    	$valcopy0 = $dataPost['valcopy0'];
	    	$valcopy1 = $dataPost['valcopy1'];
	    	$cr = new CDbCriteria();
	    	$cr->condition = "t.video_id = ".$videoId;
	    	$cr->with = array('copyr');
	    	$copyright = AdminVideoCopyrightModel::model()->findAll($cr);

	    	$adminUser = AdminAdminUserModel::model()->findByPk($this->userId);
	    	$cp = $adminUser->cp_id;
	    	$supperAdmin = 0;
	    	if ($cp == 0 || $cp == '0' || !isset($cp) || $cp == 1 || $cp == '1') {
	    		$supperAdmin = 1;
	    	}

	    	$model=$this->loadModel($videoId);

	    	if(isset($dataPost['AdminVideoModel']))
	    	{
	    		$data = array('updated_time'=>date("Y-m-d H:i:s"));

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
	    				$fromDate = date("Y-m-d", strtotime($dataPost['active_time'])) . " 00:00:00";
	    				$toDate = date("Y-m-d", strtotime($dataPost['active_time'])) . " 23:59:59";
	    			}
	    			$model->setAttribute("active_totime", $toDate);
	    			$model->setAttribute("active_fromtime", $fromDate);
	    		}

	    		//check exits file
	    		$videoFile = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS .$dataPost['tmp_source_path'];
	    		if(file_exists($videoFile)){
	    			$this->moveFile($model,$videoFile);
	    			$data['approved_by'] = 0;
	    			$dataPost['AdminVideoModel']['status'] = AdminVideoModel::NOT_CONVERT;
	    		}
	    		$videoStatus = $dataPost['AdminVideoModel']['status'];
	    		unset($dataPost['AdminVideoModel']['status']);

	    		$model->attributes=$dataPost['AdminVideoModel'];
	    		$model->setAttributes($data);
	    		$removeAtt[] = 'source_path';
	    		$model->unsetAttributes($removeAtt);

	    		//Update avatar
	    		/*$oldAvatar = AdminVideoModel::model()->getAvatarPath($model->id,"s0");
	    		$changeAvatar = $dataPost["AdminVideoModel"];

	    		 if(isset($changeAvatar['avatar']) && $changeAvatar['avatar'] != ""){
	    			$avatar = $changeAvatar['avatar'].".jpg";
	    			$sourceAvatar = AdminVideoModel::model()->getAvatarListPath($model->id).DS.$avatar;
	    			AvatarHelper::processAvatar($model, $sourceAvatar,"video");
	    		}else if(!file_exists($oldAvatar)){
	    			$avatar = "2.jpg";
	    			$sourceAvatar = AdminVideoModel::model()->getAvatarListPath($model->id).DS.$avatar;
	    			//$this->createAvatar($model,$sourceAvatar);
	    			AvatarHelper::processAvatar($model, $sourceAvatar);
	    		} */

	    		if($model->save()){
	    			//Update video meta
	    			//UPDATE SONG STATUS
	    			$videoList[] = $videoId;
	    			if(isset($videoStatus)){
	    				switch ($videoStatus){
	    					case AdminVideoModel::NOT_CONVERT:
	    						AdminVideoModel::model()->setReconvert($videoList);
	    						break;
	    					case AdminVideoModel::WAIT_APPROVED:
	    						AdminVideoModel::model()->setWaitApproved($videoList,$this->userId);
	    						break;
	    				}
	    			}


	    			//update videoartist
	    			AdminVideoArtistModel::model()->updateArtist($model->id, $dataPost['artist_id_list']);
	    			$model->artist_name = AdminVideoArtistModel::model()->getArtistByVideo($model->id,'name');
	    			$model->save();

	    			$dataContentApprove->status=1;
	    			$dataContentApprove->approved_id = Yii::app()->user->id;
	    			$dataContentApprove->approved_time = date('Y-m-d H:i:s');
	    			$dataContentApprove->save(false);

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
    }

}
