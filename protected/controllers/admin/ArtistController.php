<?php
Yii::import("ext.xupload.models.XUploadForm");
class ArtistController extends Controller
{
	public $coverWidth = 1190;
	public $coverHeight = 350;
	
	public function init()
	{
		parent::init();
		$this->pageTitle = "Manage  Artist";
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
		$model=new AdminArtistModel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminArtistModel']))
		  $model->attributes=$_GET['AdminArtistModel'];

        $joinRbt = "";
        if(!empty($_GET['has_rbt'])){
            $joinRbt = intval($_GET['has_rbt']);
        }
		$model->setAttribute("status", "<>".AdminArtistModel::DELETE);
		
		$description="";
		if (isset($_GET['description']) && $_GET['description']>0) {
			$description = $_GET['description'];
		}
		$categoryList = AdminGenreModel::model()->gettreelist(2);
		$this->render('index',array(
			'model'=>$model,
            'pageSize'=>$pageSize,
            'joinRbt' => $joinRbt,
			'description'=>$description,
			'categoryList'=>$categoryList
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$crit = new CDbCriteria();
		$crit->condition = 'artist_id=:artist_id';
		$crit->params = array(':artist_id'=>$id);
		$metaModel = ArtistMetadataModel::model()->findAll($crit);
		$dataProvider = new CActiveDataProvider($metaModel);
		//$metaModel = AdminArtistMetadataModel::model()->findByPk($id);
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'metaModel'=>$metaModel
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new AdminArtistModel;
		$artistMeta = new AdminArtistMetadataModel;

		if(isset($_POST['AdminArtistModel']))
		{
			$model->attributes=$_POST['AdminArtistModel'];
			$model->setAttributes(array('created_time'=>date("Y-m-d H:i:s"),'updated_time'=>date("Y-m-d H:i:s")));
			$fileAvatar = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS .$_POST['AdminArtistModel']['source_path'];
			if(!file_exists($fileAvatar)){
				$model->addError("file", "Chưa có ảnh đại diện");
			}else{
				if($model->save()){
				    AvatarHelper::processAvatar($model, $fileAvatar);
					$artistMeta->attributes = $_POST['artistMeta'];
					$artistMeta->save();
					
					//upload file cover
					if ($_FILES['file']['size'] > 0) {
						$coverPath = $this->uploadFile($_FILES['file'], $model);
						if(!$coverPath){
							$model->addError('cover', 'Cover should more '.$this->coverWidth."x".$this->coverHeight);
							goto cIteratorExit;
						}
					}
					
				 	$this->redirect(array('view','id'=>$model->id));
				}
			}
		}

		cIteratorExit:
        $categoryList = AdminGenreModel::model()->gettreelist(2);
        $uploadModel = new XUploadForm();
		$this->render('create',array(
			'model'=>$model,
            'categoryList'=>$categoryList,
            'uploadModel'=>$uploadModel,
			'artistMeta'=>$artistMeta
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
		//$artistMeta = AdminArtistMetadataModel::model()->findByPk($id);
		$crit = new CDbCriteria();
		$crit->condition = 'artist_id=:artist_id';
		$crit->params = array(':artist_id'=>$id);
		$artistMeta = ArtistMetadataModel::model()->findAll($crit);

		/*if(empty($artistMeta)){
			$artistMeta = new AdminArtistMetadataModel;
			$artistMeta->artist_id = $id;
		}*/

		if(isset($_POST['AdminArtistModel']))
		{
			$model->attributes=$_POST['AdminArtistModel'];
			$model->setAttributes(array(
									'updated_time'=>date("Y-m-d H:i:s"),
									'updated_by'=>$this->userId,
									'created_by'=>$this->userId,
									));

			if($model->save()){
				$fileAvatar = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS .$_POST['AdminArtistModel']['source_path'];
				if(file_exists($fileAvatar)){
				    AvatarHelper::processAvatar($model, $fileAvatar);
				}
				//upload file cover
				if ($_FILES['file']['size'] > 0) {
					$coverPath = $this->uploadFile($_FILES['file'], $model);
					if(!$coverPath){
						$model->addError('cover', 'Cover should more '.$this->coverWidth."x".$this->coverHeight);
						goto cIteratorExit;
					}
				}
				
				//Update status
				//AdminArtistModel::model()->updateStatus($id,$_POST['AdminArtistModel']['status']);
				ArtistMetadataModel::model()->updateData($model->id,$_POST['artistMeta']);
				/*$artistMeta->attributes = $_POST['artistMeta'];
				$artistMeta->save();*/
				$this->redirect(array('view','id'=>$model->id));
			}

		}
		cIteratorExit:
        $categoryList = AdminGenreModel::model()->gettreelist(2);
        $uploadModel = new XUploadForm();

		$this->render('update',array(
			'model'=>$model,
            'categoryList'=>$categoryList,
            'uploadModel'=>$uploadModel,
            'artistMeta'=>$artistMeta
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
		$artistMeta = AdminArtistMetadataModel::model()->findByPk($id);

		if(empty($artistMeta)){
			$artistMeta = new AdminArtistMetadataModel;
		}

		if(isset($_POST['AdminArtistModel']))
		{
			$model=new AdminArtistModel;
			$model->attributes=$_POST['AdminArtistModel'];
			$model->setAttributes(array('updated_time'=>date("Y-m-d H:i:s")));

			$fileAvatar = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS .$_POST['AdminArtistModel']['source_path'];
			if(!file_exists($fileAvatar)){
				$model->addError("File", "Chưa có ảnh đại diện ca sỹ");
				$data = $model;
			}else{
				if($model->save()){
				    AvatarHelper::processAvatar($model, $fileAvatar);
					$artistMeta = new AdminArtistMetadataModel;
					$artistMeta->artist_id = $model->id;
					$artistMeta->attributes = $_POST['artistMeta'];
					$artistMeta->save();

					$this->redirect(array('view','id'=>$model->id));
				}
			}
		}

        $categoryList = AdminGenreModel::model()->gettreelist(2);
        $uploadModel = new XUploadForm();
        $data->unsetAttributes(array('id'));
		$this->render('copy',array(
			'model'=>$data,
            'categoryList'=>$categoryList,
            'uploadModel'=>$uploadModel,
			'artistMeta'=>$artistMeta
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
			//$this->loadModel($id)->delete();
			$model = $this->loadModel($id);
			$model->status = AdminArtistModel::DELETE;
			$model->updated_time = new CDbExpression("NOW()");
			$model->updated_by = $this->userId;
			$model->save();

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
		$c = new CDbCriteria();

		if(!isset($_POST['all-item'])){
			 $c->condition = "id IN (".implode(",", $_POST['cid']).")";
		}
		$attributes['status'] = 3;
        AdminArtistModel::model()->updateAll($attributes,$c);

		$this->redirect(array('index'));
	}



	public function actionPopupList()
	{
		$flag=true;
		$id_field =  Yii::app()->request->getParam('id_field');
		$name_field =  Yii::app()->request->getParam('name_field');
		$id_dialog =  Yii::app()->request->getParam('id_dialog','jobDialog');
		if(Yii::app()->getRequest()->ispostRequest){
			$flag = false;
		}

		if($flag){
			Yii::app()->user->setState('pageSize',20);
			$model = new AdminArtistModel('search');
			$model->unsetAttributes();  // clear any default values
			if(isset($_GET['AdminArtistModel']))
                $model->attributes=$_GET['AdminArtistModel'];
			$model->setAttribute("status", ArtistModel::ACTIVE);

			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$this->renderPartial('popupList',array(
	                                'model'=>$model,
			                        'id_field'=>$id_field,
			                        'name_field'=>$name_field,
			                        'id_dialog'=>$id_dialog,
			),false,true);
			Yii::app()->user->setState('pageSize',Yii::app()->params['pageSize']);
		}
	}

	public function actionSonglist($id)
	{
		$artistModel = $this->loadModel($id);
		$pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
		Yii::app()->user->setState('pageSize',$pageSize);
		$model=new AdminSongModel('search');
		$model->unsetAttributes();

		if(isset($_GET['AdminSongModel'])){
			$model->attributes=$_GET['AdminSongModel'];
			if(isset($_GET['AdminSongModel']['created_time']) && $_GET['AdminSongModel']['created_time'] !=""){
				// Re-setAttribute create datetime
			    $createdTime = $_GET['AdminSongModel']['created_time'];
			    if(strrpos($createdTime, "-")){
			    	$createdTime = explode("-", $createdTime);
			        $fromDate = explode("/", trim($createdTime[0]));
			        $fromDate = $fromDate[2]."-".str_pad($fromDate[0], 2, '0', STR_PAD_LEFT)."-".str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
			        $fromDate .=" 00:00:00";
			        $toDate = explode("/", trim($createdTime[1]));
			        $toDate = $toDate[2]."-".str_pad($toDate[0], 2, '0', STR_PAD_LEFT)."-".str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
			        $toDate .=" 23:59:59";
			}else{
					$fromDate = date("Y-m-d", strtotime($_GET['AdminSongModel']['created_time']))." 00:00:00";
			      	$toDate = date("Y-m-d", strtotime($_GET['AdminSongModel']['created_time']))." 23:59:59";
			      }
			      $model->setAttribute("created_time", array(0=>$fromDate,1=>$toDate));
		  	}
		}

		$model->setAttribute('artist_id', "=".$id);
		//$model->setAttribute("status", AdminSongModel::ACTIVE);

		$categoryList = AdminGenreModel::model()->gettreelist(2);
		$cpList = AdminCpModel::model()->findAll();

		$this->render('songlist',array(
			'model'=>$model,
			'artistId'=>$id,
			'artistName'=>$artistModel->name,
		    'categoryList'=>$categoryList,
		    'cpList'=>$cpList,
            'pageSize'=>$pageSize
		));

	}
	public function actionVideolist($id)
	{
		$artistModel = $this->loadModel($id);
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
		}
		//$model->setAttribute("status", AdminVideoModel::ACTIVE);
		$model->setAttribute('artist_id', "=".$id);

		if($this->cpId != 0){
			$model->setAttribute("cp_id", $this->cpId);
		}

		$categoryList = AdminGenreModel::model()->gettreelist(2);
		$cpList = AdminCpModel::model()->findAll();
		$this->render('videolist',array(
			'model'=>$model,
			'artistId'=>$id,
			'artistName'=>$artistModel->name,
			'categoryList'=>$categoryList,
			'cpList'=>$cpList,
            'pageSize'=>$pageSize
		));
	}

	public function actionAlbumlist($id)
	{
		$artistModel = $this->loadModel($id);
		$pageSize = Yii::app()->request->getParam('pageSize',Yii::app()->params['pageSize']);
		Yii::app()->user->setState('pageSize',$pageSize);

		$model=new AdminAlbumModel('search');
		$model->unsetAttributes();  // clear any default values
		//$model->setAttribute("status", AdminAlbumModel::ACTIVE);
		$model->setAttribute('artist_id', "=".$id);

		$categoryList = AdminGenreModel::model()->gettreelist(2);
		$this->render('albumlist',array(
			'model'=>$model,
			'artistId'=>$id,
			'artistName'=>$artistModel->name,
            'pageSize'=>$pageSize,
			'categoryList'=>$categoryList,
		));
	}

	public function actionMerge()
	{
		$org_id = Yii::app()->request->getParam('org_id');
		// Kiem tra ton tai album
		/* $sql = "SELECT COUNT(*) AS total FROM album WHERE artist_id = '{$org_id}'";
		$data = Yii::app()->db->createCommand($sql)->queryRow();
		if($data['total']>0){
			echo "fail";
			Yii::app()->end();
		} */

		$change_id = Yii::app()->request->getParam('change_id');
		$change_id = explode(",", $change_id);
		for($i=0;$i<count($change_id);$i++){
			if($change_id[$i]==$org_id){
				unset($change_id[$i]);
			}
		}
		sort($change_id);
		if(empty($change_id)){
			Yii::app()->end();
		}
		foreach($change_id as $artist_id){
			$artistModel = AdminArtistModel::model()->findByPk($artist_id);
			$artist_name = $artistModel->name;
			$artist_name = addslashes($artist_name);
			//Update song_artist
			$sql = "INSERT INTO song_artist (SELECT song_id, '{$artist_id}','{$artist_name}',song_status FROM song_artist WHERE artist_id = '{$org_id}' AND song_id NOT IN (SELECT song_id FROM song_artist WHERE artist_id='{$artist_id}'))" ;
			Yii::app()->db->createCommand($sql)->execute();

			//Update video_artist
			$sql = "INSERT INTO video_artist (SELECT video_id, '{$artist_id}','{$artist_name}',video_status FROM video_artist WHERE artist_id = '{$org_id}'  AND video_id NOT IN (SELECT video_id FROM video_artist WHERE artist_id='{$artist_id}'))" ;
			Yii::app()->db->createCommand($sql)->execute();

			//Update album_artist
			$sql = "INSERT INTO album_artist (SELECT album_id, '{$artist_id}','{$artist_name}',album_status FROM album_artist WHERE artist_id = '{$org_id}'  AND album_id NOT IN (SELECT album_id FROM album_artist WHERE artist_id='{$artist_id}'))" ;
			Yii::app()->db->createCommand($sql)->execute();
		}

		//Remove old_artist
		$sql = "DELETE FROM song_artist WHERE artist_id = '{$org_id}'" ;
		Yii::app()->db->createCommand($sql)->execute();
		$sql = "DELETE FROM video_artist WHERE artist_id = '{$org_id}'" ;
		Yii::app()->db->createCommand($sql)->execute();

		$sql = "DELETE FROM album_artist WHERE artist_id = '{$org_id}'" ;
		Yii::app()->db->createCommand($sql)->execute();

		// Update album, rbt, statistic_song, statistic_video cho 1 ca sy trong ds thay the
		//Update Album
		/*$album_artist_id = Yii::app()->request->getParam('album_artist_id');
		$artist_album_name = AdminArtistModel::model()->findByPk($album_artist_id)->name;
		$sql = "UPDATE album SET artist_id = '{$album_artist_id}', artist_name='{$artist_album_name}' WHERE artist_id = '{$org_id}'";
		Yii::app()->db->createCommand($sql)->execute();
		*/

		//Update Rbt
		$sql = "UPDATE rbt SET artist_id = '{$artist_id}', artist_name='{$artist_name}' WHERE artist_id = '{$org_id}'";
		Yii::app()->db->createCommand($sql)->execute();

		//Update statistic_song
		$sql = "UPDATE statistic_song SET artist_id = '{$artist_id}' WHERE artist_id = '{$org_id}'";
		Yii::app()->db->createCommand($sql)->execute();

		//Update statistic_video
		$sql = "UPDATE statistic_video SET artist_id = '{$artist_id}' WHERE artist_id = '{$org_id}'";
		Yii::app()->db->createCommand($sql)->execute();

		// Xoa ca sy
		$sql = "DELETE FROM artist WHERE id = '{$org_id}'";
		Yii::app()->db->createCommand($sql)->execute();

		echo "success";
		Yii::app()->end();
	}

	public function actionAutoComplete()
	{
		$this->layout = false;
		$q = Yii::app()->request->getParam('q');
		if (!$q) return;
		$c = new CDbCriteria();
		$c->condition = "name LIKE :NAME AND status = ".ArtistModel::ACTIVE;
		$c->params = array(':NAME'=>'%'.$q.'%');
		$listArtist = AdminArtistModel::model()->findAll($c);
		foreach ($listArtist as $artist){
			$name = trim($artist->name);
			$id=$artist->id;
			echo "$name|$id\n";
		}
		Yii::app()->end();
	}

	public function actionGetByname()
	{
		header("Content-type: application/json");
		$name = Yii::app()->request->getParam('name',false);
		$org_id = Yii::app()->request->getParam('org_id',false);

		if($name){
			$c = new CDbCriteria();
			$c->condition = "name LIKE :NAME AND status = ".ArtistModel::ACTIVE;
			$c->params = array(':NAME'=>$name.'%');
			if($org_id){
				$c->addCondition("id <> $org_id");
			}
			$listArtist = AdminArtistModel::model()->findAll($c);
			$listArtist = CHtml::listData($listArtist, "id", "name");
		}
		echo json_encode($listArtist);
		Yii::app()->end();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=AdminArtistModel::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-artist-model-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * upload file
	 */
	protected function uploadFile($file, $model) {
		$coverPath = "";
		$fileSystem = new Filesystem();
		if (isset($file['error']) && $file['error'] == 0) {
			$ext = explode('.', $file['name']);
			$extFile = $ext[count($ext) - 1];
			$id = $model->id;
			$srcFileName = $id . time() . "." . $extFile;
			$tmpPath = Yii::app()->getRuntimePath();
			
			$fileDesPath = $tmpPath . DIRECTORY_SEPARATOR . $srcFileName;
			try {
				if (move_uploaded_file($file['tmp_name'], $fileDesPath)) {
					list($width, $height) = getimagesize($fileDesPath);
					if($width < $this->coverWidth || $height < $this->coverHeight){
						return false;
					}
					$imgCrop = new ImageCrop($fileDesPath, 0, 0, $width, $height);
					$coverPath = $model->getCoverPath($model->id);
					Utils::makeDir(dirname($coverPath));
					$imgCrop->resizeCrop($coverPath, $this->coverWidth, $this->coverHeight, 100);
	
					unlink($fileDesPath);
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
		return $coverPath;
	}
	
}
