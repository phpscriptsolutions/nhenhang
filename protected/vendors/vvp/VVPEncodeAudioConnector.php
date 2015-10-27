<?php
class VVPEncodeAudioConnector {
	// Encode server infor
	private $_baseUrl = "http://192.168.4.41:6000";
	private $_apiKey	= "4bcf22bdcecc492daa230030780f92cf";
	private $_user = "thangtv2@vega.com.vn";
	private $_pass = "metfone123312";


	protected static $_instance = null;

	public function __construct($params) {
        if(isset($params['baseUrl'])) $this->_baseUrl = $params['baseUrl'];
		if(isset($params['apiKey'])) $this->_apiKey = $params['apiKey'];
		if(isset($params['user'])) $this->_user = $params['user'];
		if(isset($params['pass'])) $this->_pass = $params['pass'];
    }

	/**
	 * get list of profiles
	 */
	public function getProfiles() {
		$profiles = array();
		$params = array();
		$params['apikey'] = $this->_apiKey;
		$result = $this->_request('profiles', $params);
		if($result['ERROR'] == 0) {
			$data = $result['DATA'];
			if($data->code == 200) $profiles = $data->profiles;
		}

		return $profiles;
	}

	public function encode($requestOptions) {
		$optionStandard = array(
			"notify_url" => "",
			"grouping" => "",
		);
		$options = array_merge($optionStandard, $requestOptions);

		$params = array();
		$params['input'] = $options['input'];
		$params['notify_url'] = $options['notify_url'];
		$params['grouping'] = $options['grouping'];
		$params['apikey'] = $this->_apiKey;
		$params['meta'] = $options['meta'];
		$params['outputs'] = $options['outputs'];
		$result = $this->_request('encodes', $params, "POST");
		return $result;
	}

	/**
	 * Call api and return response data
	 * @param String $action Name of api action
	 * @param Array $params Array parameters that are sent to API server
	 * @return Array $apiResponse
	 */
	private function _request($action, $params, $method="GET") {
		$url = $this->_baseUrl."/$action";
		// timeout in seconds
		$timeOut = 10;
		$result = array(
			'ERROR' => 0,
			'ERROR_DESC' => "Success",
			'DATA' => array(),
		);

		try {
			$ch = curl_init();

			if($method=="POST") {	// POST JSON request
				curl_setopt($ch,CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($params));
				Yii::log("[POST] $url, ".json_encode($params), "trace", "ENCODE_REQUEST");
			} else {	// GET request
				$data = http_build_query($params);
				$url .= "?$data";
				curl_setopt($ch,CURLOPT_URL, $url);
				Yii::log("[GET] $url", "trace", "ENCODE_REQUEST");
			}
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, $timeOut);
			$rawData=curl_exec($ch);
			if(curl_errno( $ch ))
			{
				$result['ERROR'] = "404";
				$result['ERROR_DESC'] = curl_error($ch);
			}
			else
			{
				$result['DATA'] = json_decode($rawData);
			}
		} catch (Exception $e) {
			$result['ERROR'] = "500";
			$result['ERROR_DESC'] = $e->getMessage();
		}
		curl_close ($ch);

		// log to file
		$logLevel = ($result['ERROR'] == 0)? "trace": "error";
		Yii::log("$action: ERROR={$result['ERROR']}, MSG={$result['ERROR_DESC']}, DATA=$rawData", $logLevel, "ENCODE_REQUEST");

		return $result;
	}

}
?>
