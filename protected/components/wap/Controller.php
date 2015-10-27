<?php

/**
 * class Controller
 * define base controller
 */
class Controller extends CController {

    public $layout = '';
    public $device = null;
    public $deviceOs = null;
    public $deviceOsVer = null;
    public $headerText = "";
    public $configs = null;
    public $banners = null;
    public $deviceLayout = '';

    public function init() {
        // setup multi language
        self::_setupLanguage();

        if (!isset(Yii::app()->session['device'])) {
            $device = new DeviceHelper();
            $data = array();
            $data['os'] = $device->getOS();
            $data['os_version'] = $device->getVersionOS();
            $data['browse'] = $device->getBrowse();
            $data['browse_version'] = $device->getVersionBrowse();
            Yii::app()->session['device'] = $data;
        }
        $device = Yii::app()->session['device'];
        $this->deviceOs = $device['os'];
        $this->deviceOsVer = $device['os_version'];
        // get banners
        $this->banners = WapBannerModel::getBanner('wap');

        // load config from DB
        $wap_configs = Yii::app()->cache->get("WAP_CONFIG");
        if ($wap_configs === false) {
            $wap_configs = ConfigModel::model()->getConfig('', 'wap');
            Yii::app()->cache->set("WAP_CONFIG", $wap_configs, Yii::app()->params['cacheTime']);
        }

        if (!empty($wap_configs)) {
            foreach ($wap_configs as $key => $info) {
                $config_type = $info['type'];
                if ($config_type == "string")
                    Yii::app()->params[$key] = $info['value'];
                if ($config_type == "int")
                    Yii::app()->params[$key] = intval($info['value']);
                if ($config_type == "array")
                    Yii::app()->params[$key] = unserialize($info['value']);
            }
        }

        $this->updateCache();
        return parent::init();
    }

     /**
     * Cai dat da ngon ngu
     */
    private static function _setupLanguage() {
    	if(!isset(Yii::app()->request->cookies['lang'])){
    		$cookie = new CHttpCookie('lang', Yii::app()->params['defaultLanguage']);
    		$cookie->expire = time() + 60 * 60 * 24 * 7;
    		Yii::app()->request->cookies['lang'] = $cookie;
    	}
    	Yii::app()->language = trim(Yii::app()->request->cookies['lang']);    	
    }


    private function updateCache() {
        if (Yii::app()->request->getParam('resetcache', 0) === 1)
            Yii::app()->setComponent('cache', new CDummyCache());
    }

}
