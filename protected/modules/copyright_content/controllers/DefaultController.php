<?php
class DefaultController extends Controller {
	public function init() {
		$this->pageTitle = "Quản lý File upload";
		parent::init ();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$model = new CopyrightInputFileModel ( 'search' );
		$model->unsetAttributes (); // clear any default values

		$this->render ( 'index', array (
				'model' => $model
		) );
	}

	/**
	 * Displays a particular model.
	 *
	 * @param integer $id
	 *        	the ID of the model to be displayed
	 */
	public function actionView($id) {
		$count = CopyrightInputContentModel::model()->getCountSong($id);
		$page = new CPagination($count);
		$page->pageSize = 100;

		$songs = CopyrightInputContentModel::model()->getListSong($id, $page->getLimit(), $page->getOffset());

		/* $inputModel = new CopyrightSongInputModel("search");
		$inputModel->unsetAttributes ();
		$inputModel->setAttribute("input_file", $id); */
		$this->render ( 'view', array (
				'model' => $this->loadModel ( $id ),
				'songs' => $songs,
				'page' => $page,
		) );
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new CopyrightInputFileModel();

		if (Yii::app ()->request->isPostRequest) {
                        $content_type = Yii::app()->request->getParam('content_type', null);
                        if(!isset($content_type))
                            $model->addError ( "name", "Chưa chọn loại nội dung content_type!" );
                        else 
                            if (! $_FILES ['file'] ['error']) {
				$ext = Utils::getExtension ( $_FILES ['file'] ['name'] );
				$type = $_FILES ['file'] ['type'];
				if ($ext == 'xls' && ($type == 'application/xls' || $type=='application/vnd.ms-excel')) {
					$storage = Yii::app ()->params ['storage'] ['baseStorage'] . "uploads" . DS . "copyright";
					//$storage="E:/";
					Utils::makeDir ( $storage );
					$fileName = $_FILES ['file'] ['name'];
					if (move_uploaded_file ( $_FILES ['file'] ['tmp_name'], $storage . DS . $fileName )) {
						$transaction = Yii::app ()->db->beginTransaction ();
						try {
							$model->file_name = $fileName;
                                                        $model->content_type = $content_type;
							$model->created_by = $this->userId;
							$model->created_time = new CDbExpression ( "NOW()" );
							if ($model->save ()) {
								$file_path = $storage . DS . $fileName;
								$data = new ExcelReader ( $file_path );
								$start_row = 2;
								echo $limit_row = $data->rowcount ();
								$cell_stt = "A";
								$cell_content_id = "B";
								$cell_name = "C";
								$cell_artist = "D";
								$cell_copyright_code = "E";
								$cell_copyright_id = "F";
								$arrayVal = array ();
								for($i = $start_row; $i < $limit_row; $i ++) {
									if ($data->val ( $i, $cell_name ) == "" || $data->val ( $i, $cell_artist ) == "" || $data->val ( $i, $cell_copyright_code ) == "") {
										continue;
									}
									$stt = $model->my_encoding ( $data->val ( $i, $cell_stt ) );
									$contentId = $model->my_encoding ($data->val($i, $cell_content_id));
									$name = $model->my_encoding ( $data->val ( $i, $cell_name ) );
									$artist = $model->my_encoding ( $data->val ( $i, $cell_artist ) );
									$ccode = $model->my_encoding ( $data->val ( $i, $cell_copyright_code ) );
									$ccid = $model->my_encoding ( $data->val ( $i, $cell_copyright_id ) );
									$arrayVal [] = "('$stt','$contentId','$name','$artist','$ccode',$ccid,'{$model->id}')";
								}
								/**
								 * Start insert here: split 200 line per command
								 */
								$arrs = array_chunk ( $arrayVal, 200 );
								foreach ( $arrs as $arr ) {
									$vals = implode ( ",", $arr );
									$sql = "INSERT INTO copyright_input_content (`stt`,`content_id`,`name`,`artist`,`copyright_code`,`copyright_id`,`input_file`) VALUES $vals";
									$command = Yii::app ()->db->createCommand ( $sql );
									$command->execute ();
								}

								$transaction->commit ();
								$this->redirect ( array (
										'view',
										'id' => $model->id
								) );
							} else {
								$transaction->rollback ();
							}
						} catch ( Exception $e ) {
							$transaction->rollback ();
							$model->addError ( "exception", $e->getMessage () );
						}
					} else {
						$model->addError ( "name", "Không upload được file vào thư mục:" . $storage . DS . $fileName );
					}
				} else {
					$model->addError ( "name", "Chỉ upload file xls" );
				}
			} else {
				$model->addError ( "name", "Chưa upload file" );
                                $model->content_type = $content_type;
			}
		}

		$this->render ( 'create', array (
				'model' => $model
		) );
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 *
	 * @param integer $id
	 *        	the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		//throw new CHttpException ( 404, 'The requested page does not exist.' );

		$model = CopyrightInputContentModel::model()->findByPk($id)->delete();
		$this->redirect(Yii::app()->createUrl('/copyright_content/default/view', array('id'=>$_GET['fileId'])));
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
	}

