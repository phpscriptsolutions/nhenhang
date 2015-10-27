<?php
class SmsClient
{
    private $smsWsdl;
    private $username;
    private $password;
    private $serviceName;

    protected static $_instance = null;
    public static function getInstance() {
    	if (null === self::$_instance) {
    		self::$_instance = new self();
    	}
    	return self::$_instance;
    }

    public function __construct()
    {
    	$this->smsWsdl = Yii::app()->params['smsClient']['smsWsdl'];
    	$this->username = Yii::app()->params['smsClient']['username'];
    	$this->password = Yii::app()->params['smsClient']['password'];
    	$this->serviceName = Yii::app()->params['smsClient']['serviceName'];
    }


  	//Sent MT with 9234
	public function sentMT($serviceNumber, $receiver, $msgType, $content, $charge, $description, $smsId, $senderPhone)
    {
    	$receiver = Formatter::formatPhone($receiver);
    	$content = Common::strNormal($content);
    	$description = Common::strNormal($description);
    	$ret = "";
    	if(!isset($serviceNumber) || !$serviceNumber)
    	{
    		$serviceNumber = Yii::app()->params['smsClient']['serviceNumber'];
    	}
    	if(!isset($senderPhone) || !$senderPhone)
    	{
    		$senderPhone = Yii::app()->params['smsClient']['serviceNumber'];
    	}

        try
        {
        	$timeOut = 600; // connection timeout in seconds
			@ini_set('default_socket_timeout', $timeOut);
        	Yii::log("Before call soap smsServer", "trace");

            $params = array('username' => $this->username,
                 'password' => $this->password,
                 'service_number' => $serviceNumber,
                 'sender' => $senderPhone,
                 'receiver' => $receiver,
                 'content' => $content,
                 'charge' => $charge,
                 'msg_type' => $msgType,
                 'subject' => $description,
                 'sms_id' => $smsId,
                 'smsc' => $serviceNumber,
            	 'priority'=>3
            	);
           Yii::log(json_encode($params),"info");

           $localMode = isset(Yii::app()->params['local_mode'])?Yii::app()->params['local_mode']:0;
           if(!$localMode){
	           	$client = new SoapClient($this->smsWsdl);
	           	$ret = $client->__soapCall('sendMT', $params);
           }
			//$ret->return = "0|Success";
            $this->sentLogging($ret, $serviceNumber, $receiver, $msgType, $content, $charge, $description, $smsId);
        } catch (Exception $e) {
        	Yii::log("Exception on call soap smsServer", "trace");
            $ret = "999|Exception|".$e->getMessage();
        }
        return $ret;

    }

    public function sentSmsText($phone,$content)
    {
    	$phone = Formatter::formatPhone($phone);
    	$localMode = isset(Yii::app()->params['local_mode'])?Yii::app()->params['local_mode']:0;
		if($localMode) {
			//$ret = $this->sentBy7x62($phone,$content);			
			$this->sentLogging("0|success", 7062, $phone, 0, $content, 0, "", 0);
			return  true;
		}

    	$return = false;
		$ret = $this->sentMT(Yii::app()->params['smsClient']['serviceNumber'], $phone, 0, $content, 0, "", time(), Yii::app()->params['smsClient']['serviceNumber']);
		if("0|success"==strtolower($ret)){
			$return = true;
		}
		return $return;
    }
    
    /*Sent MT by 7x62 via Chacha - for test*/
    function sentBy7x62($phone,$content)
    {
    	$url = "http://www.chacha.vn/test/sentmt";
    	$data["phone"] =  $phone;
    	$data["content"] =  $content;
    	//$result =  $this->postData($url, $data,"GET");
    	$url = $url."?".http_build_query($data,'','&');
    	$result = file_get_contents($url);
    	return trim($result);
    }

