<?php

Yii::import("ext.timepicker.timepicker");

class CldController extends Controller {

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý lịch bắn tin spam");
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new CldModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CldModel']))
            $model->attributes = $_GET['CldModel'];

        $tmpArr = CldModel::model()->findAll();
        $smsGroup = array();
        foreach ($tmpArr as $smsG) {            
            $smsGroup[$smsG->id] = $smsG->name;
        }
        $this->render('index', array(
            'model' => $model,
            'pageSize' => $pageSize,
            'smsGroup' => $smsGroup
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
     * If creation is successful, the browser will be redirected to the 'view' page.\
     * $send_time   thoi gian send 
     * $error       1: thoi gian gui ko > thoi gian hien tai 1 h
     *             
     */
    public function actionCreate() {
        $model = new CldModel;
        $send_time = "";

        $tmpArr = GroupModel::model()->findAll();
        $smsGroup = array();
        foreach ($tmpArr as $smsG) {            
            $smsGroup[$smsG->id] = $smsG->name;
        }

        if (isset($_POST['CldModel'])) {            
            foreach ($_POST['CldModel'] as $name => $value) {
                $model->$name = $value;
            }
            $send_time = $model->send_time;
            $name == "created_time";
            $created_time = date("Y-m-d H:i:s");
            $model->$name = $created_time;

            $to_time = strtotime($send_time);
            $from_time = strtotime($created_time);
            $mins = round(abs($to_time - $from_time) / 60, 2);
             
            if ($mins <= 30) {
                $error = 1;
                $this->render('create', array('model' => $model, 'smsGroup' => $smsGroup, 'error' => $error));
            } else {
                $model->status = 1;
                if ($model->save())
                    ;
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('create', array(
            'model' => $model, 'smsGroup' => $smsGroup
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

        if (isset($_POST['CldModel'])) {
            $model->attributes = $_POST['CldModel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $tmpArr = GroupModel::model()->findAll();
        $smsGroup = array();
        foreach ($tmpArr as $smsG) {            
            $smsGroup[$smsG->id] = $smsG->name;
        }
        
        $this->render('update', array(
            'model' => $model, 'smsGroup' => $smsGroup, 'group_id' => $model->group_id
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

        if (isset($_POST['CldModel'])) {
            $model = new CldModel;
            $model->attributes = $_POST['CldModel'];
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
            CldModel::model()->deleteAll();
        } else {
            $item = $_POST['cid'];
            $c = new CDbCriteria;
            $c->condition = ('id in (' . implode($item, ",") . ')');
            $c->params = null;
            CldModel::model()->deleteAll($c);
        }
        $this->redirect(array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = CldModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-spam-sms-cld-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Update trang thai 1 Cld duy nhat tu 0 -> 1
     * Update cac trang thai dang tu 1 -> 2
     */
    public function actionActive() {
        $id = Yii::app()->request->getParam('cid');
        CldModel::model()->updateAll(array('status' => 2), "status = 1");
        $spamCld = CldModel::model()->findByPk($id);
        $spamCld->status = 1;
        $spamCld->save();
        $this->redirect(array('index'));
    }

}
