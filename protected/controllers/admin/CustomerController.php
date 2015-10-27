<?php

@ini_set("max_execution_time", 300);
@ini_set("memory_limit", "1024M");
/*
  @author: GiangNh
 */

class CustomerController extends Controller {

    public $time;

    public function actionIndex() {
        $msisdn = Yii::app()->request->getParam('phone', null);
        $subscribe = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $msisdn = Formatter::formatPhone($msisdn);
            $subscribe = AdminUserSubscribeModel::model()->findByAttributes(array('user_phone' => $msisdn));
        }
        $this->render('index', compact('subscribe', 'msisdn'));
    }

    public function actionSubscriber() {
        if (isset($_GET['songreport']['date']) && $_GET['songreport']['date'] != "") {
            $createdTime = $_GET['songreport']['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['songreport']['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        $type = Yii::app()->request->getParam('type', null);
        $model = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $msisdn = Formatter::formatPhone($msisdn);
            $model = new AdminUserTransactionModel('search');
            $model->unsetAttributes();  // clear any default values
            if ($type == '0') {
                $model->_dkhuy = true;
            } elseif ($type == '1') {
                $model->setAttribute("transaction", "subscribe");
            } elseif ($type == '2') {
                $model->setAttribute("transaction", "unsubscribe");
            }
            $model->setAttribute('user_phone', $msisdn);

            $model->setAttribute('created_time', $this->time);
        }
        $this->render('subcriber', compact('model', 'msisdn', 'type'));
    }

    public function actionLog() {
        if (isset($_GET['date']) && $_GET['date'] != "") {
            $createdTime = $_GET['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        $type = Yii::app()->request->getParam('type', null);
        $model = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $msisdn = Formatter::formatPhone($msisdn);
            $model = new AdminUserTransactionModel('search');
            $model->unsetAttributes();  // clear any default values

            switch ($type) {
                case 0:
                    $model->_content = true;
                    break;
                case 1:
                    $model->setAttribute("transaction", "play_song");
                    break;
                case 2:
                    $model->setAttribute("transaction", "download_song");
                    break;
                case 3:
                    $model->setAttribute("transaction", "play_video");
                    break;
                case 4:
                    $model->setAttribute("transaction", "download_video");
                    break;
            }
            $model->setAttribute('user_phone', $msisdn);
            $model->setAttribute('created_time', $this->time);
        }
        $this->render('log', compact('model', 'msisdn', 'type', 'fromDate', 'toDate', 'time'));
    }

    protected function getGenreName($data, $row) {
        $genreArr = Yii::app()->session['genre'];
        if (isset($genreArr[$data->genre_id]))
            return $genreArr[$data->genre_id];
        else
            return "Nhạc Việt";
    }

    protected function getTransaction($data, $row) {
        switch ($data->transaction) {
            case "download_song":
                return "Tải bài hát";
                break;
            case "play_song":
                return "Nghe bài hát";
                break;
            case "play_video":
                return "Xem video";
                break;
            case "download_video":
                return "Tải video";
                break;
            case "download_ringtone":
                return "Tải nhạc chuông";
                break;
            case "play_album":
                return "Nghe album";
                break;
            case "subscribe":
                return "Đăng ký gói cước";
                break;
            case "unsubscribe":
                return "Hủy gói cước";
                break;
        }
        return "";
    }

    protected function getExtend($data, $row) {
        switch ($data->transaction) {
            case "extend_subscribe":
                return "Gia hạn";
                break;
            case "extend_subscribe_level1":
                return "Gia hạn lần 1";
                break;
            case "extend_remain":
                return "Gia hạn lần 2";
                break;
        }
        return "";
    }

    public function actionSms() {
        if (isset($_GET['date']) && $_GET['date'] != "") {
            $createdTime = $_GET['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        $type = Yii::app()->request->getParam('type', null);
        $smsMo = null;
        $smsMt = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $date['toTime'] = $toDate;
            $date['fromTime'] = $fromDate;
            //MO
            $smsMo = new AdminLogSmsMoModel('search');
            $smsMo->setAttribute('sender_phone', "=" . $msisdn);
            $smsMo->setAttribute('receive_time', $date);

            //MT
            $smsMt = new AdminLogSmsMtModel('search');
            $smsMt->setAttribute('receive_phone', "=" . $msisdn);
            $smsMt->setAttribute('send_datetime', $date);
        }
        $this->render('sms', compact('msisdn', 'smsMo', 'smsMt', 'fromDate', 'toDate'));
    }

    public function actionUserAction() {
        if (isset($_GET['date']) && $_GET['date'] != "") {
            $createdTime = $_GET['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        $msisdn = Formatter::formatMSISDN($msisdn);
        $model = new AdminUserTransactionModel('search');
        $model->unsetAttributes();  // clear any default values
        $model->setAttribute('created_time', $this->time);
        $model->setAttribute('user_phone', $msisdn);
        $this->render('useraction', compact('model', 'fromDate', 'toDate', 'msisdn'));
    }

    public function actionHistory() {

        if (isset($_GET['date']) && $_GET['date'] != "") {
            $createdTime = $_GET['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        $type = Yii::app()->request->getParam('type', null);
        $model = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $msisdn = Formatter::formatPhone($msisdn);
            $model = new AdminLogDetectMsisdnModel('search');
            $model->unsetAttributes();  // clear any default values
            $model->setAttribute('phone', $msisdn);
            $model->setAttribute('loged_time', $this->time);
        }
        $this->render('history', compact('model', 'msisdn', 'fromDate', 'toDate'));
    }

    public function actionExtend() {
        if (isset($_GET['date']) && $_GET['date'] != "") {
            $createdTime = $_GET['date'];
            if (strrpos($createdTime, "-")) {
                $createdTime = explode("-", $createdTime);
                $fromDate = explode("/", trim($createdTime[0]));
                $fromDate = $fromDate[2] . "-" . str_pad($fromDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($fromDate[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $fromDate . ' 00:00:00';
                $toDate = explode("/", trim($createdTime[1]));
                $toDate = $toDate[2] . "-" . str_pad($toDate[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($toDate[1], 2, '0', STR_PAD_LEFT);
                $toDate = $toDate . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            } else {
                $time = explode("/", trim($_GET['date']));
                $time = $time[2] . "-" . str_pad($time[0], 2, '0', STR_PAD_LEFT) . "-" . str_pad($time[1], 2, '0', STR_PAD_LEFT);
                $fromDate = $time . ' 00:00:00';
                $toDate = $time . ' 23:59:59';
                $this->time = array('from' => $fromDate, 'to' => $toDate);
            }
        } else {
            $fromDate = date('Y-m-d', strtotime('-7 days', time()));
            $fromDate = $fromDate . ' 00:00:00';
            $toDate = date('Y-m-d') . ' 23:59:59';
            $this->time = array('from' => $fromDate, 'to' => $toDate);
        }
        $msisdn = Yii::app()->request->getParam('phone', null);
        $type = Yii::app()->request->getParam('type', null);
        $model = null;
        if ($msisdn && Formatter::isPhoneNumber(Formatter::removePrefixPhone($msisdn))) {
            $msisdn = Formatter::formatPhone($msisdn);
            $model = new AdminUserTransactionModel('search');
            $model->unsetAttributes();  // clear any default values
            $model->_extend = true;
            $model->setAttribute('user_phone', $msisdn);
            $model->setAttribute('created_time', $this->time);
        }
        $this->render('extend', compact('model', 'msisdn', 'type', 'fromDate', 'toDate'));
    }

}
