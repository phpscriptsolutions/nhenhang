<?php

Yii::import("ext.xupload.models.XUploadForm");
Yii::import("application.modules.spam.components.*");
@ini_set("max_execution_time", 300);
@ini_set("memory_limit", "1024M");

class GroupController extends Controller {

    public function init() {
        parent::init();
        $this->pageTitle = Yii::t('admin', "Qu?n lý Sms Group ");
    }

    public function actions() {
        return array(
            'upload' => array(
                'class' => 'ext.xupload.actions.XUploadAction',
                'subfolderVar' => 'parent_id',
                'path' => _APP_PATH_ . DS . "data",
                'alowType' => 'application/vnd.ms-excel,application/x-msdownload'
            ),
        );
    }

    /**
     * Manages all models.
     */
    public function actionIndex() {
        $pageSize = Yii::app()->request->getParam('pageSize', Yii::app()->params['pageSize']);
        Yii::app()->user->setState('pageSize', $pageSize);

        $model = new GroupModel('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['GroupModel']))
            $model->attributes = $_GET['GroupModel'];

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
        $phoneList = new PhoneModel;
        $phoneList->unsetAttributes();
        if (isset($_GET['PhoneModel'])) {
            $phoneList->attributes = $_GET['PhoneModel'];
        }
        if (isset($_GET['phone']))
            $phoneList->phone = $_GET['phone'];
        $phoneList->setAttribute('group_id', $id);


//        var_dump($phoneList);

        if (isset(Yii::app()->session['phoneList'], Yii::app()->session['message'], Yii::app()->session['errorList'], Yii::app()->session['dupList'], Yii::app()->session['subscribeList'])) {
        	$phoneList = Yii::app()->session['phoneList'];
            $message = Yii::app()->session['message'];
            $errorList = Yii::app()->session['errorList'];
            $dupList = Yii::app()->session['dupList'];
            $subscribeList = Yii::app()->session['subscribeList'];
        } else {
            $message = NULL;
            $errorList = NULL;
            $dupList = NULL;
            $subscribeList = NULL;
        }
        $uploadModel = new XUploadForm();
        $this->render('view', array(
            'model' => $this->loadModel($id), 'group_id' => $id, 'phoneList' => $phoneList, 'uploadModel' => $uploadModel,
            'message' => $message, 'errorList' => $errorList, 'dupList' => $dupList, 'subscribeList' => $subscribeList
        ));
        unset(Yii::app()->session['phoneList']);
        unset(Yii::app()->session['message']);
        unset(Yii::app()->session['errorList']);
        unset(Yii::app()->session['dupList']);
        unset(Yii::app()->session['subscribeList']);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new GroupModel;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['GroupModel'])) {
            $model->attributes = $_POST['GroupModel'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * clone a Group 
     */
    public function actionClone() {
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $id = Yii::app()->request->getParam("id");
        $oldmodel = GroupModel::model()->findByPk($id);
        $model = new GroupModel;
        foreach ($oldmodel->attributes as $key => $val) {
            if ($key != "id")
            {
                if($key=="name")
                    $val.=" -- CLONE";
                $model[$key] = $val;
            }
        }

        if ($model->save()) {
            $phoneList = PhoneModel::model()->getPhoneGroup($id);
            $arrayVal = array();
            foreach ($phoneList as $phone) {
                $phoneNum = $phone['phone'];                
                $exist3 = DeletedPhoneModel::model()->exists('phone = :phone', array(':phone' => $phoneNum));
                if($exist3 == false){
                    $created_time = date("Y-m-d H:i:s");  
                    $mId = $model->id;
                    $arrayVal[] = "('$phoneNum',$mId,0,'$created_time')";
                }
            }
            /**
             * Start insert here: split each 200 phone
             */
            $arrs = array_chunk($arrayVal, 200);
            foreach ($arrs as $arr) {
                $vals = implode(",", $arr);
                $sql = "INSERT INTO spam_sms_phone (`phone`,`group_id`,`status`,`created_time`) VALUES $vals";
                $command = Yii::app()->db->createCommand($sql);
                $command->execute();
            }

            $this->redirect(array('view', 'id' => $model->id));
        }
    }
    
    /**
     * clone a Group 
     */
    public function actionCloneFilter() {
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $id = Yii::app()->request->getParam("id");
        $oldmodel = GroupModel::model()->findByPk($id);
        $model = new GroupModel;
        foreach ($oldmodel->attributes as $key => $val) {
            if ($key != "id")
            {
                if($key=="name")
                    $val.=" -- CLONE";
                $model[$key] = $val;
            }
        }

        if ($model->save()) {
            $phoneList = PhoneModel::model()->getPhoneGroup($id);           
            $arrayVal = array();
            foreach ($phoneList as $phone) {
                $phoneNum = $phone['phone'];
				
				if($phoneNum == '84946760402')
					$exist = false;
                else
					$exist = UserSubscribeModel::model()->exists("user_phone = :user_phone and expired_time >= '".date("Y-m-d H:i:s")."'", array(':user_phone' => $phoneNum));
                if($exist == false){
                    $exist3 = DeletedPhoneModel::model()->exists('phone = :phone', array(':phone' => $phoneNum));
                    if($exist3 == false){
                        $created_time = date("Y-m-d H:i:s");  
                        $mId = $model->id;
                        $arrayVal[] = "('$phoneNum',$mId,0,'$created_time')";
                    }
                    
                }
            }
            
            /**
             * Start insert here: split each 200 phone
             */
            $arrs = array_chunk($arrayVal, 200);
            foreach ($arrs as $arr) {
                $vals = implode(",", $arr);
                $sql = "INSERT INTO spam_sms_phone (`phone`,`group_id`,`status`,`created_time`) VALUES $vals";
                $command = Yii::app()->db->createCommand($sql);
                $command->execute();
            }

            $this->redirect(array('view', 'id' => $model->id));
        }
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

        if (isset($_POST['GroupModel'])) {
            $model->attributes = $_POST['GroupModel'];
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

        if (isset($_POST['GroupModel'])) {
            $model = new GroupModel();
            $model->attributes = $_POST['GroupModel'];
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
            $model = $this->loadModel($id);
            /* khong cho xoa nhom Test */
            if($model->name == 'TEST_GROUP')
                return  false;
            
            // we only allow deletion via POST request
            $model->delete();

            // delete all phones of group
            $sql = "DELETE FROM spam_sms_phone where group_id = " . $id;
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();

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
            GroupModel::model()->deleteAll();
        } else {
            $item = $_POST['cid'];
            $c = new CDbCriteria;
            $c->condition = ('id in (' . implode($item, ",") . ')');
            $c->params = null;
            GroupModel::model()->deleteAll($c);
        }
        $this->redirect(array('index'));
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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = GroupModel::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * @author tannew
     * Upload phone numbers to Group
     */
    public function actionUpload() {
        $message = "";
        $errorList = array(); // list of invalid Vinaphone phone
        $dupList = array(); //  list of duplicated phone
        $subscribeList = array(); // list subscribed phone   
        $arrayVal = array();
        $arr_filter = array();        
        
        $id = $_POST['group_id'];
        $source_file = $_POST['source_name'];//ten file excel
        
        $arr_filter['register_phone_filter'] = $_POST['register_phone_filter'];//checkbox: Kiem tra nhung so DT da dang ki
        $arr_filter['exist_group_filter'] = $_POST['exist_group_filter'];//checkbox: Loai bo nhung so DT da thuoc group khac
        $arr_filter['group_list'] = $_POST['group_list'];// danh sach cac Group muon loai bo cac so DT da thuoc chung
        $arr_filter['date_filter'] = $_POST['date_filter']; // text: Loc theo ngay
        $arr_filter['km_filter'] = $_POST['km_filter']; // chi lay nhung so DT dc huong KM de add vao group
        
        $group_id = $id;
        if (isset($source_file, $id)) {
            $fileName = _APP_PATH_ . DS . "public/admin/data" . DS . "tmp" . DS . $source_file;
            
            try {
                require_once 'excel_reader2.php';

                $data = new Spreadsheet_Excel_Reader($fileName, true, "UTF-8"); // khoi tao doi tuong doc file excel 
                $rowsnum = $data->rowcount($sheet_index = 0); // lay so hang cua sheet
                                
                for ($i = 1; $i <= $rowsnum; $i++) { // doc tu hang so 2 vi hang 1 la tieu de roi!
                    $phoneNum = $data->val($i, 1); // xuat cot so 1 va cot so 2 tren cung 1 hang
                    try {
                        $phoneNum = Formatter::formatMSISDN($phoneNum, "84,0", "84");
                        if (Formatter::isVinaphoneNumber($phoneNum)) {
                            $created_time = date("Y-m-d H:i:s");                            
                            
                            $exist = PhoneModel::model()->exists('group_id = :group_id AND phone= :phone', array(':phone' => $phoneNum, ':group_id' => $id));
                            if ($exist == false) {
                                try {
                                    $arrayVal[] = "('$phoneNum',$group_id,0,'$created_time')"; 
                                } catch (Exception $exc) {
                                    echo $exc->getMessage();
                                }
                            } else {
                                $dupList[] = $phoneNum;
                            }
                        } else {                            
                            $errorList[] = $phoneNum;
                        }
                    } catch (Exception $exc) {
                        echo $exc->getMessage();
                    }
                }                
                /**
                 * Start insert here: split each 200 phone
                 */
                $arrs = array_chunk($arrayVal, 200);
                foreach ($arrs as $arr) {
                    $vals = implode(",", $arr);
                    $sql = "INSERT INTO spam_sms_phone (`phone`,`group_id`,`status`,`created_time`) VALUES $vals";
                    $command = Yii::app()->db->createCommand($sql);
                    $command->execute();
                }
            } catch (Exception $exc) {
                echo $exc->getMessage();
            }
        }
        
        // delete phone in blacklist
        $sql = "DELETE spam_sms_phone.* FROM spam_sms_phone INNER JOIN deleted_phone on deleted_phone.phone = spam_sms_phone.phone WHERE spam_sms_phone.group_id = :gid";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":gid",$group_id);
        $command->execute();
        
        // Delete phone from spam_sms_reject_phone
        $sql = "DELETE spam_sms_phone.* FROM spam_sms_phone INNER JOIN spam_sms_reject_phone t2 on t2.phone = spam_sms_phone.phone WHERE spam_sms_phone.group_id = :gid";
        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(":gid",$group_id);
        $command->execute();
        
        // C1: delete phone Ko dc huong KM if km_filter = 1
        if($arr_filter['km_filter'] == "1"){
            $sql = "DELETE spam_sms_phone.* FROM spam_sms_phone INNER JOIN user_subscribe_km on user_subscribe_km.phone = spam_sms_phone.phone WHERE spam_sms_phone.group_id = :gid and (user_subscribe_km.type = 0 OR (user_subscribe_km.type = 1 AND user_subscribe_km.created_time >= date_sub(NOW(), interval 720 hour)))";
            $command = Yii::app()->db->createCommand($sql);
            $command->bindParam(":gid",$group_id);
            $command->execute();
        }        
        // C3: remove all Phone in selected groups
        if($arr_filter['exist_group_filter'] == "1"){
            if(!empty($arr_filter['group_list']) && count($arr_filter['group_list']) > 0){
                $listGroup = implode(',',$arr_filter['group_list']);
                $sql = "DELETE s1.* FROM spam_sms_phone s1 INNER JOIN spam_sms_phone s2 ON s1.phone = s2.phone WHERE s1.group_id = :gid and s2.group_id IN (:listId)";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindParam(":gid",$group_id);
                $command->bindParam(":listId",$listGroup);
                $command->execute();
            }
        }
        // C4: remove all Phone in groups have Cld which has been sent FROM...TO...
        if($arr_filter['date_filter'] != ""){
            // extract Time
            $filter_time = "";
            if (strrpos($arr_filter['date_filter'], "-")) { // example 8/13/2012 - 8/20/2012
                $arr_filter['date_filter'] = explode("-", $arr_filter['date_filter']);
                $fromDate = explode("/", trim($arr_filter['date_filter'][0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = explode("/", trim($arr_filter['date_filter'][1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $filter_time = array('from' => $fromDate.' 00:00:00', 'to' => $toDate. ' 23:59:59');
            } else { // single day 8/16/2012
                $time = explode("/", trim($arr_filter['date_filter']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);                                            
                $filter_time = array('from' => $time.' 00:00:00', 'to' => $time. ' 23:59:59');
            }

            // Select all groups have Cld which has been sent FROM...TO...
            $cri = new CDbCriteria;
            $cri->select = "group_id";
            $cri->addBetweenCondition('send_time', $filter_time['from'], $filter_time['to']);

            $listGroup = SpamSmsCldModel::model()->findAll($cri);
            $arrGr = array();
            foreach($listGroup as $group)
                $arrGr[] = $group->group_id;

            // check if this phone belongs to one of those groups                                        
            if(!empty($arrGr))
            {
                $listGroup = implode(',',$arrGr);
                $sql = "DELETE s1.* FROM spam_sms_phone s1 INNER JOIN spam_sms_phone s2 ON s1.phone = s2.phone WHERE s1.group_id = :gid and s2.group_id IN (:listId)";
                $command = Yii::app()->db->createCommand($sql);
                $command->bindParam(":gid",$group_id);
                $command->bindParam(":listId",$listGroup);
                $command->execute();
            }
        }
        
        // C2: remove Registered phone
        if($arr_filter['register_phone_filter']=="1"){
            $sql = "DELETE s1.* FROM spam_sms_phone s1 INNER JOIN user_subscribe u ON s1.phone = u.user_phone WHERE u.expired_time >= '".date("Y-m-d H:i:s")."' AND user_phone != '84946760402'";
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
        }
        
        /* Insert test phones to TEST_GROUP */
        $cri = new CDbCriteria;
        $cri->select = "phone";
        $cri->condition = "group_id = (SELECT id from spam_sms_group WHERE name= 'TEST_GROUP')";
        if($countTestPhone){
            $listPhones = PhoneModel::model()->findAll($cri);        
            $testPhones = array();
            foreach($listPhones as $phone){
                $phoneNum = $phone->phone;
                $created_time = date("Y-m-d H:i:s");
                $testPhones[] = "('$phoneNum',$id,0,'$created_time')";
            }
            $vals = implode(",", $testPhones);
            $sql = "INSERT INTO spam_sms_phone (`phone`,`group_id`,`status`,`created_time`) VALUES $vals";
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
        }        
        /* end Insert test phones */
        
        $phoneList = new PhoneModel;
        $phoneList->unsetAttributes();
        $phoneList->setAttribute('group_id', $id);

        Yii::app()->session['phoneList'] = $phoneList;
        Yii::app()->session['message'] = $message;
        Yii::app()->session['errorList'] = $errorList;
        Yii::app()->session['dupList'] = $dupList;
        Yii::app()->session['subscribeList'] = $subscribeList;
        
        $this->redirect(array('view', 'id' => $id));
    }

    /**
     * delete Phone number
     * $id  so Dien thoai can xoa
     * $group_id    Group dang view
     */
    public function actionDeletep() {
        $id = Yii::app()->request->getQuery('id');
        if ($id) {            
            $group_id = Yii::app()->request->getQuery('group_id');
            $id = intval($id);
            $group_id = intval($group_id);

            $sql = "DELETE FROM spam_sms_phone WHERE id = $id";
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
            $this->redirect(array('view', 'id' => $group_id));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

}
