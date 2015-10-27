<?php

class CollectionController extends Controller {

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý Collection ");
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new AdminCollectionModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CollectionModel'])){
            $model->attributes = $_GET['CollectionModel'];
        }
        $model->setAttribute("cc_type", "<>bxh");
        // search theo domain
        $domain = Yii::app()->request->getParam('domain','');
        if(!empty($domain)){
            $model['code'] = $domain;
        }


        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);
        $suggest =  Yii::app()->request->getParam('suggest',null);
        /* tu dong */
        if($model->mode == 1){
            $itemModelClass = $model->_getItemModelName();
            $page = Yii::app()->request->getParam($itemModelClass.'_page',1);
            $items = $model->_getItemsAuto($page,$pageSize, $suggest, '',false, true);
            $this->render('view', array(
                'model' => $model,
                'itemModel' => $items,
                'mode' => "auto"
            ));
        }
        else{
            $itemModel = new AdminCollectionItemModel;
            $itemModel->unsetAttributes();
            if (isset($_GET['AdminCollectionItemModel'])) {
                $itemModel->attributes = $_GET['AdminCollectionItemModel'];
                if(isset($_GET['AdminCollectionItemModel']['objName'])){
                	$itemModel->objName = $_GET['AdminCollectionItemModel']['objName'];
                }
            }
            $itemModel->setAttribute('collect_id', $id);
            $this->render('view', array(
                'model' => $model,
                'itemModel' => $itemModel,
                'pageSize' => $pageSize,
            	'mode' => "manual"
            ));
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new CollectionModel;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CollectionModel'])) {
            //check code exists
            $code = $_POST['CollectionModel']['code'];
            $exist = AdminCollectionModel::model()->exists('code = :code',array(':code'=>$code));
            if($exist){
                $this->render('create', array(
                    'model' => $model,'msg' => 'Mã số bộ sưu tập đã tồn tại. Vui lòng chọn mã khác'
                ));Yii::app()->end();
            }
            $model->attributes = $_POST['CollectionModel'];
            if ($model->save()){
                /*$genre_ids = $_POST['genre_ids'];
                $sql = "INSERT INTO collection_genre VALUES ";
                $arr = array();
                foreach ($genre_ids as $genre_id){
                    $arr[] = "(null,{$model->id},$genre_id,0)";
                }
                if(count($arr)>0){
                    $arr = implode(',',$arr);
                    Yii::app()->db->createCommand($sql.$arr)->execute();
                }*/

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
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
            $model->attributes = $_POST['CollectionModel'];
            if ($model->save()){
                /*$genre_ids = $_POST['genre_ids'];
                Yii::app()->db->createCommand("DELETE FROM collection_genre WHERE collect_id =  ".$model->id)->execute();

                $sql = "INSERT INTO collection_genre VALUES ";
                $arr = array();
                foreach ($genre_ids as $genre_id){
                    $arr[] = "(null,{$model->id},$genre_id,0)";
                }
                if(count($arr)>0){
                    $arr = implode(',',$arr);
                    Yii::app()->db->createCommand($sql.$arr)->execute();
                }*/

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
    	die("Can't do it");
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
    	die("Can't do it");
        if (isset($_POST['all-item'])) {
            CollectionModel::model()->deleteAll();
        } else {
            $item = $_POST['cid'];
            $c = new CDbCriteria;
            $c->condition = ('id in (' . implode($item, ",") . ')');
            $c->params = null;
            CollectionModel::model()->deleteAll($c);
        }
        $this->redirect(array('index'));
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
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'collection-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionReorder() {
        $data = Yii::app()->request->getParam('sorder');
		$id = Yii::app()->request->getParam('id',0);
        //$data = ArrayHelper::reorder($data);
        $maxArray = max($data);
		
        /* $c = new CDbCriteria();
        $c->condition = "collect_id=:cid";
        $c->params = array(':cid'=>$id);
        $c->order = "sorder ASC, id DESC";
        $collectionItem = AdminCollectionItemModel::model()->findAll($c);
		
        $i = 1;
        if($collectionItem){
	        foreach ($collectionItem as $item) {
	            if (!array_key_exists($item->id,$data)) {
	                $order = $maxArray + $i;
	                $i++;
	            } else {
	                $order = $data[$item->id];
	            }
	            $itemObj = AdminCollectionItemModel::model()->findByPk($item->id);
	            $itemObj->sorder = $order;
	            if($itemObj->save(false)){
	            	echo 'updated '.$item->id.' | '.$order."\n";
	            }else{
	            	echo 'failed '.$item->id.' | '.$order."\n";
	            }
	        }
        }else{
        	echo 'not collection id valid'."\n";
        } */
        
        // Chi sap xep cho cac item dc post len
        foreach($data as $k=>$v){
        	$itemObj = AdminCollectionItemModel::model()->findByPk($k);
        	if(empty($itemObj)) continue;
        	$itemObj->sorder = $v;
        	$itemObj->save(false);
        }
    }

    public function actioncustomCol() {
        $data = Yii::app()->request->getParam('customCol');
        $type = Yii::app()->request->getParam('type');
        $model = new CollectionModel;
        $itemModelName = $model->_getItemModelName($type);
        foreach ($data as $item_id => $custom_rank) {
            if(!empty($custom_rank)){
                $songObj = $itemModelName::model()->findByPk($item_id);
                $songObj->custom_rank = $custom_rank;
                $songObj->save();
            }
        }
    }

    public function actionSuggest() {
        $cids = Yii::app()->request->getParam('cid');
        $type = Yii::app()->request->getParam('type');
        $suggest = Yii::app()->request->getParam('suggest');
        $model = new CollectionModel;
        $itemModelName = $model->_getItemModelName($type);

        if (isset($_POST['all-item'])) {
            $itemModelName::model()->updateAll(array('suggest_'.$suggest => 1));
        } else {
            $itemModelName::model()->updateAll(array('suggest_'.$suggest => 1), "id IN (" . implode(',', $cids) . ")");
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionUnsuggest() {
        $cids = Yii::app()->request->getParam('cid');
        $type = Yii::app()->request->getParam('type');
        $suggest = Yii::app()->request->getParam('suggest');
        $model = new CollectionModel;
        $itemModelName = $model->_getItemModelName($type);

        if (isset($_POST['all-item'])) {
            $itemModelName::model()->updateAll(array('suggest_'.$suggest => 0));
        } else {
            $itemModelName::model()->updateAll(array('suggest_'.$suggest => 0), "id IN (" . implode(',', $cids) . ")");
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }


	public function actionPublish() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            CollectionModel::model()->updateAll(array('status' => 1));
        } else {
            CollectionModel::model()->updateAll(array('status' => 1), "id IN (" . implode(',', $cids) . ")");
        }

		$genre_id = Yii::app()->request->getParam('genre_id','');
		if(!$genre_id)
			$this->redirect(array('index'));
		else
			$this->redirect(Yii::app()->createUrl('collection/index',array('genre_id'=>$genre_id)));
    }

    public function actionUnpublish() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            CollectionModel::model()->updateAll(array('status' => 0));
        } else {
            CollectionModel::model()->updateAll(array('status' => 0), "id IN (" . implode(',', $cids) . ")");
        }

		$genre_id = Yii::app()->request->getParam('genre_id','');
		if(!$genre_id)
			$this->redirect(array('index'));
		else
			$this->redirect(Yii::app()->createUrl('collection/index',array('genre_id'=>$genre_id)));
    }

    public function actionReorder_Col($custom_field=null) {
        $custom_field = Yii::app()->request->getParam('custom_field');
        if(!$custom_field){
            $data = Yii::app()->request->getParam('sorder');
            $genre_id = Yii::app()->request->getParam('genre_id','');
            $maxArray = max($data);//var_dump($data);die();

            $c = new CDbCriteria();
            $c->condition = "genre_id = $genre_id";
            $c->order = "sorder ASC, id DESC";
            $col_genres = AdminCollectionGenreModel::model()->findAll($c);

            $i = 1;
            foreach ($col_genres as $col_genre) {
                if (!isset($data[$col_genre->collect_id])) {
                    $order = $maxArray + $i;
                } else {
                    $order = $data[$col_genre->collect_id];
                }
                $col_genre->sorder = $order;
                $col_genre->save();
                $i++;
            }
        }
        else{
            $data = Yii::app()->request->getParam('sorder');
            $c = new CDbCriteria();
            $c->order = "$custom_field ASC, id DESC";
            $col_genres = AdminCollectionModel::model()->findAll($c);

            foreach ($col_genres as $col_genre) {
                if (isset($data[$col_genre->id])) {
                    $col_genre->$custom_field = $data[$col_genre->id];
                    $col_genre->save();
                }
            }
        }

    }


    public function actionshowathomepage() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            CollectionModel::model()->updateAll(array('home_page' => 1));
        } else {
            CollectionModel::model()->updateAll(array('home_page' => 1), "id IN (" . implode(',', $cids) . ")");
        }

		$this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionUnshowathomepage() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            CollectionModel::model()->updateAll(array('home_page' => 0));
        } else {
            CollectionModel::model()->updateAll(array('home_page' => 0), "id IN (" . implode(',', $cids) . ")");
        }

		$this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionListWebFront() {
    	$pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
    	Yii::app()->user->setState('pageSize', $pageSize);

    	$model = new AdminCollectionModel('search');
    	//$model->dbCriteria->order='web_home_page ASC';

    	$model->unsetAttributes();  // clear any default values
    	$this->render('webhomelist', array(
    			'model' => $model,
    			'pageSize' => $pageSize
    	));
    }
	public function actionDisCollectinWeb()
	{
		$id = Yii::app()->request->getParam('id',0);
		$collection = AdminCollectionModel::model()->findByPk($id);
		$collection->web_home_page=0;
		$collection->save(false);
		$this->redirect(array('/collection/listWebFront'));
	}
    public function actionAddwebhome()
    {
    	$id = Yii::app()->request->getParam('cl_id');
    	$coll = AdminCollectionModel::model()->findByPk($id);
    	if($coll && $coll->web_home_page==0){
    		$coll->web_home_page = 1;
    		$coll->save();
    	}
    	$this->redirect(array("collection/listWebFront"));
    }

    public function actionReorderwebhome()
    {
    	$data = Yii::app()->request->getParam('sorder');

    	$data = ArrayHelper::reorder($data);
    	$maxArray = max($data);

    	$c = new CDbCriteria();
    	$c->condition = "web_home_page > 0";
    	$c->order = "web_home_page ASC, id DESC";
    	$songF = AdminCollectionModel::model()->findAll($c);

    	$i = 1;
    	foreach ($songF as $songF) {
    		if (!isset($data[$songF->id])) {
    			$order = $maxArray + $i;
    			$i++;
    		} else {
    			$order = $data[$songF->id]==0?($data[$songF->id]+1):$data[$songF->id];
    		}
    		$songObj = AdminCollectionModel::model()->findByPk($songF->id);
    		$songObj->web_home_page = $order;
    		$songObj->save();
    	}

    }
    public function actionAutoComplete()
    {
    	$this->layout = false;
    	$q = Yii::app()->request->getParam('q');
    	if (!$q) return;
    	$c = new CDbCriteria();
    	$c->condition = "type='song' AND name LIKE :NAME AND web_home_page <> 1 AND code NOT LIKE '%mientay%' AND code NOT LIKE '%quocte%'  ";
    	$c->params = array(':NAME'=>'%'.$q.'%');
    	$list = AdminCollectionModel::model()->findAll($c);
    	foreach ($list as $cc){
    		$name = $cc->name;
    		$id = $cc->id;
    		echo "$name|$id\n";
    	}
    	Yii::app()->end();
    }
}