	public function actionAjaxMap()
	{
		Yii::import("application.models.web.*");
		$fileId = Yii::app()->request->getParam('fileId');
		$offset = Yii::app()->request->getParam('offset',0);

		$return = new stdClass();
		$return->error = 0;
		$return->errorMessage= "";
		$return->success = 0;
		$return->data = array();
                
		try {
            $c = new CDbCriteria();
			$c->condition = "id=:FID";
			$c->params = array(":FID"=>$fileId);
			$fileInfo = CopyrightInputFileModel::model()->find($c);
                        if(isset($fileInfo)){
                            $content_type = $fileInfo->content_type;
                            
                            $c = new CDbCriteria();
                            $c->condition = "input_file=:FID";
                            $c->params = array(":FID"=>$fileId);
                            $c->order = "id ASC";
                            $c->limit = 1;
                            $c->offset = $offset;
                            $item = CopyrightInputContentModel::model()->find($c);
							$Log = new KLogger("log_map", KLogger::INFO);
                            if(empty($item)){
                                    $return->success = 1;
                            }else{
                                    $inputId = $item->id;
                                    $countMapSong = $countMapVideo= 0;
                                    
                                    if($content_type == 'song'){
                                        $cr = new CDbCriteria();
                                        $cr->condition = "LOWER(TRIM(name)) LIKE :NAME AND cp_id=1";
                                        $cr->params = array(":NAME"=>strtolower(trim($item->name))."%");
                                        $items = SongModel::model()->findAll($cr);

                                        foreach ($items as $song){
                                                if(isset($song['cp_id']) && $song['cp_id']==1){
                                                        $songName = strtoupper(trim($song['name']));
                                                        $songArtist = strtoupper(trim($song['artist_name']));
                                                        $songArtist = Common::strNormal($songArtist);
                                                        $itemName = strtoupper(trim($item->name));
                                                        $itemArtist = strtoupper(trim($item->artist));
                                                        $itemArtist = Common::strNormal($itemArtist);
                                                        if($item->id==574692){
                                                        	$s = strlen($songName) - strlen($itemName);
                                                        	$d = strrpos($songArtist, $itemArtist);
                                                        	$Log->LogInfo("songName: $songName | itemName:$itemName |{$s}|| songArtist:$songArtist | itemArtist:$itemArtist ".json_encode($d),false);
                                                        }
                                                        if(strlen($songName) - strlen($itemName)>3){
                                                                continue;
                                                        }
                                                        if(strrpos($songArtist, $itemArtist)===false){
                                                                continue;
                                                        }


                                                        $sql = "
                                                                    INSERT INTO copyright_content_map(input_id,content_id,content_name,content_artist,content_type)
                                                                    VALUES(:INPUT_ID,:CONTENT_ID,:CONTENT_NAME,:CONTENT_ARTIST,'song')
                                                                    ON DUPLICATE KEY UPDATE content_name=:CONTENT_NAME_2, content_artist=:CONTENT_ARTIST_2
                                                                ";

                                                        $contentId = $song['id'];
                                                        $contentName = $song['name'];
                                                        $contentArtist = $song['artist_name'];

                                                        $dataCmd = Yii::app()->db->createCommand($sql);
                                                        $dataCmd->bindParam(":INPUT_ID", $inputId, PDO::PARAM_INT);
                                                        $dataCmd->bindParam(":CONTENT_ID", $contentId, PDO::PARAM_INT);
                                                        $dataCmd->bindParam(":CONTENT_NAME", $contentName, PDO::PARAM_STR);
                                                        $dataCmd->bindParam(":CONTENT_ARTIST", $contentArtist, PDO::PARAM_STR);
                                                        $dataCmd->bindParam(":CONTENT_NAME_2", $contentName, PDO::PARAM_STR);
                                                        $dataCmd->bindParam(":CONTENT_ARTIST_2", $contentArtist, PDO::PARAM_STR);
                                                        $dataCmd->execute();
                                                        $countMapSong++;
                                                }
                                        }
                                        /* $rs = SearchHelper::getInstance()->searchCustom($item->name,10);
                                        $groups = $rs->grouped->type->groups;
                                        foreach ($groups as $group) {
                                                $doclist = $group->doclist;

                                                if("song"==$group->groupValue){
                                                        $countSong = $doclist->numFound;
                                                        $doclist =  SearchHelper::getInstance()->search($item->name,"song",$countSong);
                                                        $items = WebSongModel::updateResultFromSearch(SearchHelper::getInstance()->copyAndCast($doclist->docs, array('artist' => 'artist_name')));

                                                        foreach ($items as $song){
                                                                if(isset($song['cp_id']) && $song['cp_id']==1){
                                                                        $songName = strtoupper(trim($song['basename']));
                                                                        $songArtist = strtoupper(trim($song['artist_name']));
                                                                        $songArtist = Common::strNormal($songArtist);
                                                                        $itemName = strtoupper(trim($item->name));
                                                                        $itemArtist = strtoupper(trim($item->artist));
                                                                        $itemArtist = Common::strNormal($itemArtist);

                                                                        if(strlen($songName) - strlen($itemName)>3){
                                                                                continue;
                                                                        }
                                                                        if(strrpos($songArtist, $itemArtist)===false){
                                                                                continue;
                                                                        }


                                                                        $sql = "
                                                                                        INSERT INTO copyright_content_map(input_id,content_id,content_name,content_artist,content_type)
                                                                                        VALUES(:INPUT_ID,:CONTENT_ID,:CONTENT_NAME,:CONTENT_ARTIST,'song')
                                                                                        ON DUPLICATE KEY UPDATE content_name=:CONTENT_NAME_2, content_artist=:CONTENT_ARTIST_2
                                                                                        ";

                                                                        $contentId = $song['id'];
                                                                        $contentName = $song['basename'];
                                                                        $contentArtist = $song['artist_name'];

                                                                        $dataCmd = Yii::app()->db->createCommand($sql);
                                                                        $dataCmd->bindParam(":INPUT_ID", $inputId, PDO::PARAM_INT);
                                                                        $dataCmd->bindParam(":CONTENT_ID", $contentId, PDO::PARAM_INT);
                                                                        $dataCmd->bindParam(":CONTENT_NAME", $contentName, PDO::PARAM_STR);
                                                                        $dataCmd->bindParam(":CONTENT_ARTIST", $contentArtist, PDO::PARAM_STR);
                                                                        $dataCmd->bindParam(":CONTENT_NAME_2", $contentName, PDO::PARAM_STR);
                                                                        $dataCmd->bindParam(":CONTENT_ARTIST_2", $contentArtist, PDO::PARAM_STR);
                                                                        $dataCmd->execute();
                                                                        $countMapSong++;
                                                                }
                                                        }
                                                }else if("video"==$group->groupValue){
                                                        $countVideo = $doclist->numFound;
                                                        $doclist =  SearchHelper::getInstance()->search($item->name,"video",$countVideo);
                                                        $items = WebVideoModel::updateResultFromSearch(SearchHelper::getInstance()->copyAndCast($doclist->docs, array('artist' => 'artist_name')));

                                                        foreach ($items as $video){
                                                                if(isset($video['cp_id']) && $video['cp_id']==1){
                                                                        $sql = "
                                                                                        INSERT INTO copyright_content_map(input_id,content_id,content_name,content_artist,content_type)
                                                                                        VALUES(:INPUT_ID,:CONTENT_ID,:CONTENT_NAME,:CONTENT_ARTIST,'video')
                                                                                        ON DUPLICATE KEY UPDATE content_name=:CONTENT_NAME_2,content_artist=:CONTENT_ARTIST_2
                                                                                        ";

                                                                        $contentId = $video['id'];
                                                                        $contentName = $video['basename'];
                                                                        $contentArtist = $video['artist_name'];

                                                                        $dataCmd = Yii::app()->db->createCommand($sql);
                                                                        $dataCmd->bindParam(":INPUT_ID", $inputId, PDO::PARAM_INT);
                                                                        $dataCmd->bindParam(":CONTENT_ID", $contentId, PDO::PARAM_INT);
                                                                        $dataCmd->bindParam(":CONTENT_NAME", $contentName, PDO::PARAM_STR);
                                                                        $dataCmd->bindParam(":CONTENT_ARTIST", $contentArtist, PDO::PARAM_STR);
                                                                        $dataCmd->bindParam(":CONTENT_NAME_2", $contentName, PDO::PARAM_STR);
                                                                        $dataCmd->bindParam(":CONTENT_ARTIST_2", $contentArtist, PDO::PARAM_STR);
                                                                        $dataCmd->execute();
                                                                        $countMapVideo++;
                                                                }
                                                        }

                                                }else{
                                                        continue;
                                                }
                                        }
                                        */
                                        $return->error = 0;
                                        $return->errorMessage= $item->name.">> Bài hát ($countMapSong)";
                                    }
                                    if($content_type == 'video'){
                                        $cr = new CDbCriteria();
                                        $cr->condition = "LOWER(TRIM(name)) LIKE :NAME AND cp_id=1";
                                        $cr->params = array(":NAME"=>strtolower(trim($item->name))."%");
                                        $items = VideoModel::model()->findAll($cr);

                                        foreach ($items as $video){
                                                if(isset($video['cp_id']) && $video['cp_id']==1){
                                                        $videoName = strtoupper(trim($video['name']));
                                                        $videoArtist = strtoupper(trim($video['artist_name']));
                                                        $videoArtist = Common::strNormal($videoArtist);
                                                        $itemName = strtoupper(trim($item->name));
                                                        $itemArtist = strtoupper(trim($item->artist));
                                                        $itemArtist = Common::strNormal($itemArtist);

                                                        if(strlen($videoName) - strlen($itemName)>3){
                                                            continue;
                                                        }
                                                        if(strrpos($videoArtist, $itemArtist)===false){
                                                            continue;
                                                        }


                                                        $sql = "
                                                                    INSERT INTO copyright_content_map(input_id,content_id,content_name,content_artist,content_type)
                                                                    VALUES(:INPUT_ID,:CONTENT_ID,:CONTENT_NAME,:CONTENT_ARTIST,'video')
                                                                    ON DUPLICATE KEY UPDATE content_name=:CONTENT_NAME_2, content_artist=:CONTENT_ARTIST_2
                                                                ";

                                                        $contentId = $video['id'];
                                                        $contentName = $video['name'];
                                                        $contentArtist = $video['artist_name'];

                                                        $dataCmd = Yii::app()->db->createCommand($sql);
                                                        $dataCmd->bindParam(":INPUT_ID", $inputId, PDO::PARAM_INT);
                                                        $dataCmd->bindParam(":CONTENT_ID", $contentId, PDO::PARAM_INT);
                                                        $dataCmd->bindParam(":CONTENT_NAME", $contentName, PDO::PARAM_STR);
                                                        $dataCmd->bindParam(":CONTENT_ARTIST", $contentArtist, PDO::PARAM_STR);
                                                        $dataCmd->bindParam(":CONTENT_NAME_2", $contentName, PDO::PARAM_STR);
                                                        $dataCmd->bindParam(":CONTENT_ARTIST_2", $contentArtist, PDO::PARAM_STR);
                                                        $dataCmd->execute();
                                                        $countMapVideo++;
                                                }
                                        }
                                        
                                        $return->error = 0;
                                        $return->errorMessage= $item->name.">> Video ($countMapVideo)";
                                    }
                                }
                            }
                }catch (Exception $e)
		{
			$return->error = 500;
			$return->errorMessage= $e->getMessage();
		}
		echo json_encode($return);
		Yii::app()->end();
	}

