<?php
class MobileDevice {
    public static function getInfo() {
        $deviceId = $modelName = "";
        
        // AMF was installed
        if (isset($_SERVER['AMF_ID'])) {
            $deviceId = isset($_SERVER['AMF_ID'])?$_SERVER['AMF_ID']:"";
            $modelName = isset($_SERVER['AMF_MODEL_NAME'])?$_SERVER['AMF_MODEL_NAME']:"";
        } else {
            if (!defined("WURFL_DIR")) {
                define("WURFL_DIR", Yii::getPathOfAlias("application.vendors.WURFL_CHACHA") . "/");
                define("RESOURCES_DIR", WURFL_DIR . "Resources/");
            }
            require_once WURFL_DIR . 'Application.php';
            //$wurflConfigFile = RESOURCES_DIR . 'wurfl-config.xml';
            //$wurflConfig = new WURFL_Configuration_XmlConfig($wurflConfigFile);

            $persistenceDir = RESOURCES_DIR.'storage/persistence';
            $cacheServer = Yii::app()->cache->getServers();
            $cache_host = $cacheServer[0]->host;
            $cache_port = $cacheServer[0]->port;
            
			$wurflConfig = new WURFL_Configuration_InMemoryConfig();
			$wurflConfig->wurflFile(RESOURCES_DIR.'wurfl.zip');
			$wurflConfig->matchMode('performance');
			$wurflConfig->persistence('file', array('dir' => $persistenceDir));
			$wurflConfig->cache('memcache', array('host' => $cache_host,'port'=>$cache_port, 'namespace'=>'wurfl', 'expiration' => 36000));
            
            $wurflManagerFactory = new WURFL_WURFLManagerFactory($wurflConfig);
            $wurflManager = $wurflManagerFactory->create();
            $device = $wurflManager->getDeviceForHttpRequest($_SERVER);
            $modelName = $device->getCapability("model_name");
            if (Utils::appleDevice('iPad')) {
                $deviceId = 'apple_ipad_ver1_sub42';
            } else {
                $deviceId = $device->id;
            }
        }
        
        return array(
            'deviceId' => $deviceId,
            'modelName' => $modelName,
        );
    }
    
    public static function getMobileOs() {
        $deviceOs = "";
        if (isset($_SERVER['AMF_DEVICE_OS'])) { // APACHE MOBILE FILTER IS INSTALLED
            $deviceOs = $_SERVER['AMF_DEVICE_OS'];
            if (stripos($deviceOs, "iphone") !== false) {
                $deviceOs = "IOS";
            } else if (stripos($deviceOs, "android") !== false) {
                $deviceOs = "ANDROIDOS";
            }
        } else {
            $detect = new Mobile_Detect();
            if ($detect->isiOS()) {
                $deviceOs = "IOS";
            } else if ($detect->isAndroidOS()) {
                $deviceOs = "ANDROIDOS";
            }
        }
        
        return $deviceOs;
    }
}
?>
