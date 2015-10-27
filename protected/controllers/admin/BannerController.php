<?php

Yii::import("ext.xupload.models.XUploadForm");

class BannerController extends Controller {

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý Banner ");
    }

    public function actions() {
        return array(
            'upload' => array(
                'class' => 'ext.xupload.actions.XUploadAction',
                'subfolderVar' => 'parent_id',
                'path' => _APP_PATH_ . DS . "data",
                'alowType' => 'image/jpeg,image/png,image/gif,image/x-png,image/pjpeg,application/x-shockwave-flash'
            ),
        );
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new BannerModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BannerModel']))
            $model->attributes = $_GET['BannerModel'];

        $channel = Yii::app()->request->getParam('channel','');
        if($channel == ''){
            $channel = Yii::app()->request->getParam('BannerModel');
            $channel = ($channel['channel'])? $channel['channel'] : 'web';
        }
        Yii::app()->session['channel'] = $channel;
        $model->channel = $channel;

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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new BannerModel;
        $arr = array('image'=>'jpeg,jpg,png,gif,pjpeg,x-png','flash'=>'swf');

        if (isset($_POST['BannerModel'])) {
            $model->attributes = $_POST['BannerModel'];
            $params = Yii::app()->request->getParam('params',null);
            if($params){
            	$model->setAttribute("params", json_encode($params));
            }

            if ($model->save()) {
                $fileUpload = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS . $_POST['BannerModel']['image_upload'];
                if (file_exists($fileUpload)) {
                    $ext = substr($_POST['BannerModel']['image_upload'], strrpos($_POST['BannerModel']['image_upload'], '.') + 1);
                    $file = $model->id . '.' . $ext;

                    $filePath = Yii::app()->params['storage']['bannerDir']  . DS . $file;
                    copy($fileUpload, $filePath);
                    $model->image_file = $file;

                    if(empty($model->type)){
                        foreach($arr as $key=>$val)
                            if(strpos($val,  strtolower($ext)) !== false){
                                 $model->type = $key;
                                 break;
                            }
                    }
                    $model->save();
                }

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $uploadModel = new XUploadForm();
        $this->render('update', array(
            'model' => $model,
            'uploadModel' => $uploadModel,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $arr = array('image'=>'jpeg,jpg,png,gif,pjpeg,x-png','flash'=>'swf');

        if (isset($_POST['BannerModel'])) {
            $model->attributes = $_POST['BannerModel'];
            $params = Yii::app()->request->getParam('params',null);
            if($params){
            	$model->setAttribute("params", json_encode($params));
            }

            if ($model->save()) {
                $fileUpload = Yii::app()->params['storage']['baseStorage'].DS. "tmp" . DS . $_POST['BannerModel']['image_upload'];
                if (file_exists($fileUpload)) {
                    $ext = substr($_POST['BannerModel']['image_upload'], strrpos($_POST['BannerModel']['image_upload'], '.') + 1);
                    $file = $model->id . '.' . $ext;

                    $filePath = Yii::app()->params['storage']['bannerDir']  . DS . $file;

                    copy($fileUpload, $filePath);
                    $model->image_file = $file;

                    if(empty($model->type)){
                        foreach($arr as $key=>$val)
                            if(strpos($val,  strtolower($ext)) !== false){
                                 $model->type = $key;
                                 break;
                            }
                    }
                    $model->save();
                }

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

//		$this->render('update',array(
//			'model'=>$model,
//		));
        $uploadModel = new XUploadForm();
        $this->render('update', array(
            'model' => $model,
            'uploadModel' => $uploadModel,
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

        if (isset($_POST['BannerModel'])) {
            $model = new BannerModel;
            $model->attributes = $_POST['BannerModel'];
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
            BannerModel::model()->deleteAll();
        } else {
            $item = $_POST['cid'];
            $c = new CDbCriteria;
            $c->condition = ('id in (' . implode($item, ",") . ')');
            $c->params = null;
            BannerModel::model()->deleteAll($c);
        }
        $this->redirect(array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = BannerModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'banner-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionPublish() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            BannerModel::model()->updateAll(array('status' => 1));
        } else {
            BannerModel::model()->updateAll(array('status' => 1), "id IN (" . implode(',', $cids) . ")");
        }

        $this->redirect(array('index'));
    }

    public function actionUnpublish() {
        $cids = Yii::app()->request->getParam('cid');
        if (isset($_POST['all-item'])) {
            BannerModel::model()->updateAll(array('status' => 0));
        } else {
            BannerModel::model()->updateAll(array('status' => 0), "id IN (" . implode(',', $cids) . ")");
        }
        $this->redirect(array('index'));
    }

    public function actionReorder() {
        $data = Yii::app()->request->getParam('sorder');
        $data = ArrayHelper::reorder($data);
        $maxArray = max($data);

        $c = new CDbCriteria();
        $c->order = "sorder ASC, id DESC";
        $banners = BannerModel::model()->findAll($c);

        $i = 1;
        foreach ($banners as $banner) {
            if (!isset($data[$banner->id])) {
                $order = $maxArray + $i;
            } else {
                $order = $data[$banner->id];
            }
            $songObj = BannerModel::model()->findByPk($banner->id);
            $songObj->sorder = $order;
            $songObj->save();
            $i++;
        }
    }

    /*
     * HiepNQ create on 19-10-2012
     * function display url in anchor tag
     */
    protected function genUrl($data,$row) {
      return  CHtml::link(mb_substr($data->url,0,30),'#',array('rel'=>$data->url,"title"=>$data->url));
    }
    /*
     * HiepNQ create on 19-10-2012
     * function display banner adv
     */
    protected function genBanner($data,$row){
        $imagePath = Yii::app()->params['storage']['bannerUrl'].$data->image_file;
        return CHtml::image($imagePath, 'banner',array('width'=>'100px','height'=>'60px'));
    }

}