    function postData($url, $data,$type="POST") {
    	$ch = curl_init ();
    	$headers = array (
    			'Content-type: application/x-www-form-urlencoded'
    	);
    	$dataPost = array ();
    	foreach ( $data as $key => $value ) {
    		$dataPost [] = $key . "=" . urlencode ( $value );
    	}
    	$datastring = implode ( "&", $dataPost );
    	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    	curl_setopt($ch, CURLOPT_POST, 1);
    	if($type=="POST"){
    		curl_setopt ( $ch, CURLOPT_URL, $url );
    		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $datastring );
    	}else{
    		curl_setopt ( $ch, CURLOPT_URL, $url."?".$datastring );
    	}

    	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    	curl_setopt ( $ch, CURLOPT_VERBOSE, 1 );
    	$response = curl_exec ( $ch );
    	curl_close ( $ch );
    	return $response;
    }


   function sentLogging($status, $serviceNumber, $receiver, $msgType, $content, $charge, $description, $smsId)
    {
    	try {

    		$logSms 				= new LogSmsMtModel();
	    	$logSms->service_number = $serviceNumber;
	    	$logSms->sms_id 		= $smsId;
	    	$logSms->receive_phone  = $receiver;
	    	$logSms->send_datetime  = date("Y-m-d H:i:s");
	    	$logSms->sms_type 		= $msgType;
	    	$logSms->content 		= $content;
	    	$logSms->description 	= $description;
	    	$logSms->charge 		= $charge;
	    	$logSms->service_name   = $this->serviceName;
	    	$logSms->status 		= isset($status)? $status: '';
	    	$ret = $logSms->save();
	    	if(!$ret){
				$this->result['error'] = 'INSERT_LOG_SMS_MT_FAILED';
			 	//bmCommon::logFile("INSERT_LOG_SMS_MT_FAILED send to {$receiver} ","sendMT");
	    	}

    	}  catch (Exception $e){
			//log file
			echo $e->getMessage(); die();
			$this->result['error'] = 'INSERT_LOG_SMS_MT_FAILED';
		 	//bmCommon::logFile("INSERT_LOG_SMS_MT_FAILED send to {$receiver} ","sendMT");

		}
    }

    function _getSmsc($phone)
    {
    	if(strlen($phone) == 12){
			$sufix = substr($phone, 0,5);
    	}
    	if(strlen($phone) == 11){
			$sufix = substr($phone, 0,4);
    	}
    	$viettel = array(8497,8498,84165,84166,84167,84168,84169,84163,84162);
    	$vina = array(8491,8494,84123,84125,84127,84124,84129,84164);
    	$mobifone = array(8490,8493,84122,84121,84128,84120,84126) ;
    	$evn = array(8496);
    	$sfone = array(8495);
    	$vietnamobile = array(8492);
    	$beeline = array(84199);

		if(in_array($sufix, $viettel)) return 'viettel';
		if(in_array($sufix, $vina)) return 'vinaphone';
		if(in_array($sufix, $mobifone)) return 'mobifone';
		if(in_array($sufix, $evn)) return 'evn';
		if(in_array($sufix, $sfone)) return 'sfone';
		if(in_array($sufix, $vietnamobile)) return 'vietnamobile';
		if(in_array($sufix, $beeline)) return 'beeline';
    }

    function sendSpamSms($phonenumber, $message) {
        $url = "http://10.1.10.67:23013/cgi-bin/sendsms?username=vega&password=V394-K4NN3L&smsc=9234&from=9234";
        $apiUrl = $url."&to=".$phonenumber."&priority=0&text=".urlencode($message);
        $ch = curl_init($apiUrl);
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }
    
    /**
     *
     * get random password string
     * @param int $length
     * @return string
     */
    public static function randomPassword($length=6) {
    	$str = "0123456789abcdefghijklmopqrstuxyz";
    	$min = 0;
    	$max = strlen($str)-1;
    	$password = "";
    	for($i=0; $i<$length; $i++)
    	{
    	$char = $str[mt_rand($min, $max)];
    	$password .= $char;
    	}
    
    	return $password;
    	}
}
?>