<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class MainUserIdentity extends CUserIdentity {

    const ERROR_NONE = 0;
    const ERROR_USERNAME_INVALID = 8;
    const ERROR_PASSWORD_INVALID = 9;
    const ERROR_NOT_SUBSCRIBE = 10;
    const ERROR_EXPIRED_TRIAL = 11;
    const ERROR_TRIAL_MODE = 12;
    const ERROR_NOT_DETECT_MSISDN = -1;
    const ERROR_3G_NOT_SUBSCRIBE = 16;
    const ERROR_3G_NOT_USER = 17;

    public $_msisdn;
    private $_package;
    static $_os;

    /**
     * function _detectMSISDN
     * call to detect user phone number
     * @return string $phone
     */
    static function _detectMSISDN($channel = 'wap', $deviceId = NULL, $os = '') {
        $localMode = isset(Yii::app()->params['local_mode']) ? Yii::app()->params['local_mode'] : 0;
        $phone = '';
        if (isset($_GET['test']) && $_GET['test'] != "") {
            switch ($_GET['test']) {
                case 1:
                    $phone = "84901234567";
                    break;
                case 2:
                    $phone = "855977512314";
                    break;
                case 3:
                    $phone = "855883555993";
                    break;
            }
            Yii::log($phone, 'detectMsisdn', 'test');
            self::_logDetectMSISDN($phone, "TEST", $channel, $deviceId);
            return $phone;
        }

        $msisdn = "";
        $msisdn = isset($_SERVER['HTTP_X_WAP_MSISDN']) ?  $_SERVER['HTTP_X_WAP_MSISDN'] : $msisdn;
        $msisdn = isset($_SERVER['X_WAP_MSISDN']) ?  $_SERVER['X_WAP_MSISDN'] : $msisdn;
        $msisdn = isset($_SERVER['MSISDN']) ?  $_SERVER['MSISDN'] : $msisdn;
        $msisdn = isset($_SERVER['HTTP_MSISDN']) ?  $_SERVER['HTTP_MSISDN'] : $msisdn;
        if (isset($msisdn[0]) && $msisdn[0] == '0') {
            $msisdn = '855' . substr($msisdn, 1);
        }
        if ($msisdn != "") {
            $phone = $msisdn;
        }

        // Log to file
        self::_logDetectMSISDN($phone, '', $channel, $deviceId);

        self::$_os = !empty($os) ? $os : '';
        return $phone;
    }

    public function getId() {
        return $this->_msisdn;
    }

    /**
     * Log nhan dien thue bao
     * @param string $phone
     * @param string $type
     */
    protected static function _logDetectMSISDN($phone, $type, $channel = 'wap', $deviceId=null) {
        if (!isset($deviceId))
            $deviceId = yii::app()->session['deviceId'];
        // log to file
        $xAddress = isset($_SERVER['HTTP_X_IPADDRESS']) ? $_SERVER['HTTP_X_IPADDRESS'] : '';
        Yii::log('PHONE:' . $phone . ' |-|REMOTE_ADDR:' . $_SERVER['REMOTE_ADDR'] . ' |-| HTTP_X_IPADDRESS:' . $xAddress . ' |-|DEVICE:' . Yii::app()->session['deviceId'], 'detectMsisdn', $type);
        $os = self::$_os;
        // log to DB
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "";
        $userSubscribe = UserSubscribeModel::model()->get($phone); //get user_subscribe record by phone
        $packageId = $userSubscribe ? $userSubscribe->package_id : 0;
        $event = $userSubscribe ? $userSubscribe->event : '';
        $referral = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "";
        LogDetectMsisdnModel::model()->logDetect($phone, $_SERVER['REMOTE_ADDR'], $deviceId, $channel, 1, $type, $os, $userAgent, $packageId, $event, $referral, $uri);
    }

    /**
     * 
     */
    private function isOperaBrowse() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($userAgent, 'Opera') !== false) {
            return true;
        }
        return false;
    }

}
