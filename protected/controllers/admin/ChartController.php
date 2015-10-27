<?php
class ChartController extends Controller
{
	public function actionIndex() {
		$pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
		Yii::app()->user->setState('pageSize', $pageSize);

		$model = new AdminCollectionModel('chart');
		$model->unsetAttributes();
		if(isset($_GET['AdminCollectionModel'])){
			$model->attributes=$_GET['AdminCollectionModel'];
		}
		/* if(isset($_GET['AdminCollectionModel']['type'])){
			$model->setAttribute("type", $_GET['AdminCollectionModel']['type']);
		} */
		
		$model->setAttribute("cc_type", "bxh");

		$this->render('index', array(
				'model' => $model,
				'pageSize' => $pageSize
		));
	}

	public function actionCreate() {
		$model = new CollectionModel;
		if (isset($_POST['CollectionModel'])) {
			$code = strtoupper('BXH_' . $_POST['CollectionModel']['type'] . '_' . $_POST['CollectionModel']['cc_genre'] . '_' . $_POST['CollectionModel']['cc_week_num'] . '_' . date('Y'));
			
			//check code exists					
			$exist = AdminCollectionModel::model()->exists('code = :code',array(':code'=>$code));
			if($exist){
				$this->render('create', array(
						'model' => $model,'msg' => 'Bộ sưu tập ' . $code . ' đã tồn tại. Vui lòng chọn lại thông tin'
				));Yii::app()->end();
			}
			
			$week = $_POST['CollectionModel']['cc_week_num'];
			$year = date("Y");
			
			$model->attributes = $_POST['CollectionModel'];
			$model->setAttribute("cc_type", "bxh");
			$model->setAttribute("code", $code);			
			$model->setAttribute("cc_week_begin", date("Y-m-d", Utils::getFirstDayOfWeek($year,$week)));
			$model->setAttribute("cc_week_end", date("Y-m-d", strtotime("+7 day", Utils::getFirstDayOfWeek($year,$week))));
			
			//echo "<pre>"; print_r(json_decode(CJSON::encode($model))); echo "</pre>"; die();
			if ($model->save()){
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array(
				'model' => $model,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
		$model = $this->loadModel($id);
		$pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
		$suggest =  Yii::app()->request->getParam('suggest',null);
		/* tu dong */

		if(isset($_POST['collectionMeta'])) {
			CollectionMetadataModel::model()->updateData($model->id, $_POST['collectionMeta']);
		}
		$crit = new CDbCriteria();
		$crit->condition = 'collection_id=:collection_id';
		$crit->params = array(':collection_id'=>$id);
		$collectionMetaData = CollectionMetadataModel::model()->findAll($crit);
		if($model->mode == 1){
			$itemModelClass = $model->_getItemModelName();
			$page = Yii::app()->request->getParam($itemModelClass.'_page',1);
			$items = CollectionModel::model()->_getItemsAuto($page,$pageSize, $suggest, '',false, true);
			$this->render('view', array(
					'model' => $model,
					'itemModel' => $items,
					'mode' => "auto",
					'collectionMetaData'=>$collectionMetaData
			));
		}
		else{
			$itemModel = new AdminCollectionItemModel;
			$itemModel->unsetAttributes();
			if (isset($_GET['AdminCollectionItemModel'])) {
				$itemModel->attributes = $_GET['AdminCollectionItemModel'];
			}
			$itemModel->setAttribute('collect_id', $id);
			$this->render('view', array(
					'model' => $model,
					'itemModel' => $itemModel,
					'pageSize' => $pageSize,
					'collectionMetaData'=>$collectionMetaData
			));
		}
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) {
		$model = CollectionModel::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id) {
		$model = $this->loadModel($id);
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (isset($_POST['CollectionModel'])) {
			$code = strtoupper('BXH_' . $_POST['CollectionModel']['type'] . '_' . $_POST['CollectionModel']['cc_genre'] . '_' . $_POST['CollectionModel']['cc_week_num'] . '_' . date('Y'));

			//check code exists
			$exist = AdminCollectionModel::model()->exists('code = :code',array(':code'=>$code));
			if($exist){
				$this->render('create', array(
					'model' => $model,'msg' => 'Bộ sưu tập ' . $code . ' đã tồn tại. Vui lòng chọn lại thông tin'
				));Yii::app()->end();
			}
			$week = $_POST['CollectionModel']['cc_week_num'];
			$year = date("Y");
			$model->attributes = $_POST['CollectionModel'];
			$model->setAttribute("cc_week_begin", date("Y-m-d", Utils::getFirstDayOfWeek($year,$week)));
			$model->setAttribute("cc_week_end", date("Y-m-d", strtotime("+7 day", Utils::getFirstDayOfWeek($year,$week))));
			$model->setAttribute("code", $code);
			if ($model->save()){
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
	
		$this->render('update', array(
				'model' => $model,
		));
	}
	
	/**
	 * Copy record
	 * If copy is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be copy
	 */
	public function actionCopy($id) {
		$data = $this->loadModel($id);
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if (isset($_POST['CollectionModel'])) {
			$model = new CollectionModel;
			$model->attributes = $_POST['CollectionModel'];
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}
	
		$this->render('copy', array(
				'model' => $data,
		));
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();
	
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}
}
