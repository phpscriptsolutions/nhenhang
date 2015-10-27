<?php
include_once _APP_PATH_."/protected/components/common/Mobile_Detect.php";
class DeviceHelper{
    public $device;
    public $os;
    public $version_os;
    public $browse;
    public $version_browse;
    public $os_all;
    public function __Construct()
    {
        if(empty($this->device)){
            $this->device = new Mobile_Detect();
            $this->os_all = $this->device->getOperatingSystems();
            $this->browse_all = $this->device->getBrowsers();
        }
    }
    public function getOS()
    {
        foreach($this->os_all as $os => $ua){
            $isOs = $this->device->is($os);
            if($isOs){
                if($os!='iOS') {
                    $os = str_replace('OS', '', $os);
                }
                $this->os = $os;
                return $this->os;
            }
        }
        return 'default';
    }
    public function getVersionOS()
    {
        if(empty($this->os)){
            $this->getOS();
        }
        $this->version_os = $this->device->version($this->os);
        return $this->version_os;
    }
    public function getBrowse()
    {
        foreach($this->browse_all as $br => $ua){
            $isBr = $this->device->is($br);
            if($isBr){
                $this->browse = $br;
                return $this->browse;
            }
        }
        return 'default';
    }
    public function getVersionBrowse()
    {
        if(empty($this->browse)){
            $this->getBrowse();
        }
        $this->version_browse = $this->device->version($this->browse);
        return $this->version_browse;
    }
    public function getPlatform()
    {
        $deviceType = ($this->device->isMobile() ? ($this->device->isTablet() ? 'tablet' : 'phone') : 'computer');
        return $deviceType;
    }
}