	public function actionDeleteItems()
	{
		$ids = Yii::app()->request->getParam('cid');
		$page = Yii::app()->request->getParam('page');
		$fileId = Yii::app()->request->getParam('fileId');

		$c = new CDbCriteria();
		$c->addInCondition("id", $ids);
		CopyrightContentMapModel::model()->deleteAll($c);
		$this->redirect ( array ('view','id' => $fileId,'page'=>$page) );
	}

	public function actionMassUpdate()
	{

		$cids = Yii::app()->request->getParam('cid');
		$page = Yii::app()->request->getParam('page');
		$fileId = Yii::app()->request->getParam('fileId');
		//$ids = implode(",", $cids);

		$copyCodeList = AdminCopyrightModel::getListMap();
		//echo '<pre>';print_r($copyCodeList);exit();
		$sql = "SELECT t1.*, t2.content_type
				FROM copyright_input_content t1
				LEFT JOIN copyright_input_file t2 ON t2.id = t1.input_file
				WHERE t1.status=0 AND t1.input_file=:FID";

		$dataCmd = Yii::app()->db->createCommand($sql);
		$dataCmd->bindParam(":FID", $fileId, PDO::PARAM_INT);
		$dataList = $dataCmd->queryAll();
		foreach($dataList as $item){
			$copyright_id = trim($item["copyright_id"]);
			
			if(!isset($copyCodeList[$copyright_id])){
                            $_GET['msg'] = "Chưa có mã phụ lục <b>".$copyright_id."</b>";
                            $this->forward("/admin/error", true); // exit
			}

			$copyrighItem = $copyCodeList[$copyright_id];
			if(empty($copyrighItem)){
				continue;
			}
            $itemModel = CopyrightInputContentModel::model()->findByPk($item["id"]);
            if(!isset($itemModel)){
            	continue;
			}
			if($item["content_type"]=="song"){
				$sCopy = AdminSongCopyrightModel::model()->findByAttributes(array("song_id"=>$item["content_id"],"copryright_id"=>$copyrighItem["id"]));
				if(empty($sCopy)){
					$sCopy = new AdminSongCopyrightModel();
					$sCopy->setAttribute('song_id', $item["content_id"]);
					$sCopy->setAttribute('copryright_id', $copyrighItem['id']);
				}

				$sCopy->setAttribute('type', $copyrighItem['type']);
				$sCopy->setAttribute('from_date', $copyrighItem['start_date']);
				$sCopy->setAttribute('due_date', $copyrighItem['due_date']);
				$sCopy->setAttribute('copyright_method', 0);
				$sCopy->setAttribute('active', 1);
				if($sCopy->save()){
                 	$itemModel->setAttribute('status', 1);
                    $itemModel->save();
              	}
                                    
			}else{
				$sCopy = AdminVideoCopyrightModel::model()->findByAttributes(array("video_id"=>$item["content_id"],"copryright_id"=>$copyrighItem["id"]));
				if(empty($sCopy)){
					$sCopy = new AdminVideoCopyrightModel();
					$sCopy->setAttribute('video_id', $item["content_id"]);
					$sCopy->setAttribute('copryright_id', $copyrighItem['id']);
				}
				$sCopy->setAttribute('type', $copyrighItem['type']);
				$sCopy->setAttribute('from_date', $copyrighItem['start_date']);
				$sCopy->setAttribute('due_date', $copyrighItem['due_date']);
				$sCopy->setAttribute('copyright_method', 0);
				$sCopy->setAttribute('active', 1);
				if($sCopy->save()){
                                    $itemModel->setAttribute('status', 1);
                                    $itemModel->save();
                                }
			}
		}

		$this->redirect ( array ('view','id' => $fileId,'page'=>$page) );

	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param integer $id
	 *        	the ID of the model to be loaded
	 * @return CopyrightSongFileModel the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id) {
		$model = CopyrightInputFileModel::model ()->findByPk ( $id );
		if ($model === null)
			throw new CHttpException ( 404, 'The requested page does not exist.' );
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 *
	 * @param CopyrightSongFileModel $model
	 *        	the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'copyright-song-file-model-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
        
        public function actionExportXlsNotMapped()
        {
            $fileId = Yii::app()->request->getParam('fileId');

            $c = new CDbCriteria();
            $c->condition = "id=:FID";
            $c->params = array(":FID"=>$fileId);
            $fileInfo = CopyrightInputFileModel::model()->find($c);
            if(isset($fileInfo)){
                $content_type = $fileInfo->content_type;
                $file_name = $fileInfo->file_name;
            }
            if($fileId > 0 && isset($fileInfo))
                $data = CopyrightInputContentModel::model()->getListContentNotMapped($fileId,$content_type);

            //ini_set('display_errors', 'On');
            $this->layout=false;
            $fileName = "Danh_sach_khong_map_duoc";
            header('Content-type: application/vnd.ms-excel');
            header("Content-Disposition: attachment; filename=$fileName.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $this->render("_export_rows_not_mapped", array(
                'data' => $data,
                'content_type'=>$content_type,
                'file_name'=>$file_name,
                'file_id'=>$fileId
            ));
            exit();
        }
}
