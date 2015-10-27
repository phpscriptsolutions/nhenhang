<?php

Yii::import("ext.xupload.models.XUploadForm");
Yii::import("application.modules.spam.components.*");

class PhoneController extends Controller {

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', "Quản lý Danh sách số điện thoại ");
    }

    public function actions() {
        return array(
            'upload' => array(
                'class' => 'ext.xupload.actions.XUploadAction',
                'subfolderVar' => 'parent_id',
                'path' => _APP_PATH_ .DS.'public'.DS.'admin'. DS . "data",
                'alowType' => 'application/vnd.ms-excel'
            ),
        );
    }
    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new PhoneModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PhoneModel']))
            $model->attributes = $_GET['PhoneModel'];

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
        $model = new PhoneModel;
        $message = "";
        $errorList = array();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['source_name'], $_POST['group_id'])) {
            $fileName = _APP_PATH_ . DS . "data" . DS . "tmp" . DS . $_POST['source_name'];
            $group_id = $_POST['group_id'];
            //$fileName = "D:\\chacha_cloud\\src\\trunk\chacha\data\\tmp\\20120713170547_phone_list.xls";
            try {
                require_once 'excel_reader2.php';

                $data = new Spreadsheet_Excel_Reader($fileName, true, "UTF-8"); // khoi tao doi tuong doc file excel 
                $rowsnum = $data->rowcount($sheet_index = 0); // lay so hang cua sheet
                $colsnum = $data->colcount($sheet_index = 0); // lay so cot cua sheet
                for ($i = 2; $i <= $rowsnum; $i++) { // doc tu hang so 2 vi hang 1 la tieu de roi!
                    $phoneNum = $data->val($i, 1); // xuat cot so 1 va cot so 2 tren cung 1 hang                          
                    // check so dien thoai xem co dung cua Vinaphone ko
                    try {
                        $phoneNum = Formatter::formatPhone($phoneNum);                        
                        if (Formatter::isVinaphoneNumber($phoneNum)) {
                            $model->phone = "$phoneNum";
                            $model->group_id = $group_id;
                            $model->status = 0;
                            $model->created_time = date("Y-m-d H:i:s");
                            var_dump($model->phone);
                            try {
                                if ($model->save()) {
                                    $message = yii::t('SpamModule', 'Upload thành công');                                    
                                } else {
                                    print_r($model->getErrors()); exit;
                                }
                            } catch (Exception $exc) {
                                echo $exc->getTrace();
                            }
                        } else {
                            //echo so dien thoai ko dung
                            $errorList[] = $phoneNum;
                        }
                    } catch (Exception $exc) {
                        echo $exc->getMessage();
                    }
                }
            } catch (Exception $exc) {
                echo $exc->getMessage();
            }
        }
        $uploadModel = new XUploadForm();
        
        $tmpArr = GroupModel::model()->findAll();
        $smsGroup = array();
        foreach ($tmpArr as $smsG) {            
            $smsGroup[$smsG->id] = $smsG->name;
        }
        $this->render('create', array(
            'model' => $model, 'uploadModel' => $uploadModel, 'message' => $message, 'smsGroup' => $smsGroup, 'errorList' => $errorList
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

        if (isset($_POST['PhoneModel'])) {
            $model->attributes = $_POST['PhoneModel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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

        if (isset($_POST['PhoneModel'])) {
            $model = new PhoneModel();
            $model->attributes = $_POST['PhoneModel'];
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
            PhoneModel::model()->deleteAll();
        } else {
            $item = $_POST['cid'];
            $c = new CDbCriteria;
            $c->condition = ('id in (' . implode($item, ",") . ')');
            $c->params = null;
            PhoneModel::model()->deleteAll($c);
        }
        $this->redirect(array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = PhoneModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'admin-spam-sms-group-model-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
