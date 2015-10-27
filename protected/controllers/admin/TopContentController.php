<?php
Yii::import ( "ext.xupload.models.XUploadForm" );
class TopContentController extends Controller {
	public $uploadModel;
	public $coverWidth = 1190;
	public $coverHeight = 350;
	public $tags = array ();
	public function init() {
		parent::init ();
		$this->pageTitle = Yii::t ( 'admin', "Quản lý  Top Content " );
	}
	public function actions() {
		return array (
				'upload' => array (
						'class' => 'ext.xupload.actions.XUploadAction',
						'subfolderVar' => 'parent_id',
						'path' => Yii::app ()->params ['storage'] ['baseStorage'],
						'alowType' => 'image/jpeg,image/png,image/gif,image/x-png,image/pjpeg',
						'type' => 'image' 
				) 
		);
	}
	
	/**
	 * Manages all models.
	 */
	public function actionIndex() {
		$pageSize = Yii::app ()->request->getParam ( 'pageSize', Yii::app ()->params ['pageSize'] );
		Yii::app ()->user->setState ( 'pageSize', $pageSize );
		$model = new AdminTopContentModel ( 'search' );
		$model->unsetAttributes (); // clear any default values
		if (isset ( $_GET ['AdminTopContentModel'] ))
			$model->attributes = $_GET ['AdminTopContentModel'];
		
		$this->render ( 'index', array (
				'model' => $model,
				'pageSize' => $pageSize 
		) );
	}
	
