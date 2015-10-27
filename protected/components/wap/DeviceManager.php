<?php
if (!defined("WURFL_DIR")) {
	define("WURFL_DIR", Yii::getPathOfAlias("application.vendors.WURFL_CHACHA") . "/");
	define("RESOURCES_DIR", WURFL_DIR . "Resources/");
}
class DeviceManager
{
	protected static $_instance = null; //Singleton

	private $_device = null;
	public $brand = null;
	public $model = null;

	private $wurflManager;
	private $_BASIC_INFO = array(
            'brand_name',
            'model_name',
            'resolution_width',
            'resolution_height',
			'playback_3gpp',
			'ajax_support_javascript',
			'pointing_method',
			'device_os',
			'device_os_version',
			'html_preferred_dtd'
			/*
			 'video_mp4',
			 'streaming_video_vcodec_h264',
			 'streaming_vcodec_h264_bp',
			 'playback_vcodec_h264_bp',
			 'video_vcodec_h264',
			 'video_vcodec_mpeg4'
			 */
	);

	public function __construct()
	{
		require_once WURFL_DIR.'Application.php';

		/* $persistenceDir = RESOURCES_DIR.'storage/persistence';
		$cacheDir = RESOURCES_DIR.'storage/cache'; */

		$persistenceDir = dirname(_APP_PATH_) . DIRECTORY_SEPARATOR . "runtime" .DIRECTORY_SEPARATOR.'WURFL/storage/persistence';
		$cacheDir = dirname(_APP_PATH_) . DIRECTORY_SEPARATOR . "runtime" .DIRECTORY_SEPARATOR.'WURFL/storage/cache';

		$cacheServer = Yii::app()->cache->getServers();
		$cache_host = $cacheServer[0]->host;
		$cache_port = $cacheServer[0]->port;

		$wurflConfig = new WURFL_Configuration_InMemoryConfig();
		$wurflConfig->wurflFile(RESOURCES_DIR.'wurfl.zip');
		$wurflConfig->matchMode('performance');
		$wurflConfig->persistence('file', array('dir' => $persistenceDir));
		//$wurflConfig->cache('memcache', array('host' => $cache_host,'port'=>$cache_port, 'namespace'=>'wurfl', 'expiration' => 36000));
		$wurflConfig->cache('file', array('dir' => $cacheDir, 'expiration' => 36000));


		$wurflManagerFactory = new WURFL_WURFLManagerFactory($wurflConfig);
		$this->wurflManager = $wurflManager = $wurflManagerFactory->create();

		if(isset($_REQUEST['userAgent']))
		{
			$userAgent = $_REQUEST['userAgent'];
			$this->_device = $wurflManager->getDeviceForUserAgent($userAgent);
		}
		elseif (isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])) {
			$userAgent = $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'];
			$this->_device = $wurflManager->getDeviceForUserAgent($userAgent);
		}
		else
		{
			$this->_device = $wurflManager->getDeviceForHttpRequest($_SERVER);
		}

		$this->brand = strtolower($this->_device->getCapability('brand_name'));
		$this->model = strtolower($this->_device->getCapability('model_name'));
	}

	public static function getInstance()
	{
		if (null === self::$_instance)
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function getDevice()
	{
		return $this->_device;
	}

	public function getDeviceID()
	{
		return $this->_device->id;
	}

	public function getBasicInfo() {
		$info = Array();
		$info['deviceID'] = $this->getDeviceID();
		foreach ($this->_BASIC_INFO as $cap) {
			$info[$cap] = $this->_device->getCapability($cap);
		}
		return $info;
	}

	public function getAllInfo() {
		$data = Array();
		$groups = $this->wurflManager->getListOfGroups();
		foreach ($groups as $group) {
			$caps = $this->wurflManager->getCapabilitiesNameForGroup($group);
			foreach ($caps as $cap) {
				$info = $this->_device->getCapability($cap);
				$data[$cap] = $info;
			}
		}
		return $data;
	}

	public function getInfo($infoName) {
		return $this->_device->getCapability($infoName);
	}

	public function isWirelessDevice()
	{
		return $this->_device->getCapability('is_wireless_device');
	}

	public function isBlackBerryClassic() {
		return (($this->brand == 'rim') && ($this->model != 'blackberry 9000'));
	}

	public function isBlackBerryBold() {
		return ($this->brand == 'rim') && ($this->model == 'blackberry 9000');
	}

	public function getDeviceOs()
	{
		$deviceOs = $this->getInfo('device_os');
		$log = new KLogger('BETA_M', KLogger::OFF);
		$log->LogInfo("M LOG: |$deviceOs:".$deviceOs, false);
		
		if(strtoupper($deviceOs) == 'IOS'){
			return  'IOS';
		}
		if(strtoupper($deviceOs) == 'ANDROID'){
			return  'ANDROIDOS';
		}
		if(strtoupper($deviceOs) == 'WINDOWS PHONE OS'){
			return  'WINDOWOS';
		}
		return strtoupper($deviceOs);
	}

	public function isDevice($type = 'tablet')
	{
		switch ($type){
			case 'table':
				$is_table = $this->getInfo('is_tablet');
				if(is_tablet == 'true')
					return true;
				break;
			case 'mobile':
				$is_wireless_device = $this->getInfo('is_wireless_device');
				if($is_wireless_device == 'true'){
					return true;
				}
				break;
		}
		return false;
	}
	
	public function getOsVersion()
	{
		$detect = new Mobile_Detect;
		if($this->getDeviceOs()=="IOS"){
			return $detect->version('iPhone');
		}
		
		if($this->getDeviceOs()=="ANDROID"){
			return $detect->version('Android');
		}
		return 0;		
	}
}
