<?php
Yii::import("ext.EAjaxUpload.EAjaxUploadAction");
class EAjaxUpload extends EAjaxUploadAction{
    public $path;
    public $_subfolder;

    public function run(){
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array("jpg");
        // max file size in bytes
        $sizeLimit = $this->toBytes(ini_get('post_max_size'));

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $this->_subfolder = "tmp";
        $path = $this->path."/".$this->_subfolder."/";

        $result = $uploader->handleUpload($path);
        // to pass data through iframe you will need to encode all html tags
        $result=htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        echo $result;
    }

    private function toBytes($str){
        $val = trim($str);
        $last = strtolower($str[strlen($str)-1]);
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        return $val;
    }
}