	/**
	 * Displays a particular model.
	 *
	 * @param integer $id
	 *        	the ID of the model to be displayed
	 */
	public function actionView($id) {
		$this->render ( 'view', array (
				'model' => $this->loadModel ( $id ) 
		) );
	}
	function createImage($model, $image_path) {
		if (file_exists ( $image_path )) {
			$fileSystem = new Filesystem ();
			$s0Path = $model->getAvatarPath ( $model->id, "s0", false ); // Origin
			$s1Path = $model->getAvatarPath ( $model->id, "s1", false ); // Resize
			$s2Path = $model->getAvatarPath ( $model->id, "s2", false ); // Thumb
			$fileSystem->mkdirs ( dirname ( $s0Path ) );
			$fileSystem->mkdirs ( dirname ( $s1Path ) );
			$fileSystem->mkdirs ( dirname ( $s2Path ) );
			
			list ( $width, $height ) = getimagesize ( $image_path );
			$imgCrop = new ImageCrop ( $image_path, 0, 0, $width, $height );
			
			$fileSystem->copy ( $image_path, $s0Path );
			$imgCrop->resizeCrop ( $s1Path, $this->coverWidth, $this->coverHeight );
			$imgCrop->resizeFix ( $s2Path, 690, 250 );
			$fileSystem->remove ( $image_path );
		}
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate() {
		$model = new AdminTopContentModel ();
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if (isset ( $_POST ['AdminTopContentModel'] )) {
			$model->attributes = $_POST ['AdminTopContentModel'];
			if ($model->save ()) {
				if (isset ( $_POST ['tmp_file_path'] )) {
					$fileAvatar = Yii::app ()->params ['storage'] ['baseStorage'] . "tmp" . DS . $_POST ['tmp_file_path'];
					// $fileAvatar = 'E:\dev\chacha_cloud\src\trunk\chacha\public\admin\data\tmp'. DS . $_POST['tmp_file_path'];
					if (file_exists ( $fileAvatar )) {
						$imgSize = getimagesize ( $fileAvatar );
						$realW = $imgSize [0];
						$realH = $imgSize [1];
						// AvatarHelper::processAvatar($model, $fileAvatar);
						if ($realW > $this->coverWidth || $realH > $this->coverHeight) {
							$error = 1;
							$model->addError ( "file", "Kích thước ảnh không chính xác" );
							goto Cexit;
						}
						if ($model->save ()) {
							$this->createImage ( $model, $fileAvatar );
							
							// Update Tag
							TagContentModel::model ()->updateTag ( $model->id, $_POST ['tags'], "topContent" );
							
							$this->redirect ( array (
									'view',
									'id' => $model->id 
							) );
						}
						/*
						 * if($realW > $maxW || $realH > $maxH){ $error = 1; $this->redirect(Yii::app()->createUrl('topContent/update',array('id'=>$model->id, 'error' => $error))); } else { $this->redirect(array('view','id'=>$model->id)); }
						 */
					}
				}
			}
		}
		Cexit:
		$this->uploadModel = new XUploadForm ();
		$this->render ( 'create', array (
				'model' => $model 
		) );
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id
	 *        	the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel ( $id );
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (isset ( $_GET ['error'] ))
			$error = $_GET ['error'];
		else
			$error = null;
		if (isset ( $_POST ['AdminTopContentModel'] )) {
			$model->attributes = $_POST ['AdminTopContentModel'];
			if ($model->save ()){
				// Update Tag
				TagContentModel::model ()->updateTag ( $model->id, $_POST ['tags'], "topContent" );
				
				$fileAvatar = Yii::app ()->params ['storage'] ['baseStorage'] . DS . "tmp" . DS . $_POST ['tmp_file_path'];
				if (file_exists ( $fileAvatar )) {
					$imgSize = getimagesize ( $fileAvatar );
					$realW = $imgSize [0];
					$realH = $imgSize [1];
				
					if ($realW > $this->coverWidth || $realH > $this->coverHeight) {
						$error = 1;
						$model->addError ( "file", "Kích thước ảnh không chính xác" );
						goto Cexit;
					}
					$this->createImage ( $model, $fileAvatar );
				}
				
				$this->redirect ( array (
						'view',
						'id' => $model->id
				) );
			}
		}
		Cexit:
		
		$this->uploadModel = new XUploadForm ();
		$this->tags = TagContentModel::model ()->getTagByContent ( $id, "topContent" );
		$this->render ( 'update', array (
				'model' => $model,
				'error' => $error 
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
		if (Yii::app ()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadModel ( $id )->delete ();
			
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (! isset ( $_GET ['ajax'] ))
				$this->redirect ( isset ( $_POST ['returnUrl'] ) ? $_POST ['returnUrl'] : array (
						'index' 
				) );
		} else
			throw new CHttpException ( 400, 'Invalid request. Please do not repeat this request again.' );
	}
	
	/**
	 * bulk Action.
	 *
	 * @param
	 *        	string the action
	 */
	public function actionBulk() {
		$act = Yii::app ()->request->getParam ( 'bulk_action', null );
		if (isset ( $act ) && $act != "") {
			$this->forward ( $this->getId () . "/" . $act );
		} else {
			$this->redirect ( array (
					'index' 
			) );
		}
	}
	
	/**
	 * Delete all record Action.
	 *
	 * @param
	 *        	string the action
	 */
	public function actionDeleteAll() {
		if (isset ( $_POST ['all-item'] )) {
			AdminTopContentModel::model ()->deleteAll ();
		} else {
			$item = $_POST ['cid'];
			$c = new CDbCriteria ();
			$c->condition = ('id in (' . implode ( $item, "," ) . ')');
			$c->params = null;
			AdminTopContentModel::model ()->deleteAll ( $c );
		}
		$this->redirect ( array (
				'index' 
		) );
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param
	 *        	integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = AdminTopContentModel::model ()->findByPk ( $id );
		if ($model === null)
			throw new CHttpException ( 404, 'The requested page does not exist.' );
		return $model;
	}
	
	/**
	 * Performs the AJAX validation.
	 *
	 * @param
	 *        	CModel the model to be validated
	 */
	protected function performAjaxValidation($model) {
		if (isset ( $_POST ['ajax'] ) && $_POST ['ajax'] === 'admin-top-content-model-form') {
			echo CActiveForm::validate ( $model );
			Yii::app ()->end ();
		}
	}
	public function actionAutoComplete() {
		$this->layout = false;
		$t = Yii::app ()->request->getParam ( 't', '' );
		$q = Yii::app ()->request->getParam ( 'q' );
		if (! $q)
			return;
		$c = new CDbCriteria ();
		$list = null;
		if ($t == 'album') {
			$c->condition = "name LIKE :NAME AND status = 1";
			$c->params = array (
					':NAME' => '%' . $q . '%' 
			);
			$list = AdminAlbumModel::model ()->findAll ( $c );
		} elseif ($t == 'video_playlist') {
			$c->condition = "name LIKE :NAME  ";
			$c->params = array (
					':NAME' => '%' . $q . '%' 
			);
			$list = AdminVideoPlaylistModel::model ()->findAll ( $c );
		}
		if (isset ( $list ))
			foreach ( $list as $cc ) {			 
				$name = $cc->name."(".$cc->id.")";
				if(isset($cc->artist_name)){
					$name .= "-".$cc->artist_name;
				}
				$id = $cc->id;
				echo "$name|$id\n";
			}
		Yii::app ()->end ();
	}
	public function actionReorderCol() {
		$data = Yii::app ()->request->getParam ( 'sorder' );
		$data = ArrayHelper::reorder ( $data );
		$maxArray = max ( $data );
		
		$c = new CDbCriteria ();
		$c->order = "sorder DESC, id DESC";
		$cols = AdminTopContentModel::model ()->findAll ( $c );
		
		foreach ( $cols as $item ) {
			if (! isset ( $data [$album->id] )) {
				$order = $maxArray + $i;
			} else {
				$order = $data [$album->id];
			}
			if (isset ( $order )) {
				$item->sorder = $data [$item->id];
				$item->save ();
			}
		}
	}
